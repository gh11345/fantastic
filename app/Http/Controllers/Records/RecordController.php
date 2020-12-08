<?php

namespace App\Http\Controllers\Records;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AuthHelper;
use App\Records;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{
    protected $authHelper;

    public function __construct()
    {
        $this->authHelper = new AuthHelper();

    }

    public function get(Request $request) {

        $page = !empty($request->query('page')) ? (int)$request->query('page'): 1;
        $limit = !empty($request->query('limit')
            && $request->query('limit')!='undefined')? $request->query('limit') : 10;

        $search = !empty($request->query('search')) ? json_decode($request->query('search'), true): [];
        $name = $search['name'] ?? "";
        $sales = $search['sales'] ?? "";
        $iccid = $search['iccid'] ?? "";
        $pos = $search['pos'] ?? "";
        $cm = $search['cm'] ?? "";
        $port_in = $search['port_in'] ?? "";
        $referer = $search['referer'] ?? "";
        $referer_number = $search['referer_number'] ?? "";
        $plan = $search['plan'] ?? "";
        $dateFrom = $search['dateFrom'] ?? "";
        $dateTo = $search['dateTo'] ?? "";

        $data = [];
        $query = DB::table('records');

        if (!empty($name)) {
            $query->where("name", 'LIKE', '%'.$name.'%');
        }

        if (!empty($sales)) {
            $query->where("sales", 'LIKE', '%'.$sales.'%');
        }

        if (!empty($iccid)) {
            $query->where("iccid", 'LIKE', '%'.$iccid.'%');
        }

        if (!empty($pos)) {
            $query->where("pos", 'LIKE', '%'.$pos.'%');
        }

        if (!empty($cm)) {
            $query->where("cm", 'LIKE', '%'.$cm.'%');
        }

        if (!empty($port_in)) {
            $query->where("port_in", 'LIKE', '%'.$port_in.'%');
        }

        if (!empty($referer)) {
            $query->where("referer", 'LIKE', '%'.$referer.'%');
        }

        if (!empty($referer_number)) {
            $query->where("referer_number", 'LIKE', '%'.$referer_number.'%');
        }

        if (!empty($plan)) {
            $query->where("plan", 'LIKE', '%'.$plan.'%');
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


        $query->orderBy('id', 'DESC');
        $total = count($query->get());
        $content = json_decode($query->forPage($page, $limit)->get(), true);
        $data['data'] = $content;
        $data['count'] = $total;
        $data['limit'] = $limit;
        return $data;
    }

    /*
     * Create records
     */
    public function create(Request $request) {
        $token = $request->header('auth');
        $record = $request->all();
        $auth = $this->authHelper->authenticate($token);

        if($auth) {
            Records::create([
               'name'           => $record['name'],
               'sales'          => $record['sales'],
               'iccid'          => $record['iccid'],
               'pos'            => $record['pos'],
               'cm'             => $record['cm'],
               'port_in'        => $record['port_in'],
               'referer'        => $record['referer'],
               'referer_number' => $record['referer_number'],
               'plan'           => $record['plan'],

            ]);

            return response()->json([
                'message' => 'Record created',
            ], 202);
        } else {
            return response()->json([
                'message' => 'Auth Failed',
            ], 403);
        }
    }
}