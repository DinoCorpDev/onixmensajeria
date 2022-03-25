<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Roles::all();
        return response()->json($roles);
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
            $newRol = new Roles();
            $newRol->label = $request->label;
            $newRol->value = $request->value;
            $newRol->save();

            return response()->json('Rol Created');
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->errorInfo[2]],400);
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $rol = Roles::where('label', $label)->first();
        return response()->json($rol);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $updateRol = Roles::findOrFail($id);
            $updateRol->label = $request->label;
            $updateRol->value = $request->value;
            $updateRol->update();

            return response()->json('Rol Updated');
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->errorInfo[2]],400);
        }        
    }
}
