<?php

namespace App\Payroll\PaydayCalculator;

interface HasCalculateEmployerPaymentDateInterface
{
    public function calculateEmployerPaymentDate(): ?\DateTime;

}