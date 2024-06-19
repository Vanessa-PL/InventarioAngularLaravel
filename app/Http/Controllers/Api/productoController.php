<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;

class productoController extends Controller
{

    //Leer productos
    public function index(){
        
        $productos = Producto::all();

        $data = [
            'Productos' => $productos,
            'estado' => 200
        ];

        return response()->json($data, 200);
    }

}
