<?php

namespace App\Http\Controllers;
use DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class NotificacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($password)
    {
        try {
            if ($password=='Noti22*-') {
                $notificaciones=DB::table('notificaciones')->where('status', '=', 2)->get();
                $total = DB::table('notificaciones')->where('status', '=', 2)->count();
                //$notificaciones = Notificaciones::where('status',2);

                $statusText=($total>0)?'Nuevas Notificaciones':'Sin Notificaciones';


                DB::table('notificaciones')
                  ->where('status', 2)
                  ->update(['status' => '1']);

                return response()->json(['notificaciones'=> $notificaciones,'status' => 200,'statusText' => $statusText], 200);
            } else {
                return response()->json(['status' => 200,'statusText' =>'Clave Incorrecta'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 400,'statusText' =>$th], 400);
        }
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
