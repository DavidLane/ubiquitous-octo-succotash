<?php

namespace App\Payroll\PaydayCalculator;

use App\Payroll\PaydayCalculator\PaydayStrategyInterface;

class SecondToLastBusinessDayStrategy implements PaydayStrategyInterface
{
    public function calculateEmployeePaydate(int $year, int $month): \DateTime
    {
        $payday = new \DateTime("last day of {$year}-{$month}");
        $payday->modify('-1 day');

        $dow = (int)$payday->format('w');
        if ($dow === 0) {
            $payday->modify('-2 days');
        } elseif ($dow === 6) {
            $payday->modify('-1 day');
        }

        return $payday;
    }
}
