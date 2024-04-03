<?php

namespace App\Http\Controllers;

use App\Http\Requests\MultiRequest;
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

    function store(PersonalRequest $request)
    {
        $personal = $this->personalService->create($request);
        return response($personal, Response::HTTP_CREATED);
    }


    function update(Request $request, Personal $personal)
    {

        $personal = $this->personalService->update($request->all(), $personal->id);
        return response($personal, Response::HTTP_OK);
    }
}
