<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseOrderController;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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
});

Route::get('supplier/list',[SupplierController::class,'FnViewList']);
Route::post('supplier/list', [SupplierController::class, 'store'])->name('suppliers.store');
Route::delete('supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

Route::get('item/list',[ItemController::class,'FnViewList']);
Route::post('item/list', [ItemController::class, 'store'])->name('item.store');
Route::delete('item/{id}', [ItemController::class, 'destroy'])->name('item.destroy');

Route::get('purchaseorder/list',[PurchaseOrderController::class,'create']);
Route::post('purchaseorder/list', [PurchaseOrderController::class, 'store']);
Route::get('purchaseorder/showorders', [PurchaseOrderController::class, 'showorders']);
Route::delete('purchasrorder/{id}', [PurchaseOrderController::class, 'destroy'])->name('purchaseorder.destroy');
Route::get('/purchaseorder/{id}/export', [PurchaseOrderController::class, 'export'])->name('purchaseorder.export');
Route::get('/purchaseorder/{id}', [PurchaseOrderController::class, 'show'])->name('purchaseorder.show');


require __DIR__.'/auth.php';
