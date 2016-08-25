<?php

namespace App\Repositories\Match;

use App\Events\UpdateMatch;
use App\Models\LeagueMatch;
use App\Models\Team;
use App\Repositories\BaseRepository;
use App\Models\Match;
use Exception;
use DB;
use App\Models\Player;

class MatchRepository extends BaseRepository implements MatchRepositoryInterface
{
    public function __construct(Match $match)
    {
        $this->model = $match;
    }

    public function index($subject, $options = [])
    {
        $limit = isset($options['limit']) ? $options['limit'] : config('common.limit.page_limit');
        $order = isset($options['order']) ? $options['order'] : ['key' => 'id', 'aspect' => 'DESC'];
        $filter = isset($options['filter']) ? $options['filter'] : [];

        try {
            $rows = $this->model->where($filter)->orderBy($order['key'], $order['aspect'])->paginate($limit);
            $data['subject'] = $subject;
            $data['columns'] = isset($options['columns']) ? $options['columns'] : $this->model->getFillable();
            array_unshift($data['columns'], 'id');
            if (count($rows)) {
                foreach ($rows as $key => $row) {
                    $rows[$key] = $row->where('id', $row['id'])->first($data['columns']);
                    $rows[$key]['team1'] = Team::find($row['team1_id'])->name;
                    $rows[$key]['team2'] = Team::find($row['team2_id'])->name;
                }
                $data['from'] = ($rows->currentPage() - 1) * config('common.limit.page_limit') + 1;
                $data['to'] = $data['from'] + $rows->count() - 1;
            }

            $data['total'] = $rows->total();
            $data['rows'] = $rows;
            $data['columns'] = ['id', 'team1', 'team2', 'score_team1', 'score_team2', 'place', 'start_time', 'end_time'];

            return $data;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function show($id)
    {
        try {
            $data = $this->model->find($id);

            if (!$data) {
                return ['error' => trans('message.item_not_exist')];
            }

            $data['league_match'] = LeagueMatch::where('match_id', $data['id'])->first();

            return $data;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function store($input)
    {
        $match = [
            'team1_id' => array_pull($input, 'team1_id'),
            'team2_id' => array_pull($input, 'team2_id'),
            'place' => array_pull($input, 'place'),
            'start_time' => array_pull($input, 'start_time'),
        ];

        try {
            DB::beginTransaction();
            $data = $this->model->create($match);

            if (!$data) {
                return ['error' => trans('message.deleting_error')];
            }

            $input['match_id'] = $data->id;
            LeagueMatch::create($input);
            DB::commit();

            return $data;
        } catch (Exception $ex) {
            DB::rollBack();

            return ['error' => $ex->getMessage()];
        }
    }

    public function update($input, $id)
    {
        try {
            $match = $this->model->find($id);
            $input['id'] = $id;
            event(new UpdateMatch($input));
            $match->fill($input);
            $match->save();
            if (!$match) {
                return ['error' => trans('message.updating_error')];
            }


            return $match;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function getRecentMatches()
    {
        $checkTime = config('common.message.check_time');

        return $this->model->where('start_time', '<', Carbon::now()->addMinutes($checkTime))
            ->where('start_time', '>', Carbon::now())
            ->get();
    }

    public function matchResult($match)
    {
        if ($match['score_team1'] > $match['score_team2']) {
            return $match['team1_id'];
        } elseif ($match['score_team1'] < $match['score_team2']) {
            return $match['team2_id'];
        }

        return null;
    }
}
