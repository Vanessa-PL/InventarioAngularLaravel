<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\productoController;

//Register
Route::post('/register', [AuthController::class, 'register']);

//Login
Route::post('/login', [AuthController::class, 'login']);

//Create
Route::post('/productos', [productoController::class, 'store']);

//Read
Route::get('/productos', [productoController::class, 'index']);

//Read
Route::get('/productos/{CodigoProducto}', [productoController::class, 'show']);

//Update
Route::put('/productos/{CodigoProducto}', [productoController::class, 'update']);

//Update
Route::patch('/productos/{CodigoProducto}', [productoController::class, 'updatePartial']);

//Delete
Route::delete('/productos/{CodigoProducto}', [productoController::class, 'destroy']);
