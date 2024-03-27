<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Method2FA;
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


    public function sendCodeTwoFA(Request $request)
    {

        $this->authServices->sendCode(Method2FA::EMAIL, $request->user());

        return response()->json(['message' => 'Code sent successfully'], Response::HTTP_OK);
    }

    public function verifyCodeTwoFA(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'min:6', 'max:6']
        ]);

        $this->authServices->verifyCode2FA($request->user(), $request->code);

        return response()->json(['message' => 'Code verified successfully'], Response::HTTP_OK);
    }
}
