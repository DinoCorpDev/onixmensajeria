<?php

namespace App\Http\Controllers;

use App\Models\EventsUsers;
use App\Models\Events;
use App\Models\Users;
use Illuminate\Http\Request;
use Auth;
use \stdClass;

class EventsUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $data=[];
        $events = EventsUsers::where('id_user', $user_id)->get();
        if($events){
            foreach ($events as &$event) {
                $dataEvent = Events::where('id',$event->id_event)->first();
                
                $dataToPush = new stdClass;
                $dataToPush->event_id = $dataEvent->id;
                $dataToPush->name_event = $dataEvent->name;
                $dataToPush->number_event = $dataEvent->number;
                $dataToPush->event_required_personal = $dataEvent->required_personal;
                $dataToPush->event_personal_type = $dataEvent->personal_type;
                $dataToPush->event_personal_quantity= $dataEvent->personla_quantity;
                $dataToPush->event_date_initial = $dataEvent->date_initial;
                $dataToPush->event_date_final = $dataEvent->date_final;
                $dataToPush->event_hourly = $dataEvent->hourly;
                $dataToPush->event_place = $dataEvent->place;
                $dataToPush->event_total_budget = $dataEvent->total_budget;
                $dataToPush->event_daily_budget = $dataEvent->daily_budget;
                $dataToPush->event_qr_code = $dataEvent->qr_code;
                $dataToPush->event_state = $dataEvent->state;
                $dataToPush->id_event_user = $event->id;
                $dataToPush->status_event_user = $event->status;

                array_push($data,$dataToPush);
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
        $event = Events::where('name',$name_event)->get();
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
        $user_id = Auth::user()->id;
        $updateEventUsers = EventsUsers::findOrFail($id);
        $updateEventUsers->id_event = $request->id_event;
        $updateEventUsers->id_user = $user_id;
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
    public function destroy($id)
    {
        $eventUsers = EventsUsers::findOrFail($id);
        $eventUsers->delete();

        return response()->json('Postulación Eliminada');
    }
}
