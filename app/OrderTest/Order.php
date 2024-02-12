<?php
namespace App\OrderTest;
use App\Services\BillingTest\PaymentContract;

class Order {
    private $pay;
        
    public function __construct(PaymentContract $pay) {
        $this->pay = $pay;
    }

    public function all() {
        $this->pay->setDiscount(500);

        return 'info';
    }


}