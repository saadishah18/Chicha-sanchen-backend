<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdOnResource;
use App\Models\AddOn;
use App\Models\AddOnValue;
use Illuminate\Http\Request;

class ProductAdOnsController extends Controller
{
    public function index(){
        return view('admin.pages.adOns.index');
    }


    public function datatable(Request $request){
        try {
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
            $query= AddOn::query()
                ->whereNotIn('id', function ($query) {
                    $query->select('parent_id')
                        ->from('add_ons')
                        ->whereNotNull('parent_id');
//                        ->distinct();
                });
            $query=$query->where(function ($q) use ($searchValue){
                $q
                    ->orWhere('id', 'like', '%' .$searchValue . '%')
//                ->orWhere('display_name', 'like', '%' .$searchValue . '%')
//                ->orWhere('username', 'like', '%' .$searchValue . '%')
                    ->orWhere('name', 'like', '%' .$searchValue . '%');
            });
            // Total records
            $totalRecordsWithFilter=clone $query;
            $totalRecordsWithFilter = $totalRecordsWithFilter->select('count(*) as allcount')->count();

            // Fetch records
            $records=clone $query;
            $records =$records->orderBy($columnName,$columnSortOrder)
                ->select('add_ons.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();


            $data_arr = AdOnResource::collection($records)->toArray($request);
//        dd($data_arr);
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" =>$totalRecordsWithFilter,
                "iTotalDisplayRecords" => $totalRecordsWithFilter,
                "aaData" => $data_arr
            );
            return response()->json($response);
        }catch (\Exception $exception){
            echo "<pre>";
            print_r($exception->getMessage());
//         dd($exception->getMessage());
        }
    }

    public function store(Request $request){

    }

    public function create(){
        return view('admin.pages.adOns.index');
    }

    public function edit($id){

    }

    public function update(Request $request){

    }

    public function delete(Request $request){

    }

    public function assignValues(Request $request){
        try {
            $values = $request->values;
            foreach ($values as $key => $value){
//                dd($request->all());
                $matchThese = ['value' => $value, 'add_on_id' => $request->record_id,'price' => $request->price[$key]];
                $model = AddOnValue::updateOrCreate($matchThese, ['add_on_id' => $request->record_id]);
            }
            return response()->json(['message' => 'Values added','status' => 200],200);
        }catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage(),'status' => 500],500);
        }

    }
}
