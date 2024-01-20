<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdOnResource;
use App\Models\AddOn;
use App\Models\AddOnValue;
use App\Models\ProductAdOns;
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
                $matchThese = ['value' => $value, 'add_on_id' => $request->record_id,'price' => $request->price[$key]];
                $model = AddOnValue::updateOrCreate($matchThese, ['add_on_id' => $request->record_id]);
            }
            return response()->json(['message' => 'Values added','status' => 200],200);
        }catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage(),'status' => 500],500);
        }
    }

    public function storeProductAdOns(Request $request){
        try {
//            dd($request->all());
            ProductAdOns::where('product_id',$request->product_id)->delete();
            foreach ($request['add_on_value_id'] as $add_on_id => $values){
                foreach ($values as $child_add_on_id => $value){
                    if(is_array($value)){
                        foreach ($value as $value_index => $val){
                            $create_product_add_on_with_child = [
                                'product_id' => $request['product_id'],
                                'add_on_parent_id' => $add_on_id,
                                'add_on_id' => $child_add_on_id,
                                'value_id' => $val,
                            ];
                            ProductAdOns::create($create_product_add_on_with_child);
                        }
                    }else{
                        $create_product_add = [
                            'product_id' => $request['product_id'],
                            'add_on_parent_id' => null,
                            'add_on_id' => $add_on_id,
                            'value_id' => $value,
                        ];
                    }
                    ProductAdOns::create($create_product_add);
                }
            }
           /* foreach ($request['add_on_id'] as $key => $addOnId) {
                if($addOnId == 3) {
                    $addOnChildIds = $request['add_on_child_id'][$addOnId] ?? [];

                    if (count($addOnChildIds) == 0) {
                        $addOnValues = $request['add_on_value_id'][$addOnId] ?? [];
                        $detail = AddOn::find($addOnId);
                        foreach ($addOnValues as $key => $value) {
//                        dd($key, $addOnValues[$key], $addOnValues[$values]);
//                        foreach ($values as $value){
//                            $value_array[] = [
//                                'product_id' => $request['product_id'],
//                                'add_on_parent_id' => $detail->add_on_parent_id,
//                                'add_on_id' => $addOnId,
//                                'value_id' => $value,
//                            ];
//                        }
                            echo $value;
                        }
                    } else {
                        dd($addOnChildIds);
                        foreach ($addOnChildIds as $key => $child) {
                            $addOnValues = $request['add_on_child_id'][$child] ?? [];
                            dd($addOnValues);
                            $detail = AddOn::find($valueId);

                        }
                    }
                }
            }*/
            return redirect()->route('admin.products.index')->with('success','Ad on assigned to product');
        }catch (\Exception $exception){
            dd($exception->getMessage());
            return response()->json(['message' => $exception->getMessage(),'status' => 500],500);
        }
    }
}
