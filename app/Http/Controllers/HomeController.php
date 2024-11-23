<?php

namespace App\Http\Controllers;

use App\Services\DataHomeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    public function HomeView(DataHomeService $homeService): Response
    {
        return response()->view("System/Pages/home",$homeService->getAllData());
    }
}
