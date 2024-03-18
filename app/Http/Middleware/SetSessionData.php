<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetSessionData
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
        if (!$request->session()->has('user')) {

            $user = Auth::user();
            $session_data = ['id' => $user->id,
                            'surname' => $user->surname,
                            'first_name' => $user->first_name,
                            'last_name' => $user->last_name,
                            'email' => $user->email,
                            'business_id' => $user->business_id,
                            'language' => $user->language,
                            ];
            $business = Business::findOrFail($user->business_id);
  

            $request->session()->put('user', $session_data);
            $request->session()->put('business', $business); 

        }

        return $next($request);
    }
}
