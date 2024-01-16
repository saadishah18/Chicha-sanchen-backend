<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\FeaturedProductResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Outlet;
use App\Models\Product;
use App\Service\Facades\Api;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function featuredProducts(Request $request){
        $outletId = $request->id;
        $outlet = Outlet::withCount('products')->find($outletId);
        $categories = Category::whereDoesntHave('parent') // Select only parent categories
        ->whereHas('children' , function ($query) use ($outletId) {
            // Include the children categories
            $query->whereHas('products' , function ($q) use ($outletId) {
                $q->where('is_featured', 1);
//                // Filter products in the specific outlet and with is_featured = 1
                $q->whereHas('outlets', function ($subSubQuery) use ($outletId) {
                    $subSubQuery->where('outlets.id', $outletId);
                });
            });
        })->get();
//        $categories = Category::whereDoesntHave('parent')
//            ->with(['childrenRecursive' => function ($query) use ($outletId) {
//                $query->whereHas('products', function ($subQuery) use ($outletId) {
//                    $subQuery->where('is_featured', 1)
//                        ->whereHas('outlets', function ($outletSubQuery) use ($outletId) {
//                            $outletSubQuery->where('outlets.id', $outletId);
//                        });
//                });
//            }])
//            ->get();
//        dd($categories);
        return Api::response(['categories' => FeaturedProductResource::collection($categories),'product_count' => $outlet->products_count], 'Outlet categories');
    }

    public function productDetail($id){
        try {
            $product = Product::with('addOns.addOn')->find($id);
            return Api::response(new ProductResource($product),'Product detail');
        }catch (\Exception $exception){
            return Api::server_error($exception);
        }
    }

    public function searchProduct(Request $request){
        try {
            if (!Api::validate(['search' => 'required|max:15'])) {
                return Api::validation_errors();
            }
            $products = Product::where('name','like','%'.$request->search.'%')->get();
            return Api::response(ProductResource::collection($products),'Product detail');
        }catch (\Exception $exception){
            return Api::server_error($exception);
        }

    }
}
