<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiResponse;

    public function errorFalback()
    {
        return $this->errorResponse('Please check your endpoint', null);
    }
}
