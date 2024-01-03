<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    public function index(){
        return view('admin.pages.users.index');
    }

    public function dataTable(Request $request){
        try {
            return $this->service->dataTable($request);
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }
}
