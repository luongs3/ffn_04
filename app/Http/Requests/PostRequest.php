<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostRequest extends Request
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
            'title' => 'required|max:255',
            'content' => 'required',
            'user_id' => 'required',
            'category_id' => 'required',
            'league_id' => 'required',
            'image' => 'image|mimes:jpeg,jpg,bmp,png,gif|max:2048',
        ];
    }
}
