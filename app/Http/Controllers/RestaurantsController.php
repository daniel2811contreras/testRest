<?php

namespace App\Http\Controllers;

use App\Restaurants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestaurantsController extends Controller
{
    public function __construct() {
        $this->restaurants = new Restaurants();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        $info = $this->restaurants
            ->orderBy('Nombre', 'asc')
            ->orderBy('Ciudad', 'asc')
            ->get();
        $data = (object) [
            'message' => 'listado con exito',
            'info' => $info
        ];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'Nombre' => 'required',
            'Descripcion' => 'required',
            'Direccion' => 'required',
            'Ciudad' => 'required',
            'Url_foto' => 'url',
        ], [
            'required' => 'el campo :attribute es requerido.',
            'url' => 'la url del campo :attribute no es valida.'
        ]);
        if($validator->fails()){
            $data = (object) [
                'status' => 422,
                'message' => 'error',
                'errors' => $validator->errors()
            ];
            return response()->json($data, 422);
        } else {
            $this->restaurants->create($request->all());
            $data = (object) ['message' => 'creado con exito'];
            return response()->json($data, 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
        $info = $this->restaurants->find($id);
        $message = "buscado con exito";
        if($info===null) { 
            $message = 'registro no encontrado';
        }
        $data = (object) [
            'message' => $message,
            'info' => $info
        ];
        return response()->json($data, 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,int $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'Nombre' => 'required',
            'Descripcion' => 'required',
            'Direccion' => 'required',
            'Ciudad' => 'required',
            'Url_foto' => 'url',
        ], [
            'required' => 'el campo :attribute es requerido.',
            'url' => 'la url del campo :attribute no es valida.'

        ]);
        if($validator->fails()){
            $data = (object) [
                'status' => 422,
                'message' => 'error',
                'errors' => $validator->errors()
            ];
            return response()->json($data, 422);
        } else {
            $this->restaurants->where('id',$id)
                ->first()
                ->fill($request->all())
                ->save();

            $info = $this->restaurants->findOrFail($id);
            $data = (object) [
                'message' => 'actualizado con exito',
                'info' => $info
            ];
            return response()->json($data, 202);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int  $id)
    {
        //
        $restaurant = $this->restaurants->find($id);
        if ($restaurant !== null ) {
            $restaurant->delete();
        }
        $data = (object) ['message' => 'eliminado con exito'];
        return response()->json($data, 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restory(int  $id)
    {
        //
        $restaurant = $this->restaurants->withTrashed()->find($id);
        if ($restaurant !== null ) {
            $restaurant->restore();
        }
        $data = (object) ['message' => 'recuperado con exito'];
        return response()->json($data, 200);
    }
}
