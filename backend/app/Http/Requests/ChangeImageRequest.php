<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ChangeImageRequest extends FormRequest
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
            'type'       => ['required', 'regex:#^(background|avatar)$#'],
            'avatar'     => [
                Rule::requiredIf($this->request->get('type') === 'avatar'),
                'image',
                // 'dimensions:min_width=100,min_heigh=100,max_width=250,max_height=250', // Dimensions
            ],
            'background' => [
                Rule::requiredIf($this->request->get('type') === 'background'),
                'image',
                // TODO: Add Dimensions
            ],
        ];
    }
}
