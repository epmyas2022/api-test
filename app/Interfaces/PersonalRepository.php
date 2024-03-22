<?php

namespace App\Interfaces;

interface PersonalRepository extends GrudRepository
{
    /**
     * Get personal data
     * @param $id
     * @return mixed|null
     */
    public function personalData($id);
}
