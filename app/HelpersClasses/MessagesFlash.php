<?php

namespace App\HelpersClasses;

use Illuminate\Support\Facades\Session;

class MessagesFlash
{
    public static $suc = "Success";
    public static $err = "Error";
    public static $Errors = "Errors";

    /**
     * @param string $process
     * @return mixed
     * @author moner khalil
     */
    private static function Messages(string $process): mixed
    {
        $msg = [
            "create" => __("suc.create"),
            "update" => __("suc.update"),
            "delete" => __("suc.delete"),
            "default" => __("suc.default"),
        ];
        return $msg[$process] ?? $msg['default'];
    }

    /**
     * @param string $process
     * @author moner khalil
     */
    public static function Success(string $process = ""){
        Session::flash(self::$suc,self::Messages($process));
    }

    /**
     * @param mixed $errors
     * @author moner khalil
     */
    public static function Errors(mixed $errors){
        if (is_array($errors)){
            Session::flash(self::$err,$errors);
        }else{
            Session::flash(self::$err,__($errors));
        }
    }
}
