<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function handlePayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $event = Event::find(1);
        $paymentMethodId = $request->paymentMethodId;
        $email = auth()->user()->email;
        $customer = \Stripe\Customer::create([
            'payment_method' => $paymentMethodId,
            'email' => $email,
            'invoice_settings' => [
                'default_payment_method' => $paymentMethodId,
            ],
        ]);

        $paymentIntent = PaymentIntent::create([
            'amount' => $event->price * 100,
            'currency' => 'usd',
            'customer' => $customer->id,
            'payment_method' => $paymentMethodId,
            'off_session' => true,
            'confirm' => true,
        ]);

        return response()->json(['success' => true, 'paymentIntent' => $paymentIntent]);
    }
}
