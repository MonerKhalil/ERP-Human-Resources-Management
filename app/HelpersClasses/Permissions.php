<?php

namespace App\HelpersClasses;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class Permissions
{
    public static function getUsersForPermission(string $namePermission){
        return User::query()->whereHas("roles.permissions",function ($query) use ($namePermission){
            $query->where('name', $namePermission);
        })->get();
    }

    private static function Process_Permissions(): array
    {
        return array_values(self::getFileRolesPermissions()['process']);
    }

    /**
     * @param string $key
     * @param array|null $arr
     * @return array
     * @author moner khalil
     */
    public static function getPermissions(string $key,array $arr = null): array
    {
        $final = self::Process_Permissions();
        if (!is_null($arr)){
            $final = $arr;
        }
        return Arr::map($final,function ($ele) use ($key){
            return $ele . "_" . $key;
        });
    }

    /**
     * @param string $key
     * @param array $except
     * @return array
     * @author moner khalil
     */
    public static function ExceptPermissions(string $key, array $except): array
    {
        $final = Arr::except(array_flip(self::Process_Permissions()),$except);
        return self::getPermissions($key,array_flip($final));
    }

    /**
     * @param string $key
     * @param array $only
     * @return array
     * @author moner khalil
     */
    public static function OnlyPermissions(string $key, array $only): array
    {
        $final = Arr::only(array_flip(self::Process_Permissions()),$only);
        return self::getPermissions($key,array_flip($final));
    }

    /**
     * @param string $key
     * @param array $add
     * @return array
     * @author moner khalil.............................................update....
     */
    public static function AddPermissions(string $key, array $add): array
    {
        return self::getPermissions($key,array_merge(self::Process_Permissions() ,$add));
    }

    /**
     * @description create roles (with permissions and user) in db in RoleSeeder
     * @author moner khalil
     */
    public static function addRolesAndUsersInSeeder(){
        $file = self::getFileRolesPermissions();
        $roles = $file['roles'];
        $allProcess = $file['process'];
        foreach ($roles as $role => $permissions){
            $role = Role::create(['name' => $role]);
            foreach ($permissions as $table => $process){
                $permissionsRoles = Permission::query()
                    ->whereIn("name",self::getAllProcessKeys($table,$process,$allProcess))
                    ->pluck("id","id")->all();
                $role->givePermissionTo($permissionsRoles);
            }
            $user = User::create([
                "name" => $role->name,
                "email" => $role->name."@"."system.com",
                "password" => Hash::make("123123123"),
            ]);
            $user->assignRole([$role->id]);
        }
    }

    /**
     * @param string $table
     * @param mixed $Process
     * @param array $allProcess
     * @return array
     * @author moner khalil
     */
    private static function getAllProcessKeys(string $table,mixed $Process,array $allProcess): array
    {
        $finalProcess = [];
        if (is_array($Process)){
            foreach ($Process as $process){
                $finalProcess[] = $allProcess[$process] . "_" . $table;
            }
            return $finalProcess;
        }
        $finalProcess [] = $allProcess[$Process] . "_" . $table;
        return $finalProcess;
    }

    /**
     * @author moner khalil
     */
    private static function getFileRolesPermissions():array
    {
        return json_decode(File::get(app_path("Roles_Permissions_Config/roles.json")), true);
    }

}
/*
$user->assignRole('writer');
$user->removeRole('writer');
$user->syncRoles(params);
$role->givePermissionTo('edit articles');
$role->revokePermissionTo('edit articles');
$role->syncPermissions(params);
$permission->assignRole('writer');
$permission->removeRole('writer');
$permission->syncRoles(params);
 * */
