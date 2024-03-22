<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Services\PersonalServices;
use App\Models\Personal;

use App\Http\Requests\Request;
use App\Http\Requests\v1\PersonalRequest;

class PersonalController extends Controller
{
    private PersonalServices  $personalService;

    public function __construct(PersonalServices $personalService)
    {
        $this->personalService = $personalService;
    }

    public function index()
    {
        $personal = $this->personalService->all();
        return response($personal, Response::HTTP_OK);
    }

    function store()
    {
        $personal = $this->personalService->create();
        return response($personal, Response::HTTP_CREATED);
    }


    function update(Request $request, Personal $personal)
    {

        dd($personal);
       $personalValidates =  new PersonalRequest();

        $personalValidates->loadModelValidation($personal);

        $personalValidates->validate();

        $personal = $this->personalService->update($request->all(), $personal->id);
        return response($personal, Response::HTTP_OK);
  /*       $personal = $this->personalService->update($request->all(), $id); */
        return response($personal, Response::HTTP_OK);
    }
}
