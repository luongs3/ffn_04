<?php

namespace App\Http\Requests;

class UpdateRankRequest extends Request
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
            'score' => "min:{$rule['number_min']}|max:{$rule['number_max']}",
            'number' => "min:{$rule['number_min']}|max:{$rule['number_max']}",
            'team_id' => "exists:teams,id",
            'season_id' => "required|exists:seasons,id",
        ];
    }
}
