<?php
namespace App\Repositories\Player;

use App\Repositories\BaseRepository;
use App\Models\Player;
use Exception;
use Auth;
use DB;

class PlayerRepository extends BaseRepository implements PlayerRepositoryInterface
{
    public function __construct(Player $player)
    {
        $this->model = $player;
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
                    $team = $row->team;

                    if (count($team)) {
                        $rows[$key]['team'] = $team->name;
                    }
                }
                $data['from'] = ($rows->currentPage() - 1) * config('common.limit.page_limit') + 1;
                $data['to'] = $data['from'] + $rows->count() - 1;
            }

            $data['total'] = $rows->total();
            $data['rows'] = $rows;
            $data['columns'] = ['id', 'name', 'image', 'team', 'role'];

            return $data;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function store($input)
    {
        $input = $this->uploadImage($input, 'image');

        try {
            $data = $this->model->create($input);

            if (!$data) {
                return ['error' => trans('message.updating_error')];
            }

            return $data;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function update($input, $id)
    {
        $input = $this->uploadImage($input, 'image', $id);

        try {
            $data = $this->model->where('id', $id)->update($input);

            if (!$data) {
                return ['error' => trans('message.updating_error')];
            }

            return $id;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function getPlayerRoles()
    {
        return [
            0 => trans('label.footballer'),
            1 => trans('label.coach'),
        ];
    }
}
