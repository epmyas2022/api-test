<?php

namespace App\Interfaces;

/**
 * Interface GrudRepository
 * @package App\Interfaces
 */
interface GrudRepository
{
    /** 
     *Get all data 
     *@return mixed|null
     */
    public function all();

    /**
     * Create data
     * @param array $data
     * @return mixed|null
     */
    public function create(array $data);

    /**
     * Update data
     * @param array $data
     * @param $id
     * @return mixed|null
     */
    public function update(array $data, $id);

    /**
     * Delete data
     * @param $id
     * @return mixed|null
     */
    public function delete($id);

    /**
     * Find data
     * @param $id
     * @return mixed|null
     */
    public function find($id);
}
