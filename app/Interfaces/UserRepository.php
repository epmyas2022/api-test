<?php

namespace App\Interfaces;

/**
 * Interface UserRepository
 * @package App\Interfaces
 */
interface UserRepository extends GrudRepository
{
    /**
     * Create a new user
     * @param array $data
     * @return mixed
     */
    public function createToken(array $data, $id);

    /**
     * Revoke a token
     * @param $id
     * @return mixed
     */
    public function revokeToken($id);

    /**
     * Validate a token
     * @param $id
     * @return mixed
     */
    public function isValidateToken($token);
}
