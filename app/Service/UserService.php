<?php

namespace App\Service;

use App\Http\Resources\AdminUsersIndexResource;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserService
{
    public function dataTable($request){
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
        $query=User::query();
        $query=$query->where(function ($q) use ($searchValue){
            $q
                ->orWhere('id', 'like', '%' .$searchValue . '%')
//                ->orWhere('display_name', 'like', '%' .$searchValue . '%')
//                ->orWhere('username', 'like', '%' .$searchValue . '%')
                ->orWhere('fname', 'like', '%' .$searchValue . '%')
                ->orWhere('lname', 'like', '%' .$searchValue . '%')
                ->orWhere('dob', 'like', '%' .$searchValue . '%')
                ->orWhere('email', 'like', '%' .$searchValue . '%');
        });
        // Total records
        $totalRecordsWithFilter=clone $query;
        $totalRecordsWithFilter = $totalRecordsWithFilter->select('count(*) as allcount')->count();

        // Fetch records
        $records=clone $query;
        $records =$records->orderBy($columnName,$columnSortOrder)
            ->select('users.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $data_arr = UserResource::collection($records)->toArray($request);
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" =>$totalRecordsWithFilter,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }
}
