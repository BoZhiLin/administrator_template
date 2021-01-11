<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\TaskService;

class TaskController extends ApiController
{
    /**
     * 簽到
     */
    public function signIn()
    {
        $response = TaskService::signIn(auth()->id());
        return response($response);
    }
}
