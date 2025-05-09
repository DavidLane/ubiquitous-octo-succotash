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
        //  Using strategies so it's possible to easily change the logic of when the payment should happen
        $initialStrategy = new SecondToLastBusinessDayStrategy();
        // Decorating as we want to chain/affect the original logic
        $workingDayDelay = new WorkingDayDelayDecorator($initialStrategy, 4);
        // Run the calculations
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
