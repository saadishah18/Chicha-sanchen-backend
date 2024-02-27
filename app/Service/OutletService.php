<?php

namespace App\Service;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\OutletResource;
use App\Interfaces\OutletInterface;
use App\Models\Category;
use App\Models\Outlet;
use App\Service\Facades\Api;

class OutletService implements OutletInterface
{
    public function index($request)
    {
        $radius = isset($request['radius']) ? $request['radius'] :  5;
        $query = Outlet::query();
        $query->select('id', 'name', 'address', 'latitude', 'longitude');
        if ((isset($request['latitude']) && isset($request['longitude'])) && (!empty($request['latitude']) && !empty($request['longitude']))) {

            //Please note that the distance is calculated in kilometers because 6371 is used as the Earth's radius.
            // If you need to calculate the distance in miles, replace 6371 with 3959.
            $query->selectRaw(
                '( 6371 * acos( cos( radians(?) ) *
            cos( radians( latitude ) )
            * cos( radians( longitude ) - radians(?)
            ) + sin( radians(?) ) *
            sin( radians( latitude ) ) )
            ) AS distance', [$request['latitude'], $request['longitude'], $request['latitude']]
            )->having('distance', '<', $radius)
                ->orderBy('distance', 'asc');
        }
        $outlets = $query->get();
        return Api::response(OutletResource::collection($outlets), 'Outlets', 200);
    }

    public function detail($request){

        $outletId = $request->id;
        $outlet = Outlet::withCount('products')->find($outletId);
        $categories = Category::whereDoesntHave('parent')
        ->withCount(['children as children_count']) // Count the number of child categories
        ->with(['children.products' => function ($query) use ($outletId) {
            // Filter products in the specific outlet
            $query->whereHas('outlets', function ($subQuery) use ($outletId) {
                $subQuery->where('outlets.id', $outletId);
            });
        }])
            ->get();

       return Api::response(['categories' => CategoryResource::collection($categories),'product_count' => $outlet->products_count], 'Outlet categories');
    }
}
