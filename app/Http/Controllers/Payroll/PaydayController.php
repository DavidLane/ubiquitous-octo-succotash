<?php

namespace App\Http\Controllers\Payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CalculatePayDayRequest;
use App\Payroll\PaydayCalculator\SecondToLastBusinessDayStrategy;
use App\Payroll\PaydayCalculator\WorkingDayDelayDecorator;
use App\Payroll\PaydayCalculator\PaydayCalculator;

class PaydayController extends Controller
{
    public function calculateRegularPayday(CalculatePayDayRequest $request)
    {
        /* 
        * Using strategies so it's possible to easily change the logic of when the payment should happen. 
        * A param could be added to the request and routed through a Factory to get the correct logic
        * Additional strategies could include:
        * LastFridayOfMonthStrategy - Employees to be paid on the last Friday of each month so that payment always occurs before the weekend.
        * BiMonthlyPayStrategy - Employees to be paid twice a month — on the 15th and the last day — to support a bi-monthly payroll cycle.
        * WeeklyFridayStrategy - Hourly staff to be paid every Friday.
        */

        /*
        * Example:
        * $weeklyFridayStrategy = new WeeklyFridayStrategy();
        * $calculator = new PaydayCalculator($weeklyFridayStrategy);
        */

        $initialStrategy = new SecondToLastBusinessDayStrategy();
        $workingDayDelay = new WorkingDayDelayDecorator($initialStrategy, 4);

        /* 
        * We can also add an additional decorator here if we wanted to pay the day before a Bank Holiday, for example
        * Example:
        * $bankHolidayDelay = new BankHolidayDelayDecorator(new WorkingDayDelayDecorator($initialStrategy), 4));
        */

        /*
        * If this endpoint gets overloaded or becomes a stress point in the application this call could become a request to a microservice
        * $calculator = new PayDayCalculatorRequest($workingDayDelay);
        */

        $calculator = new PaydayCalculator($workingDayDelay);
        return response()->json($calculator->getPayrollDates($request->getYear(), $request->getMonth()));
    }

    public function calculateExpressPayday(CalculatePayDayRequest $request)
    {
        // Just showing it's easy to change the delay
        $initialStrategy = new SecondToLastBusinessDayStrategy();
        $expressPayment = new WorkingDayDelayDecorator($initialStrategy, 1); // faster payments enabled

        $calculator = new PaydayCalculator($expressPayment);

        return response()->json($calculator->getPayrollDates($request->getYear(), $request->getMonth()));
    }    
}
