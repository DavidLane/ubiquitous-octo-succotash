<?php

namespace App\Payroll\PaydayCalculator;

interface PaydayStrategyInterface
{
    public function calculateEmployeePayDate(int $year, int $month): \DateTime;
}
