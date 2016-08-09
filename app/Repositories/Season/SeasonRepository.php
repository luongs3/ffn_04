<?php

namespace App\Repositories\Season;

use App\Models\League;
use App\Models\LeagueMatch;
use App\Models\Match;
use App\Repositories\BaseRepository;
use App\Models\Season;
use Exception;
use DB;

class SeasonRepository extends BaseRepository implements SeasonRepositoryInterface
{
    public function __construct(Season $season)
    {
        $this->model = $season;
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
                    $league = $row->leagues()->first();

                    if (count($league)) {
                        $rows[$key]['league'] = $league->name;
                    }
                }
                $data['from'] = ($rows->currentPage() - 1) * config('common.limit.page_limit') + 1;
                $data['to'] = $data['from'] + $rows->count() - 1;
            }

            $data['total'] = $rows->total();
            $data['rows'] = $rows;
            $data['columns'] = ['id', 'name', 'league'];

            return $data;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }


    public function store($input)
    {
        try {
            $leagueId = array_pull($input, 'league_id');

            $data = $this->model->create($input);
            $data->leagues()->sync([$leagueId]);

            if (!$data) {
                return ['error' => trans('message.creating_error')];
            }

            return $data;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }


    public function update($input, $id)
    {
        try {
            $leagueId = array_pull($input, 'league_id');
            $season = $this->model->find($id);
            $season->leagues()->sync([$leagueId]);
            $season->fill($input)->save();

            if (!count($season)) {
                return ['error' => trans('message.updating_error')];
            }

            return $id;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function delete($ids)
    {
        try {
            DB::beginTransaction();
            $data = $this->model->destroy($ids);
            LeagueMatch::whereIn('season_id', $ids)->delete();

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

    public function filter($filter = [])
    {
        try {
            $seasonIds = LeagueMatch::where('league_id', $filter['league_id'])->distinct()->lists('season_id');

            if (!count($seasonIds)) {
                return ['error' => trans('message.data_is_empty')];
            }

            $seasons = $this->model->whereIn('id', $seasonIds)->get();

            return $seasons;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }
}
