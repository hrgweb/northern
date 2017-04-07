<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $method = $request->method();
        $rules = [];

        switch ($method) {
            case 'POST':
                $rules = [
                    'ic' => 'string|nullable',
                    'postcode' => 'numeric|nullable',
                    'email' => 'email|nullable',
                    'homephone' => 'min:8|numeric|nullable',
                    'handphone' => 'min:8|numeric|nullable',
                ];
                break;
            
            case 'PUT':
                $rules = [
                    'ic' => 'string|nullable',
                    'postcode' => 'numeric|nullable',
                    'email' => 'email|nullable',
                    'homephone' => 'min:8|numeric|nullable',
                    'handphone' => 'min:8|numeric|nullable',
                ];
                break;
        }

        return $rules;
    }
}
