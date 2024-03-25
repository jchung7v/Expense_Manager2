<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BucketController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/action/import', [ImportController::class, 'importCSV'])->name('expenses.import');
    
    Route::get('/action/list_transactions', [TransactionController::class, 'getTransactions'])->name('action.list_transactions');
    Route::post('/action/add_transaction', [TransactionController::class, 'addTransaction'])->name('action.add_transaction');
    Route::get('/action/get_transaction/{id}', [TransactionController::class, 'getTransactionById'])->name('action.get_transaction');
    Route::patch('/action/update_transaction/{id}', [TransactionController::class, 'updateTransaction'])->name('action.update_transaction');
    Route::delete('/action/delete_transaction/{id}', [TransactionController::class, 'deleteTransaction'])->name('action.delete_transaction');

    Route::get('/action/list_buckets', [BucketController::class, 'getBuckets'])->name('action.list_buckets');
    Route::post('/action/add_bucket', [BucketController::class, 'addBucket'])->name('action.add_bucket');
    Route::get('/action/get_bucket/{id}', [BucketController::class, 'getBucketById'])->name('action.get_bucket');
    Route::patch('/action/update_bucket/{id}', [BucketController::class, 'updateBucket'])->name('action.update_bucket');
    Route::delete('/action/delete_bucket/{id}', [BucketController::class, 'deleteBucket'])->name('action.delete_bucket');
});

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
});


require __DIR__.'/auth.php';
