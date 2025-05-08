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
        $initialStrategy = new SecondToLastBusinessDayStrategy();
        $workingDayDelay = new WorkingDayDelayDecorator($initialStrategy, 4);

        $calculator = new PaydayCalculator($workingDayDelay);

        return response()->json($calculator->getPayrollDates($request->getYear(), $request->getMonth()));
    }

    public function calculateExpressPayday(CalculatePayDayRequest $request)
    {
        $initialStrategy = new SecondToLastBusinessDayStrategy();
        $expressPayment = new WorkingDayDelayDecorator($initialStrategy, 1);

        $calculator = new PaydayCalculator($expressPayment);

        return response()->json($calculator->getPayrollDates($request->getYear(), $request->getMonth()));
    }    
}
