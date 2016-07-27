<?php

namespace App\Http\Requests;

class UpdatePlayerRequest extends Request
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
            'name' => "required|max:{$rule['name_max']}",
            'role' => "in:0,1",
            'team_id' => "exists:teams,id",
            'image' => "image|max:{$rule['image_size']}",
        ];
    }
}
