<?php

namespace App\Repositories\Rank;

use App\Models\LeagueMatch;
use App\Models\Season;
use App\Models\Team;
use App\Repositories\BaseRepository;
use App\Models\Rank;
use App\Repositories\League\LeagueRepositoryInterface;
use App\Repositories\Season\SeasonRepositoryInterface;
use Exception;
use DB;
use App\Models\Player;

class RankRepository extends BaseRepository implements RankRepositoryInterface
{
    protected $seasonRepository;
    protected $leagueRepository;

    public function __construct(
        Rank $rank,
        SeasonRepositoryInterface $seasonRepository,
        LeagueRepositoryInterface $leagueRepository
    ) {
        $this->model = $rank;
        $this->seasonRepository = $seasonRepository;
        $this->leagueRepository = $leagueRepository;
    }

    public function index($subject, $options = [])
    {
        $limit = isset($options['limit']) ? $options['limit'] : config('common.limit.page_limit');
        $order = isset($options['order']) ? $options['order'] : ['key' => 'id', 'aspect' => 'DESC'];
        $filter = isset($options['filter']) ? $options['filter'] : [];

        try {
            $rows = $this->model->with('season')->where($filter)->orderBy($order['key'], $order['aspect'])->paginate($limit);
            $data['subject'] = $subject;
            $data['columns'] = isset($options['columns']) ? $options['columns'] : $this->model->getFillable();
            array_unshift($data['columns'], 'id');

            if (count($rows)) {
                foreach ($rows as $key => $row) {
                    $rows[$key] = $row->where('id', $row['id'])->first($data['columns']);
                    if (count($row->season)) {
                        $rows[$key]['season_name'] = $row->season->name;
                        $rows[$key]['team_name'] = Team::find($row['team_id'])->name;
                    }
                }
                $data['from'] = ($rows->currentPage() - 1) * config('common.limit.page_limit') + 1;
                $data['to'] = $data['from'] + $rows->count() - 1;
            }

            $data['total'] = $rows->total();
            $data['rows'] = $rows;
            $data['columns'] = ['id', 'season_name', 'team_name', 'score', 'number'];

            return $data;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function store($input)
    {
        $season = Season::find($input['season_id']);
        $teams = $season->leagues()->first()->teams;

        if(!count($teams)) {
            return ['error' => trans('message.this_league_does_not_have_any_team')];
        }

        $data = [];
        foreach ($teams as $team) {
            $data[] = [
                'season_id' => $season->id,
                'team_id' => $team->id,
                'score' => 0,
                'number' => 0,
            ];
        }

        try {
            $returnData = $this->model->insert($data);

            if (!$returnData) {
                return ['error' => trans('message.creating_error')];
            }

            return $returnData;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function delete($ids)
    {
        try {
            DB::beginTransaction();
            Player::whereIn('team_id', $ids)->update(['team_id' => null]);
            $data = $this->model->destroy($ids);

            if (!$data) {
                return ['error' => trans('message.deleting_error')];
            }

            DB::commit();
            return $data;
        } catch (Exception $ex) {
            DB::rollBack();
            return ['error' => $ex->getMessage()];
        }
    }

    public function updateRankFromMatch($match)
    {
        try {
            $leagueMatch = LeagueMatch::where('match_id', $match['id'])->first();

            if (!$leagueMatch) {
                return ['error' => trans('message.data_is_empty')];
            }
            
            $match = $this->calculateScore($match);

            $team1 = $this->model->where(['season_id' => $leagueMatch['season_id'], 'team_id' => $match['team1_id']])->first();
            $team1->score = $team1->score + $match['add1'];
            $team1->number = $team1->number + 1;
            $team1->save();

            $team2 = $this->model->where(['season_id' => $leagueMatch['season_id'], 'team_id' => $match['team2_id']])->first();
            $team2->score = $team2->score + $match['add2'];
            $team2->number = $team2->number + 1;
            $team2->save();

            return $team1;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function calculateScore($match)
    {
        if ($match['score_team1'] > $match['score_team2']) {
            $match['add1'] = config('common.score.win');
            $match['add2'] = config('common.score.lose');
        } elseif ($match['score_team1'] == $match['score_team2']) {
            $match['add1'] = config('common.score.draw');
            $match['add2'] = config('common.score.draw');
        } else {
            $match['add1'] = config('common.score.lose');
            $match['add2'] = config('common.score.win');
        }

        return $match;
    }
}
