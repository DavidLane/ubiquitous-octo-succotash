<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payroll\PaydayController;

Route::post('/payday/calculate/express', [PaydayController::class, 'calculateExpressPayday']);
Route::post('/payday/calculate', [PaydayController::class, 'calculateRegularPayday']);
