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

    public function toggleApprove($id)
    {
        try {
            $this->service->toggleApprove($id);
            return $this->returnSuccessResponseArray(['status' => true]);
        }catch (\Exception $e){
            return $this->returnFailedResponseArray(['status' => false,'message' => $this->errorDetails($e)]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->delete($id);
            return $this->returnSuccessResponseArray(['status' => true]);
        }catch (\Exception $e){
            return $this->returnFailedResponseArray(['status' => false,'message' => $this->errorDetails($e)]);
        }
    }
}
