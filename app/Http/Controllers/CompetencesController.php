<?php

namespace App\Http\Controllers;

use App\Models\competences;
use Illuminate\Http\Request;

class CompetencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $competences = competences::all();
        return response()->json($competences);
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
            $competence = new competences();
            $competence->label = $request->label;
            $competence->value = $request->value;

            $competence->save();

            return response()->json(['message'=>'Competencia Creada'],200);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->errorInfo[2]],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\competences  $competences
     * @return \Illuminate\Http\Response
     */
    public function show(competences $competences)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\competences  $competences
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $competence = competences::findOrFail($id);
            $competence->label = $request->label;
            $competence->value = $request->value;

            $competence->save();

            return response()->json(['message'=>'Competencia Actualizada'],200);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->errorInfo[2]],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\competences  $competences
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $competence = competences::findOrFail($id);
            $competence->delete();

            return response()->json(['message'=>'Competencia Eliminada'],200);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->errorInfo[2]],400);
        }
    }
}
