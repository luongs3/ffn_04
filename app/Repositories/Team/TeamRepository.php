<?php

namespace App\Repositories\Team;

use App\Models\Player;
use App\Repositories\BaseRepository;
use App\Models\Team;
use Exception;
use Auth;
use DB;

class TeamRepository extends BaseRepository implements TeamRepositoryInterface
{
    public function __construct(Team $team)
    {
        $this->model = $team;
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
                    $league = $row->league;

                    if (count($league)) {
                        $rows[$key]['league'] = $league->name;
                    }
                }
                $data['from'] = ($rows->currentPage() - 1) * config('common.limit.page_limit') + 1;
                $data['to'] = $data['from'] + $rows->count() - 1;
            }

            $data['total'] = $rows->total();
            $data['rows'] = $rows;
            $data['columns'] = ['id', 'name', 'description', 'logo', 'league'];

            return $data;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function store($input)
    {
        $input = $this->uploadImage($input, 'logo');

        if (!empty($input['players'])) {
            $playerIds = $input['players'];
            unset($input['players']);
        }

        try {
            DB::beginTransaction();
            $data = $this->model->create($input);

            if(isset($playerIds)) {
                Player::whereIn('id', $playerIds)->update(['team_id' => $data->id]);
            }

            if (!$data) {
                return ['error' => trans('message.updating_error')];
            }

            DB::commit();

            return $data;
        } catch (Exception $ex) {
            DB::rollBack();

            return ['error' => $ex->getMessage()];
        }
    }

    public function update($input, $id)
    {
        $input = $this->uploadImage($input, 'logo', $id);

        if (!empty($input['players'])) {
            $playerIds = $input['players'];
            unset($input['players']);
        }

        try {
            DB::beginTransaction();
            $data = $this->model->find($id);
            $data->update($input);

            if(isset($playerIds)) {
                $data->players()->update(['team_id' => null]);
                Player::whereIn('id', $playerIds)->update(['team_id' => $data->id]);
            }

            if (!$data) {
                return ['error' => trans('message.updating_error')];
            }

            DB::commit();

            return $id;
        } catch (Exception $ex) {
            DB::rollBack();

            return ['error' => $ex->getMessage()];
        }
    }

    public function delete($ids)
    {
        try {
            $teams = $this->model->whereIn('id', $ids)->get();
            DB::beginTransaction();
            Player::whereIn('team_id', $ids)->update(['team_id' => null]);
            $teams->matches()->delete();
            $data = $teams->delete();

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
}
