<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Superadmin
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
        $administrator_list = config('constants.administrator_usernames');

        if (!empty($request->user()) && in_array(strtolower($request->user()->username), explode(',', strtolower($administrator_list)))) {
            return $next($request);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
