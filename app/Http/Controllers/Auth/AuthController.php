<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\v1\AuthRequest;
use App\Services\AuthServices;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private AuthServices $authServices;

    public function __construct(AuthServices $authServices)
    {
        $this->authServices = $authServices;
        $this->middleware('auth:api', ['except' => ['login']]);

    }

    public function login(AuthRequest $request)
    {

        $token =  $this->authServices->login($request);

        return response((array)$token, Response::HTTP_OK);
    }

    public function refresh(Request $request)
    {

        $token =  $this->authServices->refresh($request);

        return response((array)$token, Response::HTTP_OK);
    }
}
