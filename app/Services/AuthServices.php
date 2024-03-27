<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Http\Requests\v1\AuthRequest;
use App\Interfaces\UserRepository;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Ramsey\Uuid\Uuid;
use App\Enums\Method2FA;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendCode2FA;
use App\Models\User;
use App\Utils\SecurityCodeTwoFA;

class AuthServices
{
    private UserRepository $userRepository;
    private SecurityCodeTwoFA $securityCodeTwoFA;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->securityCodeTwoFA = new SecurityCodeTwoFA();
    }

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


    /**
     * Send code 2FA
     * @param Method2FA $method
     * @param object $user
     */
    public function sendCode(Method2FA $method, User $user)
    {
        $codeSecurity = $this->securityCodeTwoFA->generate($user->id);

        match ($method) {
            Method2FA::SMS => $this->sendCode2FABySms($user, $codeSecurity),
            Method2FA::EMAIL => $this->sendCode2FAByMail($user, $codeSecurity),
        };
    }

    /**
     * Verify code 2FA
     * @param Request $request
     */
    public function verifyCode2FA(User $user, $code): void
    {
        if(!$this->securityCodeTwoFA->check($user->id, $code))
            throw new AccessDeniedHttpException('Invalid code 2FA');

        $user->verifyTwoFA();
    }

    /**
     * Send code 2FA by mail
     * @param object $user
     * @param string $code
     */
    public function sendCode2FAByMail(object $user, string $code): void
    {
        // send code by mail
        Mail::to($user->email)->send(new SendCode2FA($code, $user));
    }

    /**
     * Send code 2FA by sms
     * @param object $user
     * @param string $code
     */
    public function sendCode2FABySms(object $user, string $code): void
    {
        // send code by sms
    }
}
