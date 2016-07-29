{{ trans('message.click_link_reset_password') }} <a href="{{ $link = url('password/reset', $token) . '?email=' . urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
