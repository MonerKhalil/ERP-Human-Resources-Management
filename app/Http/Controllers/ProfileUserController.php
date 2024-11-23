<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\HelpersClasses\MyApp;
use App\Http\Requests\UserRequest;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class ProfileUserController extends Controller
{
    public function ShowProfile(): Response|RedirectResponse|null
    {
        $user = \auth()->user();
        return $this->responseSuccess("System.Pages.Actors.profile",compact('user'));
    }

    /**
     * @param UserRequest $request
     * @return Response|RedirectResponse|null
     * @throws MainException
     * @author moner khalil
     */
    public function UpdateProfile(UserRequest $request): Response|RedirectResponse|null
    {
        $user = \auth()->user();
        $dataRequest = Arr::except($request->validated(),['old_password','new_password']);
        if (isset($dataRequest['image'])){
            $dataRequest['image'] = MyApp::Classes()->storageFiles
                ->Upload($dataRequest['image'],UserController::Folder);
            MyApp::Classes()->storageFiles->deleteFile($user->image);
        }
        if (isset($request->old_password)){
            if (password_verify($request->old_password,$user->password)){
                $dataRequest['password'] = Hash::make($request->new_password);
            }else{
                throw new MainException("password_error");
            }
        }
        if (isset($dataRequest['role'])){
            unset($dataRequest['role']);
        }
        $user->update($dataRequest);
        return $this->responseSuccess(null,null,"update",null,true);
    }
}
