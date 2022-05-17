<?php

namespace App\Http\Controllers;

use App\Models\sectors;
use Illuminate\Http\Request;

class SectorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sectors = Sectors::all();
        return response()->json($sectors);
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
            $sector = new sectors();
            $sector->label = $request->label;
            $sector->value = $request->value;
            $sector->save();

            return response()->json(['message'=>'Sector Creado'],200);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th],400);
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sectors  $sectors
     * @return \Illuminate\Http\Response
     */
    public function show(sectors $sectors)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sectors  $sectors
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {        
        try {
            $sector = Sectors::findOrFail($id);
            $sector->label = $request->label;
            $sector->value = $request->value;
            $sector->update();

            return response()->json(['message'=>'Sector Actualizado'],200);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sectors  $sectors
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $sector = Sectors::findOrFail($id);
            $sector->delete();

            return response()->json(['message'=>'Sector Eliminado'],200);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th],400);
        }
    }
}
