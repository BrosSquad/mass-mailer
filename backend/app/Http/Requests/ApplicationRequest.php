<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'app_name'                  => [
                'required',
                'unique:applications,app_name',
            ],
            'sendgrid_keys'              => ['required', 'array'],
            'sendgrid_keys.*.key' => [
                'required',
                'regex:/^SG\.([a-zA-Z0-9\-\_]{22})\.([a-zA-Z0-9\-\_]{43})$/',
                'unique:sendgrid_keys,key',
            ],
            'sendgrid_keys.*.number_of_messages' => [
                'required',
                'integer',
            ],
        ];
    }
}
