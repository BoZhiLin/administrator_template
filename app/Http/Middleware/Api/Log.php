<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Log as ApiLog;

class Log
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
        $allowed_methods = ['POST', 'PUT', 'PATCH', 'DELETE'];

        if (in_array($request->method(), $allowed_methods)) {
            $log = new ApiLog();
            $log->ip = $request->ip();
            $log->action = $request->path();
            $log->device = $request->userAgent();
            $log->post = json_encode($request->post());
            $log->get = json_encode($request->query());
            $log->session = json_encode(['user_id' => Session::get('user_id')]);
            $log->save();

            $result = $next($request);

            if (gettype($result->original) === 'array') {
                $log->response = json_encode($result->original);
                $log->save();
            }
        } else {
            $result = $next($request);
        }

        return $result;
    }
}
