<?php

namespace App\Services\BillingTest;

interface PaymentContract {
    public function setDiscount($amount);

    public function charge($amount);
}