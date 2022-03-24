<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Validar mediante fecha
         */
        $data=[];
        $events = Events::orderBy('id','DESC')->get();
        foreach ($events as $key => $event) {
            $data[$key]=[
                'id'=>$event->id,
                'idItalentt' => $event->idItalentt,
                'name'=>$event->name,
                'banner'=>$event->banner,
                'aboutPersonal'=>json_decode($event->typePersonal),
                'initialDate'=>$event->initialDate,
                'endDate'=>$event->endDate,
                'hourly'=>json_decode($event->houry),
                'city'=>$event->city,
                'location'=>$event->location,
                'address'=>json_decode($event->address),
                'totalBudget'=>$event->totalBudget,
                'dailyBudget'=>$event->dailyBudget,
            ];
        }

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * crear tabla personal_type = [{label, value}]
         * crear tabla genero = [{label, value}]
         * crear tabla aptitudes = [{label, value}]
         * crear tabla sectores = [{label, value}]         
        */
        
        try {
            $newEvent = new Events();

            $newEvent->idItalentt = $request->idItalentt;
            $newEvent->name = $request->name;
            $newEvent->banner = $request->banner;
            $newEvent->typePersonal = json_encode($request->aboutPersonal);
            $newEvent->initialDate = $request->initialDate;
            $newEvent->endDate = $request->endDate;
            $newEvent->houry = json_encode($request->houry);
            $newEvent->city = $request->city;
            $newEvent->location = $request->location;
            $newEvent->address = json_encode($request->address);
            $newEvent->totalBudget = $request->totalBudget;
            $newEvent->dailyBudget = $request->dailyBudget;
            
            $newEvent->save();

            return response()->json(['message'=>'Evento Guardado'],200);
        } catch (\Throwable $th) {
            return response()->json(['message'=> $th->errorInfo[2]],400);
        }

        /**
         * idItalentt, 
         * name,
         * banner,
         * aboutPersonal: {
         *      type:string,
         *      quantity: number,
         *      description: string
         * },
         * initialDate: Date,
         * endDate: Date,
         * houry: {
         *       'day-1': {
         *           initial: number,
         *           end: number
         *       }
         * },
         * city: string,
         * location: string guardar latitud y longitud,
         * address: {
         *       name: string,
         *       image: base64, not null
         *       position: {
         *           lat: number,
         *           lng: number
         *       }
         *   },
         *  totalBudget: number,
         *  dailyBudget: number,         
         *  status: open o close // validar mediante endDate
         */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $event = Events::where('name',$name)->get();
        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {        
        try {
            $newEvent = Events::findOrFail($id);

            $newEvent->idItalentt = $request->idItalentt;
            $newEvent->name = $request->name;
            $newEvent->banner = $request->banner;
            $newEvent->typePersonal = json_encode($request->aboutPersonal);
            $newEvent->initialDate = $request->initialDate;
            $newEvent->endDate = $request->endDate;
            $newEvent->houry = json_encode($request->houry);
            $newEvent->city = $request->city;
            $newEvent->location = $request->location;
            $newEvent->address = json_encode($request->address);
            $newEvent->totalBudget = $request->totalBudget;
            $newEvent->dailyBudget = $request->dailyBudget;
            
            $newEvent->save();

            return response()->json(['message'=>'Evento Actualizado'],200);
        } catch (\Throwable $th) {
            return response()->json(['message'=> $th->errorInfo[2]],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $event = Events::findOrFail($id);
        $event->delete();
        return response()->json(['message'=>'Evento Eliminado'],200);
    }
}
