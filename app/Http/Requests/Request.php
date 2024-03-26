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

    protected $data = [];

    function __construct()
    {
        $this->cleanData(request()->all());
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
     * Clean values null or empty from data
     * @return  array<string, mixed>
     */
    public function cleanData(array $data)
    {
        $this->data = collect($data)->filter(
            fn ($value) => $value !== null
        )->toArray();

        return $this;
    }

    /**
     * Get the request method
     * @return string
     */
    public function method()
    {
        return request()->method();
    }
    /**
     * Get all the request data
     * @param array<string>|null $keys
     */

    public function all($keys = null)
    {
        return $this->data;
    }

    /**
     * Get the request method
     * @param string $method
     * @return string required | nullable
     */
    public function requiredIfMethod(string $method)
    {
        return $this->method() == $method ? 'required' : 'nullable';
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function validate($rules = null, $messages = null, $data = null)
    {

        $validador = Validator::make(
            $data ?: $this->all(),
            $rules ?: $this->rules(),
            $messages ?: $this->messages()
        );

        if (!$validador->fails()) {
            return $validador->validate();
        }

        $this->failedValidation($validador);
    }
}
