<?php

namespace App\Repositories\League;

use App\Models\LeagueMatch;
use App\Models\Match;
use App\Models\Rank;
use App\Models\Season;
use App\Models\Team;
use App\Repositories\BaseRepository;
use App\Models\League;
use Exception;
use Auth;
use DB;
use App\Models\Player;
use Carbon\Carbon;

class LeagueRepository extends BaseRepository implements LeagueRepositoryInterface
{
    public function __construct(League $league)
    {
        $this->model = $league;
    }

    public function store($input)
    {
        $input = $this->uploadImage($input, 'image');

        parent::store($input);
    }

    public function update($input, $id)
    {
        $input = $this->uploadImage($input, 'image', $id);

        parent::update($input, $id);
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

    public function rank($leagueId)
    {
        try {
            $lastSeason = LeagueMatch::where('league_id', $leagueId)->orderBy('season_id', 'DESC')->first();

            if (!($lastSeason)) {
                return ['error' => trans('message.season_data_is_empty')];
            }

            $rank['teams'] = Rank::where('season_id', $lastSeason['season_id'])->orderBy('score', 'DESC')->get();

            if (!count($rank['teams'])) {
                return ['error' => trans('message.rank_data_is_empty')];
            }

            $rank['league'] = League::find($lastSeason['league_id']);
            $rank['season'] = Season::find($lastSeason['season_id']);
            $teamIds = $rank['teams']->lists('team_id');
            $teams = Team::whereIn('id', $teamIds)->get();
            foreach ($teams as $key => $team) {
                $rank['teams'][$key]['team'] = $team['name'];
            }

            return $rank;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function schedule($leagueId)
    {
        try {
            $lastSeason = LeagueMatch::where('league_id', $leagueId)->orderBy('season_id', 'DESC')->first();

            if (!($lastSeason)) {
                return ['error' => trans('message.season_data_is_empty')];
            }

            $matchIds = LeagueMatch::where('season_id', $lastSeason['season_id'])->lists('match_id');
            $matches = Match::whereIn('id', $matchIds)->where('start_time', '>', Carbon::now()->toDateString())
                ->orderBy('start_time', 'ASC')->get();
            $matches = $this->getTeams($matches);
            $schedule['matches'] = $this->splitMatches($matches);
            $schedule['league'] = League::find($leagueId);
            $schedule['season'] = Season::find($lastSeason['season_id']);

            return $schedule;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function getTeams($matches)
    {
        $teamIDs = [];
        foreach ($matches as $key => $match) {
            if (!in_array($match['team1_id'], $teamIDs)) {
                array_push($teamIDs, $match['team1_id']);
            }

            if (!in_array($match['team2_id'], $teamIDs)) {
                array_push($teamIDs, $match['team2_id']);
            }
        }
        $teams = Team::whereIn('id', $teamIDs)->get();
        foreach ($matches as $key => $match) {
            $matches[$key]['team1'] = $teams->find($match['team1_id']);
            $matches[$key]['team2'] = $teams->find($match['team2_id']);
        }

        return $matches;
    }

    public function splitMatches($matches)
    {
        $count = $matches->count();
        $newMatches = [];
        for ($i = 0; $i < $count; $i++) {
            $dateString = Carbon::parse($matches[$i]['start_time'])->toDateString();
            $matches[$i]['start_time'] = Carbon::parse($matches[$i]['start_time'])->toTimeString();
            $newMatches[$dateString][] = $matches[$i];
            $j = $i + 1;
            while($j < $count && Carbon::parse($matches[$j]['start_time'])->toDateString() == $dateString) {
                array_push($newMatches[$dateString], $matches[$j]);
                $matches[$j]['start_time'] = Carbon::parse($matches[$j]['start_time'])->toTimeString();
                $i++;
                $j++;
            }
        }

        return $newMatches;
    }
}
