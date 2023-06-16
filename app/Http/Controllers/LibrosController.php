<?php

namespace App\Http\Controllers;

use App\Models\libro;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LibrosController extends Controller
{
    /**
     *  muestra una lista de todos los recursos. ✔
     */
    public function index()
    {
        try {
            $libro = libro::all();
            return response()->json($libro, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * 
     * restablece el recurso especificado de la papelera de reciclaje.
     */
    public function restore(Request $request): Response
    {
        try {
            $libro = libro::withTrashed()->findOrFail($request->id);
            if ($libro->restore() === false) {
                return response()->json("No se encontro el libro", 404);
            }
            return Response($libro, 200);
        } catch (\Throwable $th) {
            return Response("No se encontro el libro con id:" . $request->id, 404);
        }
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento. ✔
     */
    public function store(Request $request)
    {
        try {
            //validar datos
            $request->validate([
                'titulo' => 'required',
                'autor' => 'required',
                'descripcion' => 'required',
                'genero' => 'required',
                'fecha_publicacion' => 'required',
                'isbn' => 'required',
                'editorial' => 'required',
                'portada' => 'nullable',
            ]);
            $libro = libro::create($request->all());
            return response()->json($libro, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource. ✔
     */
    public function show($id = null): Response
    {
        try {
            return Response(libro::findOrFail($id), 202);
        } catch (\Throwable $th) {
            return Response("No se encontro el libro con id:" . $id, 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento. ✔
     */
    public function update(Request $request): Response
    {
        try {
            $libro = libro::findOrFail($request->id);
            if ($libro->update($request->all()) === false) {
                return response()->json("No se encontro el libro", 404);
            }

            return Response($libro, 200);
        } catch (\Throwable $th) {
            return Response("No se encontro el libro con id:" . $request->id, 404);
        }
    }

    /**
     * Elimina el recurso especificado del almacenamiento. ✔
     */
    public function destroy($id)
    {
        try {
            $libro = libro::findOrFail($id);
            $libro->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
    /** 
     *Rutas de Libros online de lá de api.itbook.store utilizando GuzzleHttp
     *para consumir la api externa
     */
    public function librosOnline()
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'https://api.itbook.store/1.0/new');
            $libros = json_decode($response->getBody()->getContents());
            return response()->json($libros, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
