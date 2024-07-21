<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderApiResource;
use App\Http\Resources\OrderTableResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index(){
        return view('admin.pages.orders.index');
    }

    public function datatable(Request $request)
    {
//        $orders = Order::where('payment_status','paid')->orderBy('created_at','Desc')->get();
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        $query= Order::query()->where('payment_status','paid');
        $query = $query->join('users', 'orders.user_id', '=', 'users.id');
        $query= $query->where(function ($q) use ($searchValue){
            $q
                ->orWhere('orders.id', 'like', '%' .$searchValue . '%')
                ->orWhere('users.fname', 'like', '%' .$searchValue . '%')
                ->orWhere('users.lname', 'like', '%' .$searchValue . '%')
                ->orWhere('order_date', 'like', '%' .$searchValue . '%');
        });
        // Total records
        $totalRecordsWithFilter= clone $query;
        $totalRecordsWithFilter = $totalRecordsWithFilter->select('count(*) as allcount')->count();

        // Fetch records
        $records=clone $query;
        $records =$records->orderBy('orders.'.$columnName,$columnSortOrder)
            ->select([
                'orders.*',
                DB::raw('CONCAT(users.fname, " ", users.lname) AS full_name'), // Use DB::raw for expression within select
            ])
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = OrderTableResource::collection($records)->toArray($request);
//        dd($records);
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" =>$totalRecordsWithFilter,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $data_arr
        );
        return response()->json($response);
    }
}
