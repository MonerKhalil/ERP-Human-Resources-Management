<?php

namespace App\HelpersClasses;

use Illuminate\Http\Response;

class ExportPDF
{
    public static function viewPDF(array $head ,mixed $body){
        return self::PDF($head,$body)->stream();
    }

    public static function downloadPDF(array $head ,mixed $body,string $blade = null,$fileName = null): Response
    {
        $fileName = is_null($fileName) ? "document".time() : $fileName;
        return self::PDF($head,$body,$blade);
    }

    /**
     * @param $head
     * @param $body
     * @return mixed
     * @author moner khalil
     */
    private static function PDF($head , $body,$blade = null)
    {
        $blade = is_null($blade) ? "System.Pages.Docs.tablePrint" : $blade;
        return \response()->view($blade,[
            "data" => [
                "head" => $head,
                "body" => $body,
            ]
        ]);
//        ini_set("pcre.backtrack_limit", "5000000");
//        return \PDF::loadView($blade, [
//            "data" => [
//                "head" => $head,
//                "body" => $body,
//            ]
//        ]);
    }
}
