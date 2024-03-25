<?php

namespace App\Http\Requests;

/**
 * Permit to validate multiples form requests validations
 * @version 1.0.0
 * @package App\Http\Requests
 */
class MultiRequest extends Request
{

    private array $rules = [];
    private array $messages = [];
    private array $authorized = [];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a new instance of the class
     * @param array<App\Http\Requests\Request> $requests
     * @return self
     */
    public function make($requests): self
    {
        $requests = collect($requests);

        $this->rules = $requests->mapWithKeys(
            fn ($request) => $request->rules()
        )->toArray();

        $this->messages = $requests->mapWithKeys(
            fn ($request) =>
            $request->messages()
        )->toArray();

        $this->authorized = $requests->map(
            fn ($request) =>
            $request->authorize()
        )->toArray();

        return $this;
    }
    /**
     * Validate all the requests
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function validates()
    {
        if (!$this->authorize()) {
            parent::failedAuthorization();
        }
        return parent::validate($this->rules, $this->messages);
    }

    /**
     * Get all data validated from the requests
     * @return array<string, mixed>
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public function getValidated()
    {
        $this->validates();

        return $this->all();
    }

    /**
     * Except rules from the request
     * @param array<string> $keys
     */
    public function exceptRules(array $keys)
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
