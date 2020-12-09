<?php
namespace App\Model;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AuthHelper
{
    const LOGIN_EXPIRE_TIME = 60;
    public function authenticate($token)
    {
        $user = User::where('remember_token', '=', $token)->first();

        if (!empty($user)) {
            $updateAt = $user['updated_at'];
            $currentTime = Carbon::now()->toDateTimeString();
            $user->updated_at = $currentTime;
            $user->save();
            $start = strtotime($updateAt);
            $end = strtotime($currentTime);
            $timeDiff = round(($end - $start) / 60);

            if ($timeDiff <= self::LOGIN_EXPIRE_TIME) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
