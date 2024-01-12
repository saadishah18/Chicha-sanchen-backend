<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\OutletInterface;
use App\Service\Facades\Api;
use App\Service\OutletService;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public $interface;
    public function __construct(OutletInterface $outlet)
    {
        $this->interface = $outlet;
    }

    public function index(Request $request){
        try {
            return $this->interface->index($request);
        }catch (\Exception $exception){
            return Api::server_error($exception);
        }
    }

    public function detail(Request $request){
        try {
            return $this->interface->detail($request);
        }catch (\Exception $exception){
            dd($exception->getMessage(),$exception->getFile(),$exception->getLine(),$exception->getTrace());
            return Api::error($exception);
        }
    }
}
