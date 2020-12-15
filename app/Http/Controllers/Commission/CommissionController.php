<?php

namespace App\Http\Controllers\Commission;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AuthHelper;
use App\Commission;
use Illuminate\Support\Facades\DB;

class CommissionController extends Controller
{
    const LOGIN_EXPIRE_TIME = 60;
    const ADMIN_ROLE = 'admin';
    const API_INVALID = 'invalid';

    public function get(Request $request) {

        $token = $request->header('auth');
        $user = User::where('remember_token', '=', $token)->first();
        $role = $user['role'];

        if ($role == self::ADMIN_ROLE) {
            $page = !empty($request->query('page')) ? (int)$request->query('page'): 1;
            $limit = !empty($request->query('limit')
                && $request->query('limit')!='undefined')? $request->query('limit') : 10;

            $search = !empty($request->query('search')) ? json_decode($request->query('search'), true): [];
            $name = $search['name'] ?? "";
            $item = $search['item'] ?? "";
            $commission = $search['commission'] ?? "";
            $dateFrom = $search['dateFrom'] ?? "";
            $dateTo = $search['dateTo'] ?? "";

            $data = [];
            $query = DB::table('commission');

            if (!empty($name)) {
                $query->where("user_id", 'LIKE', '%'.$name.'%');
            }

            if (!empty($item)) {
                $query->where("items", 'LIKE', '%'.$item.'%');
            }

            if (!empty($commission)) {
                $query->where("commission", 'LIKE', '%'.$commission.'%');
            }

            if (!empty($dateFrom) && !empty($dateTo)) {
                $query->whereBetween("commission.updated_at", [$dateFrom, $dateTo]);
            }

            if (!empty($dateFrom) && empty($dateTo)) {
                $query->where("commission.updated_at", '>=', "{$dateFrom}");
            }

            if (empty($dateFrom) && !empty($dateTo)) {
                $query->where("commission.updated_at", '<=', "{$dateTo}");
            }

            $total = count($query->get());
            $records = $query->select('commission.id as id', 'users.id as sales_id', 'users.name as sales'
                , 'items.name as plan', 'items.id as plan_id', 'commission'
                , DB::raw('DATE(commission.updated_at) as updated_at'), 'commission.bonus')
                ->join('users', 'commission.user_id', '=', 'users.id')
                ->join('items', 'commission.items', '=', 'items.id')
                ->forPage($page, $limit)->get();
            $content = json_decode($records, true);
            $data['data'] = $content;
            $data['count'] = $total;
            $data['limit'] = $limit;
            return $data;

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

            date_default_timezone_set('America/Vancouver');
            $updatedAt = date('Y-m-d', time());


            $param = $request->all();
            $id = $param['id'] ?? "";
            $name = $param['name'] ?? "";
            $item = $param['item'] ?? "";
            $commission = $param['commission'] ?? "";
            $bonus = $param['bonus'] ?? "";

            $commissionRecord = Commission::find($id);
            $commissionRecord->user_id = $name;
            $commissionRecord->items = $item;
            $commissionRecord->commission = $commission;
            $commissionRecord->bonus = $bonus;
            $commissionRecord->updated_at = $updatedAt;
            $commissionRecord->save();

            return response()->json([
                'message' => 'Commission record Updated',
            ], 202);

        } else {
            return response()->json([
                'auth' => self::API_INVALID
            ]);
        }
    }

    /*
     * Create Items
     */
    public function create(Request $request) {
        $token = $request->header('auth');
        $user = User::where('remember_token', '=', $token)->first();
        $role = $user['role'];

        if ($role == self::ADMIN_ROLE) {

            date_default_timezone_set('America/Vancouver');
            $updatedAt = date('Y-m-d', time());
            $param = $request->all();
            $name = $param['name'] ?? "";
            $item = $param['item'] ?? "";
            $commission = $param['commission'] ?? "";
            $bonus = $param['bonus'] ?? "";

            foreach($name as $user_id) {
                foreach($item as $eachItem) {
                    Commission::create([
                        'user_id' => $user_id,
                        'items' => $eachItem,
                        'commission' => $commission,
                        'bonus' => $bonus,
                        'updated_at' => $updatedAt
                    ]);
                }
            }

            return response()->json([
                'message' => 'Commission record created',
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
            $item = $request->all();
            $id = $item['id'] ?? "";

            $item = Commission::find($id);
            $item->delete();

            return response()->json([
                'message' => 'Commission record deleted',
            ], 202);

        } else {
            return response()->json([
                'auth' => self::API_INVALID
            ]);
        }
    }
}
