<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'    => 'required|min:2|max:70',
            'surname' => 'required|min:2|max:70',
            'email'   => 'required|email|max:255',
            'application_id' => [Rule::requiredIf(Auth::user() !== null), 'numeric']
        ];
    }
}
