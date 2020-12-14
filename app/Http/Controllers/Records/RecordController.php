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
        $status = $search['status'] ?? "";

        $data = [];
        $query = DB::table('records');

        if (!empty($name)) {
            $query->where("records.name", 'LIKE', '%'.$name.'%');
        }

        if (!empty($status)) {
            $query->where("records.status", 'LIKE', '%'.$status.'%');
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
            $query->whereBetween("records.created_at", [$dateFrom, $dateTo]);
        }

        if (!empty($dateFrom) && empty($dateTo)) {
            $query->where("records.created_at", '>=', "{$dateFrom}");
        }

        if (empty($dateFrom) && !empty($dateTo)) {
            $query->where("records.created_at", '<=', "{$dateTo}");
        }


        $query->orderBy('records.created_at', 'DESC');
        $total = count($query->get());
        $records = $query->select('records.id as id', 'records.name', 'users.id as sales_id', 'users.name as sales', 'records.iccid', 'records.pos', 'records.cm'
        , 'records.port_in', 'records.referer', 'records.referer_number', 'records.plan as plan_id', 'items.name as plan', DB::raw('DATE(records.created_at) as created_at'), 'records.status')
            ->join('users', 'records.sales', '=', 'users.id')
            ->join('items', 'records.plan', '=', 'items.id')
            ->forPage($page, $limit)->get();
        $content = json_decode($records, true);

        $data['data'] = $content;
        $data['count'] = $total;
        $data['limit'] = $limit;
        return $data;
    }

    public function update(Request $request) {

        $record = $request->all();
        $id = $record['id'];
        $name = $record['name'] ?? '';
        $sales = $record['sales'] ?? '';
        $iccid = $record['iccid'] ?? '';
        $pos = $record['pos'] ?? '';
        $cm = $record['cm'] ?? '';
        $port_in = $record['port_in'] ?? '';
        $referer = $record['referer'] ?? '';
        $referer_number = $record['referer_number'] ?? '';
        $plan = $record['plan'] ?? '';
        $status = $record['status'] ?? '';
        $selectedDate = $record['created_at'];


        $salesRecord = Records::find($id);
        $salesRecord->name = $name;
        $salesRecord->sales = $sales;
        $salesRecord->iccid = $iccid;
        $salesRecord->pos = $pos;
        $salesRecord->cm = $cm;
        $salesRecord->port_in = $port_in;
        $salesRecord->referer = $referer;
        $salesRecord->referer_number = $referer_number;
        $salesRecord->plan = $plan;
        $salesRecord->status = $status;
        $salesRecord->created_at = $selectedDate;
        $salesRecord->save();

        return response()->json([
            'message' => 'Record Updated',
        ], 202);
    }

    /*
     * Create records
     */
    public function create(Request $request) {
        $token = $request->header('auth');
        $record = $request->all();
        $auth = $this->authHelper->authenticate($token);

        date_default_timezone_set('America/Vancouver');
        $selectedDate = $record['created_at'];

        if (empty($selectedDate)) {
            $selectedDate = date('Y-m-d', time());
        }




        if($auth) {
            Records::create([
               'name'           => $record['name'] ?? '',
               'sales'          => $record['sales'] ?? '',
               'iccid'          => $record['iccid'] ?? '',
               'pos'            => $record['pos'] ?? '',
               'cm'             => $record['cm'] ?? '',
               'port_in'        => $record['port_in'] ?? '',
               'referer'        => $record['referer'] ?? '',
               'referer_number' => $record['referer_number'] ?? '',
               'plan'           => $record['plan'] ?? '',
               'status'         => $record['status'] ?? '',
               'created_at'     => $selectedDate
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
