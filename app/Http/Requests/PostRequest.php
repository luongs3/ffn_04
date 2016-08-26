<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Carbon\Carbon;

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
        $date = Carbon::now();
        $notPost = config('common.post.un_published');

        return [
            'title' => 'required|max:255',
            'content' => 'required',
            'user_id' => 'required',
            'category_id' => 'required',
            'league_id' => 'required',
            'image' => 'image|mimes:jpeg,jpg,bmp,png,gif|max:2048',
            'published_at' => "required_if:is_post,$notPost|after:$date",
        ];
    }
}
