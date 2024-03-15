<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApproverController;
use App\Http\Controllers\Api\ApprovalStageController;
use App\Http\Controllers\Api\ExpenseController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/approvers',[ApproverController::class,'store'])->name('approvers.store');
Route::prefix('approval-stages')->name('approval-stages.')->group(function(){
    Route::get('/', [ApprovalStageController::class, 'index'])->name('index');
    Route::post('/', [ApprovalStageController::class, 'store'])->name('store');
    Route::put('/{id}', [ApprovalStageController::class, 'update'])->name('update');
});
Route::prefix('expense')->name('expense.')->group(function(){
    Route::get('/{id}', [ExpenseController::class, 'show'])->name('show');
    Route::post('/', [ExpenseController::class, 'store'])->name('store');
    Route::patch('/{id}/approve', [ExpenseController::class, 'approve'])->name('approve');
});
