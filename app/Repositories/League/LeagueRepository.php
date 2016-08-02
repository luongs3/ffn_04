<?php

namespace App\Repositories\League;

use App\Repositories\BaseRepository;
use App\Models\League;
use Exception;
use Auth;
use DB;
use App\Models\Player;

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

    public function lists()
    {
        try {
            $data = $this->model->lists('name', 'id');

            if (!count($data)) {
                return ['error' => trans('message.listing_error')];
            }
            return $data;
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
}
