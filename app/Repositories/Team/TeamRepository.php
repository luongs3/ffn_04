<?php

namespace App\Repositories\Team;

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
}
