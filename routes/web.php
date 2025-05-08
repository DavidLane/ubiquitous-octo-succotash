<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payroll\PaydayController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/payday/calculate', function() {
    return view('Payroll.index');
});

Route::post('/payday/calculate/express', [PaydayController::class, 'calculateExpressPayday']);
Route::post('/payday/calculate', [PaydayController::class, 'calculateRegularPayday']);

