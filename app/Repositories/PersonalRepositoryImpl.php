<?php
namespace App\Repositories;

use App\Interfaces\PersonalRepository;
use App\Models\Personal;


class PersonalRepositoryImpl implements PersonalRepository  {

    public function all()
    {
        return Personal::all();
    }

    public function create(array $data)
    {
        return Personal::create($data);
    }

    public function update(array $data, $id)
    {
        Personal::find($id)->update($data);
    }

    public function delete($id)
    {
        Personal::find($id)->delete();
    }

    public function find($id)
    {
        return Personal::find($id);
    }

    public function personalData($id)
    {
        return Personal::find($id);
    }

}