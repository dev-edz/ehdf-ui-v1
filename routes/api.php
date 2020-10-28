<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HDFController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('persons', [HDFController::class, 'getPersons']);
Route::get('newpersons', [HDFController::class, 'getNewPersons']);
Route::get('transactions', [HDFController::class, 'getTransactions']);
Route::get('summary/persons', [HDFController::class, 'getRegisteredUserByDate']);
Route::get('summary/transactions', [HDFController::class, 'getAllTransactionByDate']);
Route::get('summary/newpersons', [HDFController::class, 'getLatestPersons']);

Route::get('latest', [HDFController::class, 'getLatest']);