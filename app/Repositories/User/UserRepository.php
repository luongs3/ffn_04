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
use Auth;
use File;
use Hash;

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
        $user->confirmed = config('common.user.confirmed.is_confirm');
        $user->save();

        if (!$user) {
            throw new Exception(trans('message.item_not_exist'));
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

    public function changePassword($request)
    {
        $user = Auth::user();

        if (!empty($user->password) && (Hash::check($request->password, $user->password))) {
            $user->update([
                'password' => $request->newPassword,
            ]);

            return $user;
        }

        return ['error' => trans('message.change_password_fail')];
    }

    public function updateInfo($request)
    {
        $userUpdate = $request->only(['name']);
        $oldImage = Auth::user()->avatar;
        $image = $this->uploadAvatar($request);
        $this->deleteImage($oldImage);

        if ($request->hasFile('avatar')) {
            $userUpdate['avatar'] = $image;
        }

        $user = Auth::user()->update($userUpdate);

        if (!$user) {
            return ['error' => trans('message.updating_error')];
        }

        return $user;
    }

    public function uploadAvatar($request)
    {
        $imagePath = public_path(config('common.user.avatar_path'));
        $image = $request->file('avatar');
        $extenstion = $image->getClientOriginalExtension();
        $fileName = time() . '.' . $extenstion;
        $image->move($imagePath, $fileName);
        $userData = [
            'avatar' => $fileName,
        ];

        return config('common.user.avatar_path') . $fileName;
    }

    public function allUser()
    {
        $limit = isset($options['limit']) ? $options['limit'] : config('common.limit.page_limit');
        $order = isset($options['order']) ? $options['order'] : ['key' => 'id', 'aspect' => 'DESC'];

        try {
            $users = $this->model->where('role', '<>', config('common.user.role.admin'))->orderBy($order['key'], $order['aspect'])->paginate($limit);
            return $users;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function destroy($ids)
    {
        try {
            $avatar = $this->model->whereIn('id', $ids)->lists('avatar');
            $this->deleteImage($avatar);
            DB::beginTransaction();
            SocialAcount::whereIn('user_id', $ids)->delete();
            $data = $this->model->destroy($ids);

            if (!$data) {
                return ['error' => trans('message.deleting_error')];
            }
            DB::commit();

            return $data;
        } catch (Exception $e) {
            DB::rollBack();

            return ['error' => $e->getMessage()];
        }
    }

    public function find($id)
    {
        try {
            $user = $this->model->findOrFail($id);

            if (!$user) {
                return ['error' => trans('message.item_not_exist')];
            }

            return $user;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }

    }

    public function adminCreate($request, $confirmationCode)
    {
        $user = [
            'email' => $request->email,
            'name' => $request->name,
            'password' => $request->password,
            'confirmed' => config('common.user.confirmed.not_confirm'),
            'confirmation_code' => $confirmationCode,
            'role' => $request->role,
            'point' => $request->point,
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

    public function adminUpdate($request, $id)
    {
        $userUpdate = $request->only(['email', 'name', 'role', 'point']);
        $userData = $this->find($id);

        if (isset($userData['error'])) {
            return ['error' => $userData['error']];
        }

        $user = $userData->update($userUpdate);

        if (!$user) {
            return ['error' => trans('message.updating_error')];
        }

        return $user;
    }

    public function deleteImage($pathImage = [])
    {
        if (!empty($pathImage) && file_exists($pathImage)) {
            File::delete($pathImage);
        }
    }

    public function optionRole()
    {
        $option = [
            config('common.user.role.admin') => trans('label.admin'),
            config('common.user.role.user') => trans('label.user'),
            config('common.user.role.team') => trans('label.team'),
        ];

        return $option;
    }

    public function optionActive()
    {
        $optionActive = [
            config('common.user.confirmed.not_confirm') => trans('label.invalid'),
            config('common.user.confirmed.is_confirm') => trans('label.activity'),
        ];

        return $optionActive;
    }
}
