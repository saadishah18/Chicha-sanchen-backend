<?php

namespace App\Listeners;

use App\Events\StripeWebhookEvent;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
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
    public function handle(StripeWebhookEvent $event): void
    {
        $stripe = new Stripe(config('stripe.secret_key'));

        // Validate webhook signature (omitted for brevity)

        $request_data = $event->request_data;

        $payload = json_decode($event->getContent(), true);
        Log::info('request_datat =>'. $request_data);
        Log::info('$payload =>'. $payload);
        $paymentIntentId = $payload['data']['object']['id'];
        Log::info('$paymentIntentId =>'. $paymentIntentId);

//        try {
//            $paymentIntent = PaymentIntent::retrieve($paymentIntentId, []);
//            Log::info('paymentIntent => ' . $paymentIntent);
//            // Process the payment based on its status:
//            switch ($paymentIntent->status) {
//                case 'succeeded':
//                    $order = Order::find($paymentIntent->order_id);
//                    Log::info($order);
//                // Card charged successfully, process order fulfillment
////                return response()->json(['message' => 'Payment successful!']);
//                case 'payment_failed':
//                    // Card declined or other error, handle accordingly
////                return response()->json(['message' => 'Payment failed: ' . $paymentIntent->last_payment_error->message], 400);
//                default:
//                    // Handle other payment statuses (e.g., pending, canceled)
////                return response()->json(['message' => 'Payment status: ' . $paymentIntent->status]);
//            }
//        } catch (\Exception $e) {
//            // Handle potential errors (e.g., invalid payment intent ID)
//            Log::error($e->getMessage());
//            Log::error($e->getFile());
//            Log::error($e->getLine());
//            Log::error($e->getTrace());
//        }


    }
}
