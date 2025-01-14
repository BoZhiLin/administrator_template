<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
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
        $token = preg_split('/ /', $request->header('Authorization'))[1] ?? null;

        try {
            if (is_null($token)) {
                $response = response(['status' => ResponseDefined::UNAUTHORIZED]);
            } elseif (!auth()->payload()) {
                $response = response(['status' => ResponseDefined::UNAUTHORIZED]);
            } else {
                $response = $next($request);
            }
        } catch (TokenInvalidException $ex) {
            $response = response(['status' => ResponseDefined::TOKEN_INVALID]);
        } catch (TokenExpiredException $ex) {
            $response = response(['status' => ResponseDefined::TOKEN_EXPIRED]);
        }

        return $response;
    }
}
