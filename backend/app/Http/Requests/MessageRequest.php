<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'text'      => 'required',
            'fromEmail' => 'required|email',
            'fromName'  => 'required',
            'replyTo'   => 'required|email',
            'subject'   => 'required',
            'isMjml'    => 'required|boolean',
        ];
    }
}
