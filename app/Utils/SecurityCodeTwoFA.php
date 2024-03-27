<?php

namespace App\Utils;

use Ichtrojan\Otp\Otp;

class SecurityCodeTwoFA
{

    protected Otp $Otp;

    private string $type = 'numeric';
    private int $length = 6;
    private int $expired = 5;

    public function __construct()
    {
        $this->Otp = new Otp();
    }

    /**
     * Set the options for two-factor authentication code
     * @param string $type
     * @param int $length
     * @param int $expired
     * @return SecurityCodeTwoFA
     */
    public function options(string $type, int $length, int $expired): self
    {
        $this->type = $type;
        $this->length = $length;
        $this->expired = $expired;

        return $this;
    }
    /**
     * Generate a code for two-factor authentication
     * @param string|null $code
     * @param int $minutes
     * @return string
     */
    public  function generate(mixed $id): string
    {
        $code = $this->Otp->generate($id, $this->type, $this->length, $this->expired);

        return $code->token;
    }


    /**
     * Check the code for two-factor authentication
     * @param string $code
     * @return bool
     */
    public  function check(mixed $id, string $code): bool
    {
        $check = $this->Otp->validate($id, $code);

        return $check->status;
    }
}
