<?php

namespace App\Repositories\Match;

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
}
