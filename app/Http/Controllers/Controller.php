<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function returnSuccessResponseArray($array = null,$status_code = 200)
    {
        $array['status'] = $array['status'] ?? 'success';
        return response()->json($array,$status_code);
    }

    public function returnFailedResponseArray($array = null,$status_code = 400)
    {
        $array['status'] = $array['status'] ?? 'error';
        return response()->json($array,$status_code);
    }

    /**
     * Returns exceptions details.
     * @param object $e
     * @param bool $logFullError
     * @return string
     */
    public function errorDetails($e,$logFullError = false)
    {
        if($logFullError){
            return $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine();
        }
        else if(app()->environment() == 'local'){
            return $e->getMessage()/* . ' ' . $e->getFile() . ' ' . $e->getLine()*/;
        }else if (app()->environment() == 'production'){
            return $e->getMessage();
        }
        return $e->getMessage();
    }

    public static function showErrorDetails($e)
    {
        if(app()->environment() == 'local'){
            return $e->getMessage()/* . ' ' . $e->getFile() . ' ' . $e->getLine()*/;
        }
        return '';
    }


    public function appEnv()
    {
        return app()->environment();
    }
    public function appEnvLocal()
    {
        return app()->environment() === 'local';
    }
    public function appEnvProduction()
    {
        return app()->environment() === 'production';
    }
}
