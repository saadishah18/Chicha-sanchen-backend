<?php

namespace App\Http\Controllers;

use App\Events\StripeWebHookEventNew;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function webHook(Request $request)
    {
        $complete_object = $request->all();
//        dd($request->all());
//        dispatch(new StripeWebhookEvent($complete_object));
//        event(new StripeWebhookEvent($complete_object));
        StripeWebHookEventNew::dispatch($complete_object);
        return response('success', 200);
    }

}
