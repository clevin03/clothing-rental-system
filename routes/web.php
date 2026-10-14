<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::resource('customers', CustomerController::class);

Route::get('/', function () {
    return view('welcome');
});
