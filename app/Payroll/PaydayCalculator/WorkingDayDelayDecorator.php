<?php

namespace App\Payroll\PaydayCalculator;

use App\Payroll\PaydayCalculator\PaydayStrategyInterface;
use App\Payroll\PaydayCalculator\HasCalculateEmployerPaymentDateInterface;

class WorkingDayDelayDecorator implements PaydayStrategyInterface, HasCalculateEmployerPaymentDateInterface
{
    private PaydayStrategyInterface $baseStrategy;
    private int $workingDayDelay;
    private ?\DateTime $employeePayDate = null;

    public function __construct(PaydayStrategyInterface $baseStrategy, int $workingDayDelay = 4)
    {
        $this->baseStrategy = $baseStrategy;
        $this->workingDayDelay = $workingDayDelay;
    }

    public function calculateEmployeePaydate(int $year, int $month): \DateTime
    {
        $this->employeePayDate = $this->baseStrategy->calculateEmployeePaydate($year, $month);
        return $this->employeePayDate;
    }

    public function calculateEmployerPaymentDate(): ?\DateTime
    {
        return $this->subtractWorkingDays($this->employeePayDate, $this->workingDayDelay);
    }

    protected function subtractWorkingDays(\DateTime $date, int $days): \DateTime
    {
        while ($days > 0) {
            $date->modify('-1 day');
            $dow = (int)$date->format('w');
            if ($dow !== 0 && $dow !== 6) {
                $days--;
            }
        }
        return $date;
    }
}
