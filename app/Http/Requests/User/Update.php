<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
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
        $id = $this->route('user');
        return [
            'name' => 'string',
            'phone' => 'string|unique:users,phone,'.$id,
            'password' => 'string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'rule_id' => 'integer|exists:rules,id',
            'city_id' => 'integer|exists:cities,id',
            'gym_id' => 'string|exists:gyms,uuid',
            'gender' => 'string|max:255',
            'birthday' => 'nullable|string',
            'card_number' => 'nullable|string',
            'notes' => 'nullable|string',
            'long' => 'nullable|string',
            'lat' => 'nullable|string'
        ];
    }
}
