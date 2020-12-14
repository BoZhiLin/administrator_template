<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\AdminLog;

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
        $admin_log = new AdminLog();
        $admin_log->ip = $request->ip();
        $admin_log->action = $request->path();
        $admin_log->device = $request->userAgent();
        $admin_log->post = json_encode($request->post());
        $admin_log->get = json_encode($request->query());
        $admin_log->session = json_encode(['admin_id' => Session::get('admin_id')]);
        $admin_log->save();

        $result = $next($request);

        if (gettype($result->original) === 'array') {
            $admin_log->response = json_encode($result->original);
            $admin_log->save();
        }

        return $result;
    }
}
