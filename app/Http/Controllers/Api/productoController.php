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


    //Eliminar producto
    public function destroy($CodigoProducto){

        $producto = Producto::where('CodigoProducto', $CodigoProducto)->first();
        // $producto = Producto::find($CodigoProducto);

        if(!$producto) {

            $data = [
                'mesagge' => 'Producto no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);

        }

        $producto->delete();

        $data = [
            'message' => "Producto eliminado",
            'ststus' => 200
        ];

        return response()->json($data, 200);

    }


    //Actualizar productos
    public function update(Request $request, $CodigoProducto){

        $producto = Producto::where('CodigoProducto', $CodigoProducto)->first();

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

        $producto->CodigoProducto = $request->CodigoProducto;
        $producto->Nombre = $request->Nombre;
        $producto->Cantidad = $request->Cantidad;
        $producto->PrecioUnitario = $request->PrecioUnitario;
        $producto->Total = $request->Total;

        $producto->save;

        $data = [
            'message' => 'Producto actualizado',
            'producto' => $producto,
            'status' => 200
        ];

        return response()->json($data, 200);

    }

    //Actualizar parcialmente los productos
    public function updatePartial(Request $request, $CodigoProducto) {
        $producto = Producto::where('CodigoProducto', $CodigoProducto)->first();
    
        if (!$producto) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
    
        $validator = Validator::make($request->all(), [
            'CodigoProducto' => 'unique:productos',
            'Nombre' => 'max:255',
            'Cantidad' => 'numeric|min:0|max:999999',
            'PrecioUnitario' => 'numeric|min:0|max:99999999',
            'Total' => 'numeric|min:0'
        ]);
    
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
    
        if ($request->has('CodigoProducto')) {
            $producto->CodigoProducto = $request->CodigoProducto;
        }
    
        if ($request->has('Nombre')) {
            $producto->Nombre = $request->Nombre;
        }
    
        if ($request->has('Cantidad')) {
            $producto->Cantidad = $request->Cantidad;
        }
    
        if ($request->has('PrecioUnitario')) {
            $producto->PrecioUnitario = $request->PrecioUnitario;
        }
    
        if ($request->has('Total')) {
            $producto->Total = $request->Total;
        }
    
        $producto->save();
    
        $data = [
            'message' => 'Producto actualizado',
            'producto' => $producto,
            'status' => 200
        ];
    
        return response()->json($data, 200);
    }
    

}
