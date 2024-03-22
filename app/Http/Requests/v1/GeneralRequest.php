<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\Request;

class GeneralRequest extends Request
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
            'test' => 'required|string|max:255',
        ];
    }
}
