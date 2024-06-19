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

    //Leer un producto
    public function show($CodigoProducto){

        $producto = Producto::where('CodigoProducto', $CodigoProducto)->first();
        // $producto = Producto::find($CodigoProducto);

        if(!$producto) {

            $data = [
                'mesagge' => 'Producto no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);

        }

        $data = [
            'Producto' => $producto,
            "status" => 200
        ];

        return response()->json($data, 200);

    }

    //Crear productos
    public function store(Request $request){

        $validator =  Validator::make($request->all(),[
            'CodigoProducto' => 'required|unique:productos',
            'Nombre' => 'required|max:255',
            'Cantidad' => 'required|numeric|max:999999',
            'PrecioUnitario' => 'required|numeric|max:99999999',
            'Total' => 'required'  
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $producto = Producto::create([
            'CodigoProducto' => $request->CodigoProducto,
            'Nombre' => $request->Nombre,
            'Cantidad' => $request->Cantidad,
            'PrecioUnitario' => $request->PrecioUnitario,
            'Total' => $request->Total  
        ]);

        if (!$producto){
            $data = [
                'menssage' => "Error al crear el producto",
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'producto' => $producto,
            'status' => 201
        ];

        return response()->json($data, 201);

    }


}
