<?php

namespace App\Payroll\PaydayCalculator;

use App\Payroll\PaydayCalculator\PaydayStrategyInterface;
use App\Payroll\PaydayCalculator\HasCalculateEmployerPaymentDateInterface;


class PaydayCalculator
{
    public PaydayStrategyInterface $strategy;

    public function __construct(PaydayStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function getPayrollDates(int $year, int $month): array
    {
        $payrollDates = [];
        $employeePayDay = $this->strategy->calculateEmployeePayDate($year, $month);
        $payrollDates['employee_pay_date'] = $employeePayDay->format('Y-m-d');


        if ($this->strategy instanceof HasCalculateEmployerPaymentDateInterface) {
            $sendPaymentDay = $this->strategy->calculateEmployerPaymentDate();
            $payrollDates['employer_payment_date'] = $sendPaymentDay->format('Y-m-d');
        }

        return $payrollDates;
    }
}
