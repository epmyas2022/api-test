<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Http\Requests\v1\AuthRequest;
use App\Interfaces\UserRepository;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Ramsey\Uuid\Uuid;

class AuthServices
{


    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Response with token
     * @param string $token
     * @param string $refresh
     * @return object [token, refresh_token]
     */
    private function responseWithToken($token, $refresh)
    {
        return  (object) [
            'access_token' => $token,
            'refresh_token' => $refresh
        ];
    }

    /**
     * Login user
     * @param AuthRequest $request
     * @return object [token, refresh_token]
     * @throws AccessDeniedException
     */
    public function login(AuthRequest $request)
    {
        $token = JWTAuth::attempt($request->all());

        if (!$token)
            throw new AccessDeniedHttpException('Invalid credentials');

        $refreshToken = DB::transaction(function () {
            return $this->createRefreshToken(JWTAuth::user()->id);
        });

        return $this->responseWithToken($token, $refreshToken);
    }


    /**
     * Create refresh token
     * @param int $id
     * @return string $refreshToken
     */
    public function createRefreshToken(int $id): string
    {
        $refreshToken = Uuid::uuid4();

        $this->userRepository->createToken([
            'name' => 'RefreshToken',
            'token' => $refreshToken,
            'expires_at' => now()->addDays(7),
        ], $id);

        return $refreshToken;
    }

    /**
     * Refresh token user
     * @param Request $request
     * @return object [token, refresh_token]
     */
    public function refresh(Request $request)
    {
        if (!$this->userRepository->isValidateToken($request->refresh_token))
            throw new AccessDeniedHttpException('Invalid refresh token'); {
        }
        $user = JWTAuth::setToken(JWTAuth::getToken())->toUser();

        JWTAuth::invalidate(JWTAuth::getToken());

        $this->userRepository->revokeToken($request->refresh_token);

        $token = JWTAuth::fromUser($user);

        $refreshToken = DB::transaction(function () use ($user) {
            return $this->createRefreshToken($user->id);
        });

        return $this->responseWithToken($token, $refreshToken);
    }
}
