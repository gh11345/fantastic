<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Adldap\Auth\BindException;
use Adldap\Auth\UsernameRequiredException;
use Adldap\Auth\PasswordRequiredException;
use App\SessionManagement;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    const LOGIN_EXPIRE_TIME = 30;

    public function index()
    {
        return view('login');
    }

    public function register(Request $request)
    {
        $user = $request->all();
        $username = $user['name'] ?? "";
        $email = $user['email'] ?? "";
        $password = $user['password'] ?? "";

        if (!empty($password) &&!empty($email) ) {

            $token =  Str::random(60);
            User::create([
                'name' => $username,
                'email' => $email,
                'password' => $password,
                'remember_token' => $token
            ]);

            return response()->json([
                'message' => 'User created',
            ], 202);
        }

    }

    public function login(Request $request)
    {
        $user = $request->all();
        if (empty($user['email']) || empty($user['password'])) {
            return response()->json([
                'message' => 'Username or password empty',
                'auth' => 'fail'
            ], 400);
        }

        $authedUser = User::where('email', $user['email'])->where('password', $user['password'])->first();

        if (!empty($authedUser)) {
            $token =  Str::random(60);
            $authedUser->remember_token = $token;
            $authedUser->save();

            return response()->json([
                'token' => $token,
            ], 200);
        } else {
            return response()->json([
            ], 403);
        }


    }

    /**
     * @param $user
     * @return string
     */
    protected function resetSession($user)
    {
        $userAccount = User::where('email', '=', $user['email'])->first();
        $userId = $userAccount->id;
        $currentTime = Carbon::now()->toDateTimeString();
        $securityCode = $user['cookie'];
        $param = $this->sessionManagement->getSession($securityCode);
        if(!empty($user['cookie']) && !empty($param)) {
            $param = json_decode($param,true);
            $param['login_time'] = $currentTime;
            $param['status'] = 'active';
            $sessionData = json_encode($param);
        } else {
            $sessionId = Uuid::generate()->string;
            $securityCode = $sessionId;
            $param = [
                'login_time' => $currentTime,
                'id' => $userId,
                'status'=>'active'
            ];
            $sessionData = json_encode($param);
        }
        $this->sessionManagement->setSession($securityCode, $sessionData);
        return $securityCode;
    }
}
