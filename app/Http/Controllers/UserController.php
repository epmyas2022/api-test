<?php

namespace App\Http\Controllers;

use App\Http\Requests\v1\UserRequest;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
  private UserServices $userService;

    public function __construct(UserServices $userService)
    {
        $this->userService = $userService;
    }


    public function store(UserRequest $request)
    {
       $user = $this->userService->createUser($request);

       return response($user, Response::HTTP_CREATED);
    }
}
