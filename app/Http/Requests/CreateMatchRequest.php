<?php

namespace App\Http\Requests;

class CreateMatchRequest extends Request
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
            'team1_id' => "required|exists:teams,id",
            'team2_id' => "required|exists:teams,id",
            'place' => "max:{$rule['place_max']}",
            'start_time' => 'date',
        ];
    }
}
