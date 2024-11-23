<?php

namespace App\Providers;

use App\Http\Views\NotificationComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        View::composer(NotificationComposer::view, NotificationComposer::class);
//        foreach ($this->getComposerClasses() as $composerClass => $viewPage) {
//            View::composer($viewPage, $composerClass);
//        }
    }

    /**
     * @return array
     */
    private function getComposerClasses(): array
    {
//        $result = [];
//        $ViewComposer = scandir(app_path("Http/Views"));
//        foreach ($ViewComposer as $file) {
//            $file = pathinfo($file, PATHINFO_FILENAME);
//            $class = "App\\Http\\Views\\" . $file;
//            $result["App\Http\Views\\" . $file] = (new $class)::view;
//        }
//        return $result;
    }
}
