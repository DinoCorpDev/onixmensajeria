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
        $events = Events::where('state','1')->get();
        return response()->json($events);
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
        */

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

        $newEvent = new Events();
        $newEvent->name = $request->name;
        $newEvent->number = $request->number;
        $newEvent->required_personal = $request->required_personal;
        $newEvent->personal_type = $request->personal_type;
        $newEvent->personal_quantity = $request->personal_quantity;
        $newEvent->date_initial = $request->date_initial;
        $newEvent->date_final = $request->date_final;
        $newEvent->hourly = $request->hourly;
        $newEvent->place = $request->place;
        $newEvent->total_budget = $request->total_budget;
        $newEvent->daily_budget = $request->daily_budget;        
        $newEvent->save();

        return response()->json('Event saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $event = Events::findOrFail($name);
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
        $newEvent = Events::findOrFail($id);
        $newEvent->name = $request->name;
        $newEvent->number = $request->number;
        $newEvent->required_personal = $request->required_personal;
        $newEvent->personal_type = $request->personal_type;
        $newEvent->personla_quantity = $request->personla_quantity;
        $newEvent->date_initial = $request->date_initial;
        $newEvent->date_final = $request->date_final;
        $newEvent->hourly = $request->hourly;
        $newEvent->place = $request->place;
        $newEvent->total_budget = $request->total_budget;
        $newEvent->daily_budget = $request->daily_budget;
        $newEvent->qr_code = $request->qr_code;
        $newEvent->save();

        return response()->json('Event updated');
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
        $event->state = $request->state;
        $event->save();
        
        return response()->json('Event Updated');
    }
}
