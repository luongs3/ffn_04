<?php
/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 1/30/2016
 * Time: 10:38 AM
 */
namespace App\Repositories;

use Exception;
use DB;
use Excel;

abstract class BaseRepository
{
    protected $model;

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
                }
                $data['from'] = ($rows->currentPage() - 1) * 10 + 1;
                $data['to'] = $data['from'] + $rows->count() - 1;
            }

            $data['total'] = $rows->total();
            $data['rows'] = $rows;

            return $data;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function show($id)
    {
        try {
            $data = $this->model->find($id);

            if (!$data) {
                return ['error' => trans('message.item_not_exist')];
            }

            return $data;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function store($input)
    {
        try {
            $data = $this->model->create($input);

            if (!$data) {
                return ['error' => trans('message.creating_error')];
            }

            return $data;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function all($options = [])
    {
        try {
            $filter = isset($options['filter']) ? $options['filter'] : [];
            $attributes = isset($options['attributes']) ? $options['attributes'] : null;
            $data = $this->model->where($filter)->get($attributes);

            if (!count($data)) {
                return ['error' => trans('message.item_not_exist')];
            }

            return $data;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function update($input, $id)
    {
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

    public function delete($ids)
    {
        try {
            DB::beginTransaction();
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

    public function export($subject)
    {
        $data = $this->model->all();
        Excel::create($subject, function ($excel) use ($data) {
            $excel->sheet('sheet_name', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->export('csv');
    }

}
