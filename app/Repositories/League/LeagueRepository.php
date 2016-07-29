<?php

namespace App\Repositories\League;

use App\Repositories\BaseRepository;
use App\Models\League;
use Exception;
use Auth;
use DB;

class LeagueRepository extends BaseRepository implements LeagueRepositoryInterface
{
    public function __construct(League $league)
    {
        $this->model = $league;
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
