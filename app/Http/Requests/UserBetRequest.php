<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserBetRequest extends Request
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
            'team_id' => 'required: user_bets, team_id',
            'point' => 'required: user_bets, point',
        ];
    }

    public function messages()
    {
        return [
            'team_id.required' => trans('bets.validate.team_required'),
            'point.required' => trans('bets.validate.point_required'),
        ];
    }
}
