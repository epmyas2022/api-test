<?php

namespace App\Repositories;

use App\Interfaces\UserRepository;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Sanctum\PersonalAccessToken;

class UserRepositoryImpl implements UserRepository
{
    public function all()
    {
        return User::all();
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(array $data, $id)
    {
        $user = User::find($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        User::find($id)->delete();
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function createToken(array $data, $id)
    {

        $user = User::find($id);

        return $user->personalAccessToken()->create($data);
    }

    public function revokeToken($token)
    {

        $token = PersonalAccessToken::where('token', $token)->first();

        if ($token) $token->delete();
    }

    public function isValidateToken($token)
    {
        $token = PersonalAccessToken::where('token', $token)->first();

        if (!$token ) return false;

        if (Carbon::parse($token->expires_at)->isPast()) return false;

        return true;
    }
}
