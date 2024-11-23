<?php

namespace App\HelpersClasses;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

trait TResponse
{
    /**
     * @param string|null $ViewName
     * @param mixed|null $Data
     * @param string|null $msgProcess
     * @param string|null $RouteName
     * @param bool $isBack
     * @param array|null $parametersRouteName
     * @return Response|RedirectResponse|null
     * @author moner khalil
     */
    public function responseSuccess(
        string $ViewName = null, mixed $Data = null,
        string $msgProcess = null, string $RouteName = null, bool $isBack = false,
        array $parametersRouteName = []
    ): Response|RedirectResponse|null
    {
        if (!is_null($msgProcess)){
            MessagesFlash::Success($msgProcess);
        }
        if (!is_null($ViewName)){
            return !is_null($Data) ? response()->view($ViewName,$Data) : response()->view($ViewName);
        }
        if ($isBack){
            return redirect()->back();
        }
        if (!is_null($RouteName)){
            return redirect()->route($RouteName,$parametersRouteName);
        }
        return null;
    }
}
