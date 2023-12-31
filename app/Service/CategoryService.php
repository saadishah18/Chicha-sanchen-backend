<?php

namespace App\Service;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Service\Facades\Api;

class CategoryService
{
    public function categoryProduct($request){
        $category = Category::with('products')->find($request->id);
        return Api::response(ProductResource::collection($category->products),'Category products listed');
    }
}

