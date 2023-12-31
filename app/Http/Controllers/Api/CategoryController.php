<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\CategoryService;
use App\Service\Facades\Api;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $service;

    public function __construct(CategoryService $categoryService){
        $this->service = $categoryService;
    }

    public function categoryProduct(Request $request){
        try {
            return $this->service->categoryProduct($request);
        }catch (\Exception $exception){
            return Api::server_error($exception);
        }
    }
}
