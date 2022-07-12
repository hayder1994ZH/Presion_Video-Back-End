<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
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
            'card_number' => 'nullable|string',
            'password' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'rule_id' => 'required|integer|exists:rules,id',
            'city_id' => 'required|integer|exists:cities,id',
            'gym_id' => 'required|string|exists:gyms,uuid',
            'gender' => 'required|string|max:255',
            'birthday' => 'nullable|string',
            'notes' => 'nullable|string',
            'long' => 'nullable|string',
            'lat' => 'nullable|string'
        ];
    }
}
