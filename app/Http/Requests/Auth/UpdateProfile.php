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
            'gender' => 'string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg'
        ];
    }
}
