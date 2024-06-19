<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\productoController;

//Create
Route::post('/productos', function () {
    return 'Crear poductos';
});

//Read
Route::get('/productos', [productoController::class, 'index']);

//Read
Route::get('/productos/{id}', function () {
    return 'Ver producto';
});

//Update
Route::put('/productos/{id}', function () {
    return 'Actualizar productos';
});

//Delete
Route::delete('/productos/{id}', function () {
    return 'Eliminar productos';
});
