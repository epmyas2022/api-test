<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Symfony\Component\HttpFoundation\Response;

class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    protected $stopOnFirstFailure = false;
    private $modelValidation = null;


    function __construct()
    {
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function failedValidation(ValidatorContract $validator): void
    {

        throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }

    /**
     * Get all the request data
     * @param array<string>|null $keys
     */

    public function all($keys = null)
    {
        if ($this->modelValidation) {
         return $this->modelValidation->getAttributes();
        }
        return request()->all();
    }

    public function loadModelValidation($modelValidation)
    {
        $this->modelValidation = $modelValidation;

        return $this;
    }


    /**
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function validate($rules = null, $messages = null)
    {
       
        $validador = Validator::make(
            $this->all(),
            $rules ?? $this->rules(),
            $messages ?? $this->messages()
        );

        if (!$validador->fails()) {
            return $validador->validate();
        }

        $this->failedValidation($validador);
    }
}
