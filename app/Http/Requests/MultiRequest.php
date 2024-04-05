<?php

namespace App\Http\Requests;

use Illuminate\Validation\Factory;

/**
 * Permit to validate multiples form requests validations
 * @version 1.0.0
 * @package App\Http\Requests
 */
class MultiRequest extends Request
{

    /**
     * The rules to validate the request
     * @var array
     */
    private array $rules = [];

    /**
     * The messages to validate the request
     * @var array
     */
    private array $messages = [];

    /**
     * The authorized methods to validate the request
     * @var array 
     */
    private array $authorized = [];

    /**
     * The validator instance
     * @var \Illuminate\Contracts\Validation\Validator
     */
    protected $validator;

    /**
     * Create a new instance of the class
     * @param array<App\Http\Requests\Request> $requests
     * @return self
     */
    public function make($requests): self
    {


        $this->rules = $this->getDataByMethod('rules', $requests);
        $this->messages = $this->getDataByMethod('messages', $requests);
        $this->authorized = $this->getDataByMethod('authorize', $requests, false);

        return $this;
    }

    /**
     * Get the data returned by a method
     * @param string $method
     * @param array<App\Http\Requests\Request> $instances
     * @return array $data
     */
    private function getDataByMethod(string $method, array $instances, bool $withKeys = true): array
    {

        if ($withKeys)
            return collect($instances)->mapWithKeys(
                fn ($instance) => $instance->$method()
            )->toArray();

        return collect($instances)->map(
            fn ($instance) => $instance->$method()
        )->toArray();
    }
    /**
     * Validate all the requests
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function all($keys = null)
    {
        return request()->all($keys);
    }

    /**
     * Execute createDefaultValidator method for validate the request
     * @return self
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public function execute(): self
    {
        $this->validator = $this->createDefaultValidator(app(Factory::class));

        $this->setValidator($this->validator);

        if ($this->validator->fails())
            $this->failedValidation($this->validator);

        return $this;
    }

    /**
     * Except rules from the request
     * @param array<string> $keys
     * @return self
     */

    public function except($keys): self
    {
        $this->rules = collect($this->rules)->except($keys)->toArray();

        return $this;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->rules;
    }

    /**
     * Add rules to the request
     * @param array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> $rules
     * @return self
     */
    public function addRules(array $rules): self
    {
        $this->rules = array_merge($this->rules, $rules);

        return $this;
    }

    /**
     * Determine if the the methods of the requests are authorized
     */
    public function authorize(): bool
    {
        return collect($this->authorized)->every(fn ($auth) => $auth);
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return $this->messages;
    }
}
