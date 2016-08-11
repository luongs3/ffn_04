<?php

namespace App\Repositories\MatchEvent;

use App\Models\Team;
use App\Repositories\BaseRepository;
use App\Models\MatchEvent;
use Exception;
use DB;

class MatchEventRepository extends BaseRepository implements MatchEventRepositoryInterface
{
    public function __construct(MatchEvent $matchEvent)
    {
        $this->model = $matchEvent;
    }

    public function index($subject, $options = [])
    {
        $limit = isset($options['limit']) ? $options['limit'] : config('common.limit.page_limit');
        $order = isset($options['order']) ? $options['order'] : ['key' => 'id', 'aspect' => 'DESC'];
        $filter = isset($options['filter']) ? $options['filter'] : [];

        try {
            $rows = $this->model->with('match')->where($filter)->orderBy($order['key'], $order['aspect'])->paginate($limit);
            $data['subject'] = $subject;
            $data['columns'] = isset($options['columns']) ? $options['columns'] : $this->model->getFillable();
            array_unshift($data['columns'], 'id');

            if (count($rows)) {
                foreach ($rows as $key => $row) {
                    $rows[$key] = $row->where('id', $row['id'])->first($data['columns']);
                    $rows[$key]['match'] = $this->getMatchName($row->match)->name;
                }
                $data['from'] = ($rows->currentPage() - 1) * config('common.limit.page_limit') + 1;
                $data['to'] = $data['from'] + $rows->count() - 1;
            }

            $data['total'] = $rows->total();
            $data['rows'] = $rows;
            $data['columns'] = ['id', 'match', 'time', 'title', 'content'];

            return $data;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function getIconTypes()
    {
        return [
            'icon-live-01' => trans('general.match_start_end'),
            'icon-live-02' => trans('general.offside'),
            'icon-live-03' => trans('general.yellow_card'),
            'icon-live-04' => trans('general.red_card'),
            'icon-live-05' => trans('general.pitch'),
            'icon-live-06' => trans('general.score'),
            'icon-live-07' => trans('general.own_goal'),
            'icon-live-08' => trans('general.corner'),
            'icon-live-09' => trans('general.substitution'),
            'icon-live-10' => trans('general.free_kick'),
        ];
    }

    public function getMatchEventTypes()
    {
        return [
            'match_start_end' => trans('general.match_start_end'),
            'offside' => trans('general.offside'),
            'yellow_card' => trans('general.yellow_card'),
            'red_card' => trans('general.red_card'),
            'pitch' => trans('general.pitch'),
            'score' => trans('general.score'),
            'own_goal' => trans('general.own_goal'),
            'corner' => trans('general.corner'),
            'substitution' => trans('general.substitution'),
            'free_kick' => trans('general.free_kick'),
        ];
    }
}
