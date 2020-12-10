<?php

namespace App\Http\Controllers\Items;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AuthHelper;
use App\Item;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    const LOGIN_EXPIRE_TIME = 60;
    const ADMIN_ROLE = 'admin';
    const API_INVALID = 'invalid';

    public function get(Request $request) {

        $page = !empty($request->query('page')) ? (int)$request->query('page'): 1;
        $limit = !empty($request->query('limit')
            && $request->query('limit')!='undefined')? $request->query('limit') : 10;

        $search = !empty($request->query('search')) ? json_decode($request->query('search'), true): [];
        $name = $search['name'] ?? "";
        $price = $search['price'] ?? "";
        $desc = $search['desc'] ?? "";
        $dateFrom = $search['dateFrom'] ?? "";
        $dateTo = $search['dateTo'] ?? "";

        $data = [];
        $query = DB::table('items');

        if (!empty($name)) {
            $query->where("name", 'LIKE', '%'.$name.'%');
        }

        if (!empty($price)) {
            $query->where("price", 'LIKE', '%'.$price.'%');
        }

        if (!empty($desc)) {
            $query->where("desc", 'LIKE', '%'.$desc.'%');
        }

        if (!empty($dateFrom) && !empty($dateTo)) {
            $query->whereBetween("created_at", [$dateFrom, $dateTo]);
        }

        if (!empty($dateFrom) && empty($dateTo)) {
            $query->where("created_at", '>=', "{$dateFrom}");
        }

        if (empty($dateFrom) && !empty($dateTo)) {
            $query->where("created_at", '<=', "{$dateTo}");
        }

        $total = count($query->get());
        $records = $query->forPage($page, $limit)->get();
        $content = json_decode($records, true);
        $data['data'] = $content;
        $data['count'] = $total;
        $data['limit'] = $limit;
        return $data;

    }

    public function update(Request $request)
    {
        $token = $request->header('auth');
        $user = User::where('remember_token', '=', $token)->first();
        $role = $user['role'];

        if ($role == self::ADMIN_ROLE) {
            $item = $request->all();
            $id = $item['id'] ?? "";
            $name = $item['name'] ?? "";
            $price = $item['price'] ?? "";
            $desc = $item['desc'] ?? "";

            $item = Item::find($id);
            $item->name = $name;
            $item->price = $price;
            $item->desc = $desc;
            $item->save();

            return response()->json([
                'message' => 'Item Updated',
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
            $item = $request->all();
            $name = $item['name'] ?? "";
            $price = $item['price'] ?? "";
            $desc = $item['desc'] ?? "";

            Item::create([
                'name' => $name,
                'price' => $price,
                'desc' => $desc,
            ]);

            return response()->json([
                'message' => 'Item created',
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

            $item = Item::find($id);
            $item->delete();

            return response()->json([
                'message' => 'Item deleted',
            ], 202);

        } else {
            return response()->json([
                'auth' => self::API_INVALID
            ]);
        }
    }
}
