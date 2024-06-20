<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('productos');
});

use App\Http\Controllers\Api\productoController;

// Create
Route::post('/productos', [productoController::class, 'store']);

// Read
Route::get('/productos', [productoController::class, 'index']);

// Read
Route::get('/productos/{CodigoProducto}', [productoController::class, 'show']);

// Update
Route::put('/productos/{CodigoProducto}', [productoController::class, 'update']);

// Partial Update
Route::patch('/productos/{CodigoProducto}', [productoController::class, 'updatePartial']);

// Delete
Route::delete('/productos/{CodigoProducto}', [productoController::class, 'destroy']);
