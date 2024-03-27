<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Sanctum\PersonalAccessToken;
use App\Utils\SecurityCodeTwoFA;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $securityCodeTwoFA;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->securityCodeTwoFA = new SecurityCodeTwoFA();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'two_fa_enabled',
        'two_fa_verified',
        'secret_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function personalAccessToken()
    {
        return $this->morphMany(PersonalAccessToken::class, 'tokenable');
    }


    public function secret()
    {
        if (!$this->secret_code) {
            $this->secret_code = $this->securityCodeTwoFA->secret();
            $this->save();
        }
        return $this->secret_code;
    }
    public function isTwoFAEnabled()
    {
        return $this->two_fa_enabled;
    }

    public function enableTwoFA()
    {
        $this->two_fa_enabled = true;
        $this->save();
    }

    public function disableTwoFA()
    {
        $this->two_fa_enabled = false;
        $this->save();
    }

    public function is2FAVerified()
    {
        return $this->two_fa_verified;
    }

    public function verifyTwoFA()
    {
        $this->two_fa_verified = true;
        $this->save();
    }

    public function resetTwoFA()
    {
        $this->two_fa_verified = false;
        $this->save();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'user' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
            ],
        ];
    }
}
