<?php

namespace App\Services;

use App\Http\Requests\MultiRequest;
use App\Http\Requests\Request;
use App\Http\Requests\RequestField;
use App\Http\Requests\v1\GeneralRequest;
use App\Http\Requests\v1\PersonalRequest;
use App\Interfaces\PersonalRepository;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class PersonalServices
{
    private $personalRepository;

    public function __construct(PersonalRepository $personalRepository)
    {
        $this->personalRepository = $personalRepository;
    }
    /**
     *  Get all personal logic business
     * @return mixed
     */
    public function all()
    {
        return $this->personalRepository->all();
    }


    /**
     * @param PersonalRequest $data
     * @return mixed
     * @throws \BadRequestException
     */
    public function create(PersonalRequest $request)
    {
   /*      $data = $request->make([
            new PersonalRequest(),
            new GeneralRequest()
        ])->getValidated(); */

        dd("Todo bien");
        /*  throw new BadRequestException('Error example'); */

     /*    return  DB::transaction(function () use ($data) {
            return $this->personalRepository->create($data);
        }); */
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        return $this->personalRepository->update($data, $id);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */

    public function delete($id)
    {
        return $this->personalRepository->delete($id);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        return $this->personalRepository->find($id);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */

    public function personalData($id)
    {
        return $this->personalRepository->personalData($id);
    }
}
