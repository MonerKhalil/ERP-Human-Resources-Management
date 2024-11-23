<?php

namespace App\Http\Controllers;

use App\HelpersClasses\TResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests,TResponse;

    protected function addMiddlewarePermissionsToFunctions(string $table){
        $this->middleware(["permission:read_".$table."|all_".$table])->only(["index","show"]);
        $this->middleware(["permission:create_".$table."|all_".$table])->only(["create","store"]);
        $this->middleware(["permission:update_".$table."|all_".$table])->only(["edit","update"]);
        $this->middleware(["permission:delete_".$table."|all_".$table])->only(["destroy","MultiDelete"]);
        $this->middleware(["permission:export_".$table."|all_".$table])->only(["ExportPDF","ExportXls"]);
    }
}
