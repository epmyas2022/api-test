<?php

namespace App\Services;

use App\Interfaces\UserRepository;
use App\Http\Requests\v1\UserRequest;
use Illuminate\Support\Facades\DB;

class UserServices
{


    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Create a new user
     * @param UserRequest $data
     * @return mixed
     */
    public function createUser(UserRequest $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->userRepository->create($data->all());
        });
    }
}
