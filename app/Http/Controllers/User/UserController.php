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
    const LOGIN_EXPIRE_TIME = 60;

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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $token = $request->header('auth');
        $user = User::where('remember_token', '=', $token)->first();

        if (!empty($user)) {
            $updateAt = $user['updated_at'];
            $currentTime = Carbon::now()->toDateTimeString();
            $start = strtotime($updateAt);
            $end = strtotime($currentTime);
            $timeDiff = round(($end - $start) / 60);

            if ($timeDiff <= self::LOGIN_EXPIRE_TIME) {
                return response()->json([
                    'auth' => 'valid'
                ], 200);
            } else {
                return response()->json([
                    'auth' => 'invalid'
                ], 200);
            }
        } else {
            return response()->json([
                'auth' => 'invalid'
            ], 200);
        }
    }
}
