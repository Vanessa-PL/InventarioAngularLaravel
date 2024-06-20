<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductoViewController extends Controller
{
    public function index()
    {
        // Obtener la lista de productos desde la API
        $response = Http::get('http://127.0.0.1:8000/api/productos');
        $productos = $response->json();

        return view('productos', compact('productos'));
    }

    public function store(Request $request)
    {
        // Enviar la solicitud POST a la API para crear un producto
        $response = Http::post('http://127.0.0.1:8000/api/productos', [
            'nombre' => $request->nombre,
            'precio' => $request->precio,
        ]);

        // Redirigir o mostrar algún mensaje de éxito/error según la respuesta de la API
    }

    public function update(Request $request, $codigoProducto)
    {
        // Enviar la solicitud PUT a la API para actualizar un producto
        $response = Http::put("http://127.0.0.1:8000/api/productos/{$codigoProducto}", [
            'nombre' => $request->nombre,
            'precio' => $request->precio,
        ]);

        // Redirigir o mostrar algún mensaje de éxito/error según la respuesta de la API
    }

    public function destroy($codigoProducto)
    {
        // Enviar la solicitud DELETE a la API para eliminar un producto
        $response = Http::delete("http://127.0.0.1:8000/api/productos/{$codigoProducto}");

        // Redirigir o mostrar algún mensaje de éxito/error según la respuesta de la API
    }
}
