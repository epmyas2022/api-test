<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Symfony\Component\HttpFoundation\Response;

class Request extends FormRequest
{

    /*Determine if stop on first failure is enabled*/
    protected $stopOnFirstFailure = false;

    /*Data to validate*/
    protected $data = [];

    /*Rules aditionals to validate*/
    protected $aditionalRules = [];

    function __construct()
    {
        $this->cleanData(request()->all());

        $this->validate();
    }
    /**
     * Get the validation rules that apply to the request.
     * @param ValidatorContract $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public function failedValidation(ValidatorContract $validator): void
    {
        throw new HttpResponseException(response()->json(
            $validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY
        ));
    }

    /**
     * Clean values null or empty from data
     * @param array $data
     * @return self
     */
    public function cleanData(array $data): self
    {
        $this->data = collect($data)->filter(
            fn ($value) => $value !== null
        )->toArray();

        return $this;
    }

    /**
     * Add additional rules to the request
     * @param array $rules
     * @return self
     */
    public function additionalRules(array $rules)
    {
        $this->aditionalRules = $rules;
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
     * Validate that the method of rules exists
     * @return array $rules
     */
    protected function validationRules()
    {
        return method_exists($this, 'rules') ? $this->rules() : [];
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
     * @return mixed $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public function validate($rules = null, $messages = null, $data = null)
    {
        $validador = Validator::make(
            $data ?: $this->all(),
            $rules ?: array_merge($this->validationRules(), $this->aditionalRules),
            $messages ?: $this->messages()
        );

        if (!$validador->fails()) {
            return $validador;
        }

        $this->failedValidation($validador);
    }
}
