<?php

namespace App\Http\Controllers;

use App\Models\EventsUsers;
use App\Models\Events;
use App\Models\Users;
use Illuminate\Http\Request;

class EventsUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=[];
        $events = EventsUsers::all();
        if($events){
            foreach ($events as &$event) {
                $dataEvent = Events::where('id',$event->id_event)->first();
                array_push($data,$dataEvent);
            }
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
        $eventUsers = new EventsUsers();
        $eventUsers->id_event = $request->id_event;
        $eventUsers->id_user = $request->id_user;
        $eventUsers->status = $request->status;
        $eventUsers->save();
        return response()->json('Postulación Guardada');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventsUsers  $eventsUsers
     * @return \Illuminate\Http\Response
     */
    public function show($name_event)
    {
        $event = Events::findOrFail($name_event);
        return response()->json($event);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventsUsers  $eventsUsers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $updateEventUsers = EventsUsers::findOrFail($id);
        $updateEventUsers->id_event = $request->id_event;
        $updateEventUsers->id_user = $request->id_user;
        $updateEventUsers->status = $request->status;
        $updateEventUsers->save();
        return response()->json('Postulación Actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventsUsers  $eventsUsers
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventsUsers $eventsUsers)
    {
        $eventUsers = EventsUsers::findOrFail($id);
        $eventsUsers->destroy();

        return response()->json('Postulación Eliminada');
    }
}
