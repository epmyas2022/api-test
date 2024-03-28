<?php

namespace App\Utils;


use OTPHP\TOTP;
class SecurityCodeTwoFA
{
    /**
     * Generate a code for two-factor authentication
     * @param string|null $code
     * @param int $minutes
     * @return string
     */
    public  function generate(string $secret): string
    {
        $otp = TOTP::create($secret);

        $code = $otp->at(time());

        return $code;
    }


    /**
     * Generate a secret for two-factor authentication
     * @return string
     */
    public function secret(): string
    {
        $otp = TOTP::create();
        $secret = $otp->getSecret();

        return $secret;
    }


    public function uriProvisioning(string $secret, string $name, string $issuer ): string
    {
        $otp = TOTP::create($secret);

        $otp->setLabel($name);
        $otp->setIssuer($issuer);

        return $otp->getProvisioningUri();
    }



    /**
     * Check the code for two-factor authentication
     * @param string $code
     * @return bool
     */
    public  function check(string $secret, string $code): bool
    {
        $otp = TOTP::create($secret);

        return $otp->verify($code, time());
    }

    /**
     * Get the remaining time in seconds
     * @param string $secret
     * @return int
     */
    public function remainingTime(string $secret): int
    {
        $otp = TOTP::create($secret);

        $result = $otp->expiresIn() ?? 0 - time();

        return $result > 0 ? $result : 0;

    }

    /**
     * Get the next code a generated
     * @param string $secret
     * @return string
     */
    public function nextCode(string $secret): string
    {
        $otp = TOTP::create($secret);

        return $otp->at(time() + 30);
    }
}
