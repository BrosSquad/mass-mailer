<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
            'appName' => [
                'required',
                'unique:applications,app_name'
            ],
            'sendgridKey' => [
                'required',
                'regex:/^SG\.([a-zA-Z0-9\-\_]{22})\.([a-zA-Z0-9\-\_]{43})$/',
                'unique:sendgrid_keys,key'
            ],
            'sendGridNumberOfMessages' => [
                'required',
                'integer'
            ]
        ];
    }
}
