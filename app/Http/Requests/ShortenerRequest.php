<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShortenerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url' => 'required|max:255|url',
            'number' => 'required|integer',
            'expiry' => 'required|in:1,2',
            'expiry_date' => 'nullable|required_if:expiry,==,1|date|after:today'
        ];
    }
}
