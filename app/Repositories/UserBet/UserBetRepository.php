<?php
namespace App\Repositories\UserBet;

use App\Events\CreateBet;
use App\Repositories\Match\MatchRepositoryInterface;
use Request;
use App\Models\UserBet;
use App\Repositories\BaseRepository;
use App\Repositories\UserBet\UserBetRepositoryInterface;
use App\Models\Match;
use Auth;
use Exception;
use DB;

class UserBetRepository extends BaseRepository implements UserBetRepositoryInterface
{
    protected  $matchRepository;

    public function __construct(
        UserBet $userBet,
        MatchRepositoryInterface $matchRepository
    ) {
        $this->model = $userBet;
        $this->matchRepository = $matchRepository;
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

        $createBet->user()->decrement('point', $userBet['point']);
        event(new CreateBet($createBet));

        return $createBet;
    }

    public function updateBets($request, $id)
    {
        $input = $request->only(['team_id', 'point']);
        $userBet = $this->model->find($id);

        if (isset($userBet['error'])) {
            return ['error' => $userBet['error']];
        }

        $point = $userBet['point'] - $input['point'];
        $userBet->user()->increment('point', $point);
        $data = $userBet->update($input);

        if (!$data) {
            return ['error' => trans('message.updating_error')];
        }

        return $data;
    }

    public function calculateResult($match)
    {
        try {
            $userBets = $this->model->where('match_id', $match['id'])->get();

            if (!count($userBets)) {
                return false;
            }

            $winTeamId = $this->matchRepository->matchResult($match);
            DB::beginTransaction();

            if (!is_null($winTeamId)) {
                $winners = $this->model->where(['match_id' => $match['id'], 'team_id' => $winTeamId])->get();

                if (count($winners)) {
                    foreach ($winners as $key => $winner) {
                        $extraPoint = $winner->point * config('common.bet.score_ratio');
                        $winner->user()->increment('point', $extraPoint);
                        $data = $winner->update(['result' => config('common.bet.win')]);

                        if (!$data) {
                            DB::rollBack();
                            return ['error' => trans('message.updating_error')];
                        }
                    }
                }
            }

            DB::commit();

            return $userBets;
        } catch (Exception $ex) {
            DB::rollBack();
            return ['error' => $ex->getMessage()];
        }

    }

    public function list()
    {
        $userBet = $this->model->where('user_id', Auth::user()->id)->paginate(config('news.posts_per_page'));

        return $userBet;
    }
}
