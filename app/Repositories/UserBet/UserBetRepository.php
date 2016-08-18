<?php

namespace App\Repositories\UserBet;

use Request;
use App\Models\UserBet;
use App\Repositories\BaseRepository;
use App\Repositories\UserBet\UserBetRepositoryInterface;
use App\Models\Match;
use Auth;

class UserBetRepository extends BaseRepository implements UserBetRepositoryInterface
{
    public function __construct(UserBet $userBet)
    {
        $this->model = $userBet;
    }

    public function show($id)
    {
        try {
            $userBet = $this->model->find($id);

            if (!$userBet) {
                return ['error' => trans('message.item_not_exist')];
            }

            return $userBet;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function bet($request, $matchId)
    {
        $userBet = [
            'user_id' => Auth::user()->id,
            'match_id' => $matchId,
            'point' => $request->point,
            'team_id' => $request->team_id,
        ];

        $createBet = $this->model->create($userBet);

        if (!$createBet) {
            throw new Exception('message.create_bet_fail');
        }

        return $createBet;
    }

    public function updateBets($request, $id)
    {
        $input = $request->only(['team_id', 'point']);
        $userBetId = $this->find($id);

        if (isset($userBetId['error'])) {
            return ['error' => $userBetId['error']];
        }

        $userBet = $userBetId->update($input);

        if (!$userBet) {
            return ['error' => trans('message.updating_error')];
        }

        return $userBet;
    }

    public function list()
    {
        $userBet = $this->model->where('user_id', Auth::user()->id)->paginate(config('news.posts_per_page'));

        return $userBet;
    }
}
