<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAdmin extends FormRequest
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
            'name' => 'required|string',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:6',
            'city_id' => 'required|integer|exists:cities,id',
            'gender' => 'required|string|max:255',
            'birthday' => 'nullable|string',
            'card_number' => 'nullable|string',
            'notes' => 'nullable|string',
            'long' => 'nullable|string',
            'lat' => 'nullable|string'
        ];
    }
}
