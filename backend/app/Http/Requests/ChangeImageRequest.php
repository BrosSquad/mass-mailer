<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ChangeImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => ['required', 'regex:#^(background|avatar)$#'],
            'avatar' => [
                'image',
                // 'dimensions:min_width=100,min_heigh=100,max_width=250,max_height=250', // Dimensions
                Rule::requiredIf(function () {
                    echo $this->request->get('type') === null;
                    return $this->request->get('type') === 'avatar';
                })
            ],
            'background' => [
                'image',
                // TODO: Add Dimensions

                Rule::requiredIf(function () {
                    return $this->request->get('type') === 'background';
                })
            ],
        ];
    }
}
