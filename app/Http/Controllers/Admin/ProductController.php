<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryTableResource;
use App\Models\Category;
use App\Models\Product;
use App\Service\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $service;

    public function __construct(ProductService $productService)
    {
        $this->service = $productService;
    }

    public function index(){
       return view('admin.pages.products.index');
    }

    public function datatable(Request $request){
        try {
            return $this->service->datatable($request);
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }

    public function create(Request $request){
        $categories = Category::whereNotNull('parent_id')->get();
        $categories = CategoryResource::collection($categories);
        return view('admin.pages.products.create',compact('categories'));

    }

    public function store(Request $request){
        try {
            $result = $this->service->store($request);
            return redirect()->route('admin.products.index')->with('success','Product added successfully');
        }catch (\Exception $exception){
            return redirect()->route('admin.products.index')->with('error',$exception->getMessage());
        }
    }
    public function edit(Product $id){
        try {
            $product = $id;
            $categories = Category::whereNotNull('parent_id')->get();
            $categories = CategoryResource::collection($categories);
            return view('admin.pages.products.edit',compact('categories','product'));
        }catch (\Exception $exception){
//            dd($exception->getMessage());
            return redirect()->route('admin.products.index')->with('error',$exception->getMessage());

        }
    }
    public function update(Request $request){
        try {
           $this->service->update($request);
            return redirect()->route('admin.products.index')->with('success','Product updated successfully');
        }catch (\Exception $exception){
            return redirect()->route('admin.products.index')->with('error',$exception->getMessage());
        }
    }
}
