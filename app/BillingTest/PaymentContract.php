<?php

namespace App\BillingTest;

interface PaymentContract {
    public function setDiscount($amount);

    public function charge($amount);
}