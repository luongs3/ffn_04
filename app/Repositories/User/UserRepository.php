<?php
namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\Models\User;
use App\Models\SocialAcount;
use Exception;
use Mail;
use DB;
use DateTime;
use Carbon\Carbon;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function create($request, $confirmationCode)
    {
        $user = [
            'email' => $request->email,
            'name' => $request->name,
            'password' => $request->password,
            'confirmed' => config('common.user.confirmed.not_confirm'),
            'confirmation_code' => $confirmationCode,
        ];

        $createUser = $this->model->create($user);

        if (!$createUser) {
            throw new Exception('message.create_user_fail');
        }

        $sendMailData = [
            'email' => $request->email,
            'name' => $request->name,
            'confirmation_code' => $confirmationCode,
        ];
        Mail::send('emails.welcome', $sendMailData, function ($message) use ($sendMailData){
            $message->to($sendMailData['email'], $sendMailData['name'])->subject(trans('label.confirm_register'));
        });

        return $createUser;
    }

    public function updateConfirm($confirmationCode)
    {
        $user = $this->model->confirmationCode($confirmationCode)->first();

        $user->confirmation_code = '';
        $user->confirmed = config('common.user.comfirmed.is_confirm');
        $user->save();

        if (!$user) {
            throw new Exception('message.item_not_exist');
        }

        return $user;
    }

    public function createSocialUser($socialUser, $social)
    {
        $existUser = $this->model->userEmail($socialUser->getEmail())->first();

        if (!$existUser) {
            try {
                DB::beginTransaction();
                $user = $this->model->create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'avatar' => $socialUser->getAvatar(),
                    'confirmed' => config('common.user.confirmed.is_confirm'),
                    'confirmation_conde' => '',
                ]);
                $socialAcount = SocialAcount::create([
                    'user_id' => $user->id,
                    'type' => $social,
                    'social_user_id' => $socialUser->getId(),
                ]);
                DB::commit();

                return $user;
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }

        return $existUser;
    }

    public function taskSchedule()
    {
        $deleteUser = [];
        $users = $this->model->where('confirmed', config('common.user.confirmed.not_confirm'))->get();

        foreach ($users as $user) {
            $passedDays = Carbon::now()->diffInDays($user->created_at);

            if ($passedDays > config('common.user.user_limit')) {
                $deleteUser[] = [
                    'id' => $user->id,
                ];
            }
        }

        $delete = $this->model->destroy($deleteUser);
    }
}
