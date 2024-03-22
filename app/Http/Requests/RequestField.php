<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestField extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    public $field;

    public function __construct($field)
    {
        parent::__construct();

        $this->field = $field;
    }

    public function field()
    {
        return $this->field;
    }
}
