<?php

namespace App\Listeners;

use App\Events\StripeWebHookEventNew;
use App\Models\Cart;
use App\Models\CartAddOnValue;
use App\Models\CartItem;
use App\Models\CartProductAddOns;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;
use Pusher\PusherException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeWebHookListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
//    public function handle(object $event): void
    public function handle(StripeWebHookEventNew $event): void
    {
        $stripe = new Stripe(config('stripe.secret_key'));

        // Validate webhook signature (omitted for brevity)

        $request_data = $event->request_data;
        Log::info(['req_data' => $request_data['data']['object']['id']]);
        $metadata = $request_data['data']['object']['metadata'];

        $check_status = $request_data['data']['object']['captured'];
        if ($check_status == true) {
            $order_id = $metadata['order_id'];
            $order = Order::find($order_id);
            $order->payment_status = 'Paid';
            $order->payment_object = json_encode($request_data);
            $order->transaction_id = $request_data['data']['object']['id'];
            $order->update();
            $order->addPoints();
            $this->sendPusherEvent(1);
            $cart = Cart::where('user_id', $metadata['user_id'])->first();
            $cartItems = CartItem::where('cart_id',$cart->id)->get();
            foreach ($cartItems as $key => $item){
                Log::info(['item_id'=> $item->id]);
                CartProductAddOns::where('cart_item_id',$item->id)->delete();
                CartAddOnValue::where('cart_item_id',$item->id)->delete();
                $item->delete();
            }
            $cart->delete();
        }
    }

    private function sendPusherEvent($receiver_id)
    {
        try {
            $options = [
                'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                'useTLS' => true,
            ];
            $pusher = new Pusher(
                config('broadcasting.connections.pusher.key'),
                config('broadcasting.connections.pusher.secret'),
                config('broadcasting.connections.pusher.app_id'),
                $options
            );

            $channel = 'order-updates-' . $receiver_id;
            $event = 'order-completed';
            $data = ['message' => 'A new order has been made. Refresh order table'];

            \Log::info('Sending Pusher event', [
                'channel' => $channel,
                'event' => $event,
                'data' => $data,
            ]);

            $pusher->trigger($channel, $event, $data);

        } catch (PusherException $e) {
            Log::error('Pusher error', ['exception' => $e]);
        } catch (\Exception $e) {
            Log::error('General error', ['exception' => $e]);
        }
    }
}
