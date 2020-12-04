<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Defined\ResponseDefined;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $bearer_token = explode(' ', $request->header('Authorization'))[1];
        dd($bearer_token);
        $auth_info = Session::get('auth_info');
        $response = ['status' => ResponseDefined::SUCCESS];
        $token = $auth_info['access_token'];

        dd(auth('admin')->setToken($token)->user());
        if (!$auth_info['access_token']) {

        } elseif (!auth('admin')->setToken($token)->user()) {

        }

        return $next($request);
    }
}
