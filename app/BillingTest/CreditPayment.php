<?php
namespace App\BillingTest;

class CreditPayment implements PaymentContract{
    private $currency;
    private $discount;    

    public function __construct($currency) {
        $this->currency = $currency;
        $this->discount = 0;
    }

    public function setDiscount($discount) {
        $this->discount = $discount;
    }

    public function charge($amount) {
        $fee = $amount * 0.03;
        return [
            'amount' => ($amount - $this->discount) + $fee,
            'confirmation_numer' => 12,
            'currency' => $this->currency,
            'discount' => $this->discount,
            'fee' => $fee
        ];
    }
}