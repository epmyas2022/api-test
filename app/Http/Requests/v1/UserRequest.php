<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\Request;
use Illuminate\Validation\Rules\Password;
class UserRequest extends Request
{
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:dns', 'unique:users'],
            'password' =>  [
                'required',
                $this->method() === 'PUT' ? 'confirmed' : null,
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
        ];
    }
}
