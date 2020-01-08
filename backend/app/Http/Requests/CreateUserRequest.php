<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** @var \App\User $user */
        $user = Auth::user();

        return $user !== null && $user->hasPermissionTo('create-users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => ['required', 'min:2', 'max:70'],
            'surname' => ['required', 'min:2', 'max:70'],
            'email'   => ['required', 'max:255', 'unique:users'],
            'role'    => ['required', 'exists:roles,name'],
        ];
    }
}
