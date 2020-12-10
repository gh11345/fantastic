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
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    const LOGIN_EXPIRE_TIME = 60;
    const ADMIN_ROLE = 'admin';
    const API_INVALID = 'invalid';

    public function index()
    {
        return view('login');
    }

    public function register(Request $request)
    {
        $token = $request->header('auth');
        $user = User::where('remember_token', '=', $token)->first();
        $role = $user['role'];

        if ($role == self::ADMIN_ROLE) {
            $user = $request->all();
            $username = $user['name'] ?? "";
            $email = $user['email'] ?? "";
            $password = $user['password'] ?? "";
            $role = $user['role'] ?? "";

            if (!empty($password) &&!empty($email) ) {

                $token =  Str::random(60);
                User::create([
                    'name' => $username,
                    'email' => $email,
                    'password' => $password,
                    'remember_token' => $token,
                    'role'  => $role
                ]);

                return response()->json([
                    'message' => 'User created',
                ], 202);
            }
        } else {
            return response()->json([
                'auth' => self::API_INVALID
            ]);
        }
    }

    public function update(Request $request)
    {
        $token = $request->header('auth');
        $user = User::where('remember_token', '=', $token)->first();
        $role = $user['role'];

        if ($role == self::ADMIN_ROLE) {
            $user = $request->all();
            $id = $user['id'] ?? "";
            $username = $user['name'] ?? "";
            $email = $user['email'] ?? "";
            $password = $user['password'] ?? "";
            $role = $user['role'] ?? "";

            $user = User::find($id);
            $user->name = $username;
            $user->email = $email;

            if (!empty($password)) {
                $user->password = $password;
            }

            $user->role = $role;
            $user->save();

            return response()->json([
                'message' => 'User Updated',
            ], 202);

        } else {
            return response()->json([
                'auth' => self::API_INVALID
            ]);
        }
    }

    public function delete(Request $request)
    {
        $token = $request->header('auth');
        $user = User::where('remember_token', '=', $token)->first();
        $role = $user['role'];

        if ($role == self::ADMIN_ROLE) {
            $user = $request->all();
            $id = $user['id'] ?? "";

            $user = User::find($id);
            $user->delete();

            return response()->json([
                'message' => 'User deleted',
            ], 202);

        } else {
            return response()->json([
                'auth' => self::API_INVALID
            ]);
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

    public function getUsers(Request $request)
    {
        $page = !empty($request->query('page')) ? (int)$request->query('page'): 1;
        $limit = !empty($request->query('limit')
            && $request->query('limit')!='undefined')? $request->query('limit') : 10;

        $search = !empty($request->query('search')) ? json_decode($request->query('search'), true): [];
        $name = $search['name'] ?? "";
        $email = $search['email'] ?? "";
        $role = $search['role'] ?? "";
        $dateFrom = $search['dateFrom'] ?? "";
        $dateTo = $search['dateTo'] ?? "";

        $data = [];
        $query = DB::table('users');

        if (!empty($name)) {
            $query->where("name", 'LIKE', '%'.$name.'%');
        }

        if (!empty($email)) {
            $query->where("email", 'LIKE', '%'.$email.'%');
        }

        if (!empty($role) || $role != 'Select a role') {
            $query->where("role", 'LIKE', '%'.$role.'%');
        }

        if (!empty($dateFrom) && !empty($dateTo)) {
            $query->whereBetween("updated_at", [$dateFrom, $dateTo]);
        }

        if (!empty($dateFrom) && empty($dateTo)) {
            $query->where("updated_at", '>=', "{$dateFrom}");
        }

        if (empty($dateFrom) && !empty($dateTo)) {
            $query->where("updated_at", '<=', "{$dateTo}");
        }

        $total = count($query->get());

        if ($page ==0 && $limit == 0) {
            $content = json_decode($query->select('id', 'name', 'email', 'role', 'updated_at')->get(), true);
        } else {
            $content = json_decode($query->select('id', 'name', 'email', 'role', 'updated_at')->forPage($page, $limit)->get(), true);
        }

        $data['data'] = $content;
        $data['count'] = $total;
        $data['limit'] = $limit;
        return $data;

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
                    'auth' => 'valid',
                    'role' => $user->role
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
