<?php

namespace App\Http\Requests;

class UpdateMatchEventRequest extends Request
{
    /**
     * Determine if the player is authorized to make this request.
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
        $rule = config('common.limit');
        return [
            'match_id' => "required|exists:matches,id",
            'title' => "max:{$rule['title_max']}",
            'content' => "max:{$rule['content_max']}",
            'image' => "image|max:{$rule['image_size']}",
        ];
    }
}
