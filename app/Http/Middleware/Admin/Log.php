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
        $admin_log_db = new AdminLog();
        $admin_log_db->ip = $request->ip();
        $admin_log_db->action = $request->path();
        $admin_log_db->device = $request->userAgent();
        $admin_log_db->post = json_encode($request->post());
        $admin_log_db->get = json_encode($request->query());
        $admin_log_db->session = json_encode(['admin_id' => Session::get('admin_id')]);
        $admin_log_db->save();

        $result = $next($request);

        if (gettype($result->original) === 'array') {
            $admin_log_db->response = json_encode($result->original);
            $admin_log_db->save();
        }

        return $result;
    }
}
