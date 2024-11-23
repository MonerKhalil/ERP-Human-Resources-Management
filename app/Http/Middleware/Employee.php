<?php

namespace App\Http\Middleware;

use App\Exceptions\MainException;
use Closure;
use Illuminate\Http\Request;

class Employee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if (is_null($user->employee)){
            throw new MainException(__("err_user_not_employee"));
        }
        return $next($request);
    }
}
