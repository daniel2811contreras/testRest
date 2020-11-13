<?php

namespace App\Http\Controllers;

use App\Reservations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationsController extends Controller
{
    public function __construct() {
        $this->reservations = new Reservations();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $info = $this->reservations->get();
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
            'Restaurant_id' => 'required',
            'Cliente' => 'required',
            'Fecha_reserva' => 'required'
        ], [
            'required' => 'el campo :attribute es requerido.'
        ]);
        if($validator->fails()){
            $data = (object) [
                'status' => 422,
                'message' => 'error',
                'errors' => $validator->errors()
            ];
            return response()->json($data, 422);
        } else {
            $message= 'lo sentimos no hay reserva disponible para esta fecha';
            if(count($this->reservations
                ->where('Restaurant_id',$request->Restaurant_id)
                ->whereDate('Fecha_reserva',$request->Fecha_reserva)
                ->get())<15) {
                $this->reservations->create($request->all());
                $message= 'creada con exito';
            }
            $data = (object) ['message' => $message];
            return response()->json($data, 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int  $id)
    {
        //
        $info = $this->reservations->find($id);
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
     * Remove the specified resource from storage.
     *
     * @param  @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int  $id)
    {
        //
        $reservation = $this->reservations->find($id);
        if ($reservation !== null ) {
            $reservation->delete();
        }
        $data = (object) ['message' => 'eliminado con exito'];
        return response()->json($data, 200);
    }
}
