<?php
namespace App\Repositories\AdminMessage;

use App\Repositories\BaseRepository;
use App\Models\AdminMessage;
use App\Repositories\Match\MatchRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Exception;

class AdminMessageRepository extends BaseRepository implements AdminMessageRepositoryInterface
{
    protected $matchRepository;
    protected $userRepository;

    public function __construct(
        AdminMessage $adminMessage,
        MatchRepositoryInterface $matchRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->model = $adminMessage;
        $this->matchRepository = $matchRepository;
        $this->userRepository = $userRepository;
    }

    public function all($options = [])
    {
        try {
            $filter = isset($options['filter']) ? $options['filter'] : [];
            $limit = config('common.message.user_message_limit');
            $data = $this->model->where($filter)->orderBy('id', 'DESC')->take($limit)->get();

            if (!count($data)) {
                return ['error' => trans('message.item_not_exist')];
            }

            return $data;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function alertCreateBet($userBet)
    {
        try {
            $type = config('common.message.type.user_bet');
            $checkDuplicatedAdminMessage = $this->checkDuplicatedMessage($userBet, $type);

            if (!$checkDuplicatedAdminMessage) {
                $content = $this->getMessageContent($type, $userBet);
                $adminMessage = [
                    'type' => $type,
                    'content' => $content,
                    'target' => $userBet->id,
                ];
                $this->store($adminMessage);
            }
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

            $additionalUnreadAdminMessage = 1;
            $admins = $this->userRepository->whereRole(config('common.user.role.admin'));
            $this->userRepository->increaseMessage($admins, $additionalUnreadAdminMessage);

            return $data;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function checkDuplicatedMessage($data, $type)
    {
        $returnedData = $this->model->where(['type' => $type, 'target' => $data['id']])->get();

        if (count($returnedData)) {
            return true;
        }

        return false;
    }
}
