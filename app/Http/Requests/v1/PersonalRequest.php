<?php

namespace App\Http\Requests\v1;

use App\Enums\Language;
use App\Enums\Pais;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\MultiRequest;

class PersonalRequest extends Request
{


    function __construct()
    {
   /*      parent::__construct(); */
   
    

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
                'required',
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

        //dd(trans('messages.hello', ['name' => 'John Doe']));
        return [
   

        ];
    }
}
