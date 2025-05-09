<?php

use PHPUnit\Framework\TestCase;
use App\Payroll\PaydayCalculator\SecondToLastBusinessDayStrategy;
use App\Payroll\PaydayCalculator\WorkingDayDelayDecorator;
use App\Payroll\PaydayCalculator\PaydayCalculator;

class PayrollCalculatorTest extends TestCase
{
    public static function providePayrollDates(): array
    {
        return [
            // Format: [year, month, expected employee pay date, expected employer payment date]
            [2025, 5, '2025-05-30', '2025-05-26'], // 30th is Friday, 4 weekdays before is Monday 26th
            [2025, 6, '2025-06-27', '2025-06-23'], // 29th is Sunday → back to Friday 27th
            [2025, 2, '2025-02-27', '2025-02-21'], // 28th is Friday, 2nd last day is 27th (Thursday)
            [2024, 2, '2024-02-28', '2024-02-22'], // Leap year
            [2025, 8, '2025-08-29', '2025-08-25'], // 31st Sunday, 30th Saturday → back to Friday 29th
            [2025, 11, '2025-11-28', '2025-11-24'], // 30th Sunday → 29th Saturday → 28th Friday
        ];
    }

    /**
     * @dataProvider providePayrollDates
     */
    public function testPayrollDates(int $year, int $month, string $expectedEmployeePayDate, string $expectedEmployerPaymentDate): void
    {
        $baseStrategy = new SecondToLastBusinessDayStrategy();
        $delayedStrategy = new WorkingDayDelayDecorator($baseStrategy, 4);
        $calculator = new PaydayCalculator($delayedStrategy);

        $result = $calculator->getPayrollDates($year, $month);

        $this->assertEquals($expectedEmployeePayDate, $result['employee_pay_date'], 'Incorrect employee pay date');
        $this->assertEquals($expectedEmployerPaymentDate, $result['employer_payment_date'], 'Incorrect employer payment date');
    }
}
