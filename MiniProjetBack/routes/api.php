<?php

use App\Http\Controllers\CompteController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\FlareClient\Api;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource('/Transaction', TransactionController::class);
Route::post('/depot', [TransactionController::class,'depotArgent']);

Route::post('/retrait', [TransactionController::class,'retraitArgent']);

Route::post('/transfert', [TransactionController::class,'transfertArgent']);

Route::get('/getCompte', [CompteController::class,'getCompte']);

Route::post('/addCompte', [CompteController::class,'store']);

Route::get('/closeCompte/{id_user}', [CompteController::class,'closeCompte']);

Route::get('/blockedCompte/{id_user}', [CompteController::class,'blockCompte']);

Route::post('/addUser', [UserController::class,'store']);

Route::get('/getClient/{num}',[TransactionController::class,'getClient']);

Route::post('/code',[TransactionController::class,'transViaCode']);

Route::post('/retraitCode',[TransactionController::class,'retraitCode']);

Route::get('/getTransac/{tel}',[TransactionController::class,'getTransac']);


