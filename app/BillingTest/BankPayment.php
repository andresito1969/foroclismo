<?php
namespace App\BillingTest;

class BankPayment implements PaymentContract{
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
        return [
            'amount' => $amount - $this->discount,
            'confirmation_numer' => 12,
            'currency' => $this->currency,
            'discount' => $this->discount
        ];
    }
}