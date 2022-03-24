<?php

namespace App\Http\Controllers;

use App\Models\gender;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gender = Gender::all();
        return response()->json($gender);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $gender = new Gender;
            $gender->label = $request->label;
            $gender->value = $request->value;
            $gender->save();

            return response()->json(['message'=>'Genero Creado'],200);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->errorInfo[2]],400);
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function show(gender $gender)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $gender = Gender::findOrFail($id);
            $gender->label = $request->label;
            $gender->value = $request->value;
            $gender->update();

            return response()->json(['message'=>'Genero Actualizado'],200);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->errorInfo[2]],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function destroy(gender $gender)
    {
        try {
            $gender = Gender::findOrFail($id);
            $gender->delete();

            return response()->json(['message'=>'Genero Eliminado'],200);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->errorInfo[2]],400);
        }
    }
}
