<?php

namespace App\Http\Controllers;

use App\HelpersClasses\MyApp;
use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    const IndexRoute = "roles.index";

    public function __construct()
    {
        $this->addMiddlewarePermissionsToFunctions(app(Role::class)->getTable());
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response|RedirectResponse|null
     */
    public function index(): Response|RedirectResponse|null
    {
        $data = MyApp::Classes()->Search->getDataFilter(Role::query());
        return $this->responseSuccess("System.Pages.Actors.Admin.viewRoles",compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response|RedirectResponse|null
     */
    public function create(): Response|RedirectResponse|null
    {
        $permissions = Permission::query()->get(["id","name"]);
        return $this->responseSuccess("System.Pages.Actors.Admin.roleAdd",compact("permissions"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return RedirectResponse|Response|null
     * @author moner khalil
     */
    public function store(RoleRequest $request): Response|RedirectResponse|null
    {
        $role = Role::query()->create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        return $this->responseSuccess(null,null,"create",self::IndexRoute);
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return Response
     * @author moner khalil
     */
    public function edit(Role $role)
    {
        $permissions = Permission::query()->get(["id","name"]);
        $rolePermissions = $role->permissions;
        return $this->responseSuccess("System.Pages.Actors.Admin.roleAdd"
            ,compact('role','permissions','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param Role $role
     * @return Response
     * @author moner khalil
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->update(["name"=>$request->name]);
        $role->syncPermissions($request->permissions);
        return $this->responseSuccess(null,null,"update",self::IndexRoute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return Response
     * @author moner khalil
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function MultiDelete(Request $request)
    {
        $request->validate([
            "ids" => ["array","required"],
            "ids.*" => ["required",Rule::exists("roles","id")],
        ]);
        Role::query()->whereIn("id",$request->ids)->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }
}
