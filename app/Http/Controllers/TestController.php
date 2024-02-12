<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BillingTest\PaymentContract;
use App\Services\OrderTest\Order;
class TestController extends Controller
{
    public function test(Order $order, PaymentContract $pay) {
        $order = $order->all();

        dd($pay->charge(2500));
    }
}
