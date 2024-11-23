<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\Exports\TableCustomExport;
use App\HelpersClasses\ExportPDF;
use App\HelpersClasses\MyApp;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Exceptions\UnauthorizedException;

class UserController extends Controller
{
    const Folder = "users";
    const IndexRoute = "users.index";

    public function __construct()
    {
        $table = app(User::class)->getTable();
        $this->addMiddlewarePermissionsToFunctions($table);
        $this->middleware("permission:delete_".$table."|all_".$table)
            ->only(["MultiUsersForceDelete","MultiUsersDelete","forceDelete"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response|RedirectResponse|null
     * @author moner khalil
     */

    public function index(): Response|RedirectResponse|null
    {
        $users = MyApp::Classes()->Search->getDataFilter(User::query()->whereNot("id",auth()->id()));
        return $this->responseSuccess("System.Pages.Actors.Admin.viewUsers",compact("users"));
    }

    /**
     * @return Response|RedirectResponse|null
     * @author moner khalil
     */
    public function create(): Response|RedirectResponse|null
    {
        $roles = Role::query()->pluck('name','id')->toArray();
        return $this->responseSuccess("System.Pages.Actors.Admin.addUser",compact("roles"));
    }


    /**
     * @param UserRequest $request
     * @return RedirectResponse
     * @throws MainException
     * @author moner khalil
     */
    public function store(UserRequest $request): RedirectResponse
    {
        try {
            $dataRequest = Arr::except($request->validated(),['password','role']);
            $dataRequest['password'] = Hash::make($request->password);
            if (isset($dataRequest['image'])){
                $dataRequest['image'] = MyApp::Classes()->storageFiles->Upload($dataRequest['image'],self::Folder);
            }
            DB::beginTransaction();
            $user = User::query()->create($dataRequest);
            $user->assignRole($request->role);
            DB::commit();
            return $this->responseSuccess(null,null,"create",self::IndexRoute);
        }catch (\Exception $exception){
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }

    /**
     * @param User $user
     * @return Response|RedirectResponse|null
     * @author moner khalil
     */
    public function show(User $user): Response|RedirectResponse|null
    {
        $auth = auth()->user();
        $user = User::with("employee")->findOrFail($user->id);
        if ($auth->id == $user->id || $auth->can("read_users") || $auth->can("all_users")){
            $roles = Role::query()->pluck('name','id')->toArray();
            return $this->responseSuccess("System.Pages.Actors.profile" ,
                compact('user','roles'));
        }
        throw UnauthorizedException::forPermissions(["read_users","all_users"]);
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return RedirectResponse
     * @throws MainException
     * @author moner khalil
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        try {
            $dataRequest = Arr::except($request->validated(),['password','role']);
            if (isset($dataRequest['image'])){
                $dataRequest['image'] = MyApp::Classes()->storageFiles->Upload($dataRequest['image'],self::Folder);
                MyApp::Classes()->storageFiles->deleteFile($user->image);
            }
            if (isset($request->password)){
                $dataRequest['password'] = Hash::make($request->password);
            }
            DB::beginTransaction();
            $user->update($dataRequest);
            $user->syncRoles($request->role);
            DB::commit();
            return $this->responseSuccess(null,null,"update",self::IndexRoute);
        }catch (\Exception $exception){
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }

    /**
     * @param User $user
     * @return RedirectResponse
     * @author moner khalil
     */
    public function destroy(Request $request,User $user): RedirectResponse
    {
        if ($user->id == auth()->id()){
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            $return = "logout";
        }else{
            $return = self::IndexRoute;
        }
        $user->delete();
        return $this->responseSuccess(null,null,"delete",$return);
    }

    /**
     * @param BaseRequest $request
     * @return mixed
     * @throws MainException
     * @author moner khalil
     */
    public function MultiUsersDelete(BaseRequest $request): mixed
    {
        $request->validate([
            "users" => ["required","array"],
            "users.*" => ["required",Rule::exists("users","id")],
        ]);
        $Delete = $this->ForceDeleteProcess(false,$request->users);
        return !is_string($Delete) ? $this->responseSuccess(null,null,"delete",self::IndexRoute)
            : throw new MainException($Delete);
    }

    /**
     * @param User $user
     * @return Response|RedirectResponse|null
     * @author moner khalil
     */
    public function forceDelete(User $user): Response|RedirectResponse|null
    {
        $img = $user->image;
        $user->forceDelete();
        MyApp::Classes()->storageFiles->deleteFile($img);
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }


    /**
     * @param BaseRequest $request
     * @return mixed
     * @throws MainException
     * @author moner khalil
     */
    public function MultiUsersForceDelete(BaseRequest $request): mixed
    {
        $request->validate([
            "users" => ["required","array"],
            "users.*" => ["required",Rule::exists("users","id")],
        ]);
        $Delete = $this->ForceDeleteProcess(true,$request->users);
        return !is_string($Delete) ? $this->responseSuccess(null,null,"delete",self::IndexRoute)
            : throw new MainException($Delete);
    }

    /**
     * @param bool $isForce
     * @param array $users
     * @return bool
     * @author moner khalil
     */
    private function ForceDeleteProcess(bool $isForce = false, array $users): bool
    {
        try {
            $images = [];
            DB::beginTransaction();
            foreach ($users as $user){
                $user = User::query()->find($user);
                if ($isForce){
                    $images[] = $user->image;
                    $user->forceDelete();
                }else{
                    $user->delete();
                }
            }
            DB::commit();
            MyApp::Classes()->storageFiles->deleteFile($images);
            return true;
        }catch (\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function ExportXls(BaseRequest $request)
    {
        $data = $this->MainExportData($request);
        return Excel::download(new TableCustomExport($data['head'],$data['body']),self::Folder.".xlsx");
    }

    public function ExportPDF(BaseRequest $request)
    {
        $data = $this->MainExportData($request);
        return ExportPDF::downloadPDF($data['head'],$data['body']);
    }

    /**
     * @param BaseRequest $request
     * @return array
     * @author moner khalil
     */
    private function MainExportData(BaseRequest $request): array
    {
        $request->validate([
            "users" => ["sometimes","array"],
            "users.*" => ["sometimes",Rule::exists("users","id")],
        ]);
        $head = [
            "name" , "email" , "created_at",
        ];
        $query = User::query()->select($head)->whereNot("id",auth()->id());
        $query = isset($request->users) ? $query->whereIn("id",$request->users) : $query;
        $users = MyApp::Classes()->Search->getDataFilter($query,null,true);
        return [
            "head" => $head,
            "body" => $users,
        ];
    }
}
