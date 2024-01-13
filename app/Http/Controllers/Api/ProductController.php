<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\FeaturedProductResource;
use App\Models\Category;
use App\Models\Outlet;
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
}
