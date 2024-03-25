<?php

namespace App\Http\Requests\v1;

use App\Enums\Language;
use App\Enums\Pais;
use App\Enums\Validate;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PersonalRequest extends Request
{


    function __construct()
    {
        parent::__construct();
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

      
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => [
                $this->requiredIfMethod('POST'),
                'string',
                'max:255'
            ],
            'last_name' => [
                $this->requiredIfMethod('POST'),
                'string',
                'max:255'
            ],
            'email' => [
                $this->requiredIfMethod('POST'),
                'string',
                'max:255',
                'email',
                'unique:users,email'
            ],
            'gender' => [
                $this->requiredIfMethod('POST'),
                'string',
            ],
            'ip_address' => [
                $this->requiredIfMethod('POST'),
                'string',
                'max:255'
            ],
            'country' => [
                $this->requiredIfMethod('POST'),
                'string',
                Rule::enum(Pais::class)
            ],
            'language' => [
                $this->requiredIfMethod('POST'),
                'string',
                Rule::enum(Language::class)
            ],

        ];
    }

    public function messages(): array
    {
        return [
            "first_name.required" => "El campo nombre es requerido",
            "first_name.string" => "El campo nombre debe ser una cadena",
            "first_name.max" => "El campo nombre debe tener un máximo de 255 caracteres",
            "last_name.required"  => "El campo apellido es requerido",
            "last_name.string" => "El campo apellido debe ser una cadena",
            "last_name.max"  => "El campo apellido debe tener un máximo de 255 caracteres",
            "email."  => "El campo email es requerido",
            "country.Illuminate\Validation\Rules\Enum" => "El campo país debe ser un valor válido",

        ];
    }
}
