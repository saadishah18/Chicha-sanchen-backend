<?php

namespace App\Service;

use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductTableResource;
use App\Http\Resources\UserResource;
use App\Models\Product;
use App\Models\User;
use App\Service\Facades\Api;

class ProductService
{
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
        $query=Product::query();
        $query=$query->where(function ($q) use ($searchValue){
            $q
                ->orWhere('id', 'like', '%' .$searchValue . '%')
//                ->orWhere('display_name', 'like', '%' .$searchValue . '%')
//                ->orWhere('username', 'like', '%' .$searchValue . '%')
                ->orWhere('name', 'like', '%' .$searchValue . '%')
                ->orWhere('description', 'like', '%' .$searchValue . '%')
                ->orWhere('price', 'like', '%' .$searchValue . '%')
                ->orWherehas('category',function ($qu) use($searchValue){
                    $qu->orWhere('name', 'like', '%' .$searchValue . '%');
                });
        });
        // Total records
        $totalRecordsWithFilter=clone $query;
        $totalRecordsWithFilter = $totalRecordsWithFilter->select('count(*) as allcount')->count();

        // Fetch records
        $records=clone $query;
        $records =$records->orderBy($columnName,$columnSortOrder)
            ->select('products.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $data_arr = ProductTableResource::collection($records)->toArray($request);
//        dd($data_arr);
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" =>$totalRecordsWithFilter,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $data_arr
        );
        return response()->json($response);
    }

    public function store($request)
    {
        $data = $request->all();
        $data['is_featured'] = $request->is_featured == 'Yes' ? 1 : 0;
//        $data['image'] = $data['attachment'];
        if ($request->has('image')) {

            $image_validation = $this->image_validation($request->file('image'));

            if ($image_validation) {
//                dd($model->image,file_exists(public_path('storage/' . $model->image)));
                if (file_exists(public_path('storage/products' . $request->image))) {
                    unlink(public_path('storage/' . $request->image));
                }
                $path = $request->file('image')->store('/products', 'public');
                $data['image'] = $path;
            }
        }
        $product = Product::create($data);
        return $product->refresh();
    }

    public function update($request){
        $model = Product::find($request->id);
        if ($request->filled('name')){
            $model->name = $request->name;
        }
//        $model->name = $request->name ?? '';
        if ($request->filled('age')){
            $model->category_id = $request->category_id;
        }
        if ($request->filled('description')){
            $model->description = $request->description;
        }
        if ($request->filled('price')){
            $model->price = $request->price;
        }
        if ($request->filled('is_featured')){
            $model->is_featured = $request->is_featured == 'yes' ? 1 :0;
        }

        if ($request->has('image')) {

            $image_validation = $this->image_validation($request->file('image'));

            if ($image_validation) {
                if ($model->image && file_exists(public_path('storage/' . $model->image))) {
                    unlink(public_path('storage/' . $model->image));
                }
                $path = $request->file('image')->store('/profile', 'public');
                $model->image = $path;
            }
        }

        $model->update();
    }


    public function image_validation($image)
    {
        if($image != null || $image  != ''){
            $fileExtension = substr(strrchr($image->getClientOriginalName(), '.'), 1);
            if ($fileExtension != 'jpg' && $fileExtension != 'jpeg' && $fileExtension != 'png' && $fileExtension != 'gif') {
                return Api::error('Image extension should be jpeg,jpg,png,and gif');
            }
            $filesize = \File::size($image);
            if ($filesize >= 1024 * 1024 * 20) {
                return Api::error('Image size should less than 20 mb');
            }

            return true;
        }
    }
}
