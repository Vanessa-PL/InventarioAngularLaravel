<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\productoController;

//Create
Route::post('/productos', [productoController::class, 'store']);

//Read
Route::get('/productos', [productoController::class, 'index']);

//Read
Route::get('/productos/{CodigoProducto}', [productoController::class, 'show']);

//Update
Route::put('/productos/{id}', function () {
    return 'Actualizar productos';
});

//Delete
Route::delete('/productos/{CodigoProducto}', [productoController::class, 'destroy']);
