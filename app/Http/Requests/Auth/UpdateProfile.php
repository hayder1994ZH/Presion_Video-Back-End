<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfile extends FormRequest
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
        $id = auth()->user()->id;
        return [
            'name' => 'string',
            'phone' => 'string|unique:users,phone,'.$id,
            'password' => 'string',
            'rule_id' => 'integer|exists:rules,id',
            'city_id' => 'integer|exists:cities,id',
            'gym_id' => 'string|exists:gyms,uuid',
            'gender' => 'string|max:255',
            'birthday' => 'nullable|string',
            'notes' => 'nullable|string',
            'card_number' => 'nullable|string',
            'long' => 'nullable|string',
            'lat' => 'nullable|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg'
        ];
    }
}
