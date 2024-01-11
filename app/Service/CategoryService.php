<?php

namespace App\Service;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryTableResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Service\Facades\Api;

class CategoryService
{
    public function categoryProduct($request){
        $category = Category::with('products')->find($request->id);
        return Api::response(ProductResource::collection($category->products),'Category products listed');
    }

    public function datatable($request){
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

        $query = Category::query();
        $query = $query->where(function ($q) use ($searchValue){
            $q
//                ->orWhere('category_id', 'like', '%' .$searchValue . '%')
                ->where('name', 'like', '%' .$searchValue . '%');
//                ->orWhere('alias', 'like', '%' .$searchValue . '%');
        });

        //Total records
        $totalRecordsWithFilter = clone $query;
        $totalRecordsWithFilter = $totalRecordsWithFilter->select('count(*) as allcount')->count();

        //Fetch records
        $records  = clone $query;
        $records = $records->orderBy($columnName,$columnSortOrder)
            ->select('categories.*')
            ->skip($start)
            ->take($rowperpage)
            ->with('parent')
            ->get();
        $data_arr = CategoryTableResource::collection($records)->toArray($request);
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordsWithFilter,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }

    public function store($request){
        $data = $request->all();
        $data['parent_id'] = $request['category_id'] ?? Null;
        unset($data['category_id']);
        if ($request->has('image')) {

            $image_validation = image_validation($request->file('image'));

            if ($image_validation) {
                if ($data['image'] && file_exists(public_path('storage/' . $data['image']))) {
                    unlink(public_path('storage/' . $data['image']));
                }
                $path = $request->file('image')->store('/category', 'public');
                $data['image'] = $path;
            }
        }

        $category = Category::create($data);
        return $category;
    }
}

