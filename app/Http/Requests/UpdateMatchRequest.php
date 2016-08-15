<?php

namespace App\Http\Requests;

class UpdateMatchRequest extends Request
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
        $validate = [
            'team1_id' => "exists:teams,id",
            'team2_id' => "exists:teams,id",
            'score_team1' => "min:{$rule['number_min']}|max:{$rule['number_max']}",
            'score_team2' => "min:{$rule['number_min']}|max:{$rule['number_max']}",
            'place' => "max:{$rule['place_max']}",
            'start_time' => 'date',
        ];

        if ($this->request->get('end_time') != '0000-00-00 00:00:00') {
            $validate['end_time'] = 'date|after:start_time';
        }

        return $validate;
    }
}
