<?php

namespace App\Http\Controllers;

use App\Models\personal_type;
use Illuminate\Http\Request;

class PersonalTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $typePersonal = personal_type::all();
        return response()->json($typePersonal);
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
            $typePersonal = new personal_type;
            $typePersonal->label = $request->label;
            $typePersonal->value = $request->value;
            $typePersonal->save();
            return response()->json(['message'=>'Registro Creado'],200);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->errorInfo[2]],400);
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\personal_type  $personal_type
     * @return \Illuminate\Http\Response
     */
    public function show(personal_type $personal_type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\personal_type  $personal_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $typePersonal = personal_type::findOrFail($id);
            $typePersonal->label = $request->label;
            $typePersonal->value = $request->value;
            $typePersonal->update();
            return response()->json(['message'=>'Registro Actualizado'],200);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->errorInfo[2]],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\personal_type  $personal_type
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $typePersonal = personal_type::findOrFail($id);
            $typePersonal->delete();            
            return response()->json(['message'=>'Registro Eliminado'],200);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->errorInfo[2]],400);
        }
    }
}
