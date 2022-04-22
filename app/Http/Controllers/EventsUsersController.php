<?php

namespace App\Http\Controllers;

use App\Models\EventsUsers;
use App\Models\Events;
use App\Models\Users;
use Illuminate\Http\Request;
use Auth;
use DB;

class EventsUsersController extends Controller
{
    public function getPostulations(){
        $data = [];
        $postulations = DB::select('call getAllPostulations()');
        foreach ($postulations as $key => $postulation) {
            $data[$key] = [
                'address'=>json_decode($postulation->address),
                'city'=>$postulation->city,
                'dailyBudget'=>$postulation->dailyBudget,
                'event_end_date'=>$postulation->event_end_date,
                'event_initial_date'=>$postulation->event_initial_date,
                'event_name'=>$postulation->event_name,
                'hourly'=>json_decode($postulation->hourly),
                'id'=>$postulation->id,
                'idTalent'=>$postulation->idTalent,
                'location'=>$postulation->location,
                'status'=>$postulation->status,
                'totalBudget'=>$postulation->totalBudget,
                'total_assistants'=>$postulation->total_assistants,
                'typePersonal'=>$postulation->typePersonal,
            ];
        }
        return response()->json($data);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=[];
        $user_id = Auth::user()->id;        
        
        $eventsUsers = EventsUsers::where('id_user',$user_id)->with('events')->get();        

        foreach ($eventsUsers as $key => $eventsUser) {
            $data[$key]=[
                "id"=>$eventsUser->id,
                "idTalent"=>$eventsUser->idTalent,
                "status"=>$eventsUser->status,
                "id_event"=>$eventsUser->id_event,
                "id_user"=>$eventsUser->id_user,
                "events"=>[
                    "id"=>$eventsUser->events->id,
                    "idItalentt"=>$eventsUser->events->idItalentt,
                    "name"=>$eventsUser->events->name,
                    "banner"=>$eventsUser->events->banner,
                    "aboutPersonal"=>json_decode($eventsUser->events->typePersonal),
                    "initialDate"=>$eventsUser->events->initialDate,
                    "endDate"=>$eventsUser->events->endDate,
                    "houry"=>json_decode($eventsUser->events->houry),
                    "city"=>$eventsUser->events->city,
                    "location"=>$eventsUser->events->location,
                    "address"=>json_decode($eventsUser->events->address),
                    "totalBudget"=>$eventsUser->events->totalBudget,
                    "dailyBudget"=>$eventsUser->events->dailyBudget,
                    "status"=>$eventsUser->events->status
                ]
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
        try {
            $user_id = Auth::user()->id;
            $eventUsers = new EventsUsers();
            $eventUsers->idTalent = $request->idTalent;
            $eventUsers->id_event = $request->id_event;
            $eventUsers->id_user = $user_id;
            $eventUsers->status = $request->status;
            $eventUsers->save();
            return response()->json(['message'=>'Registro Creado'],200);

        } catch (\Throwable $th) {            
            return response()->json(['message' => $th->errorInfo[2]],400);
        }        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventsUsers  $eventsUsers
     * @return \Illuminate\Http\Response
     */
    public function show($name_event)
    {

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
        try {
            $updateEventUsers = EventsUsers::findOrFail($id);
            $updateEventUsers->idTalent = $request->idTalent;
            $updateEventUsers->id_event = $request->id_event;
            $updateEventUsers->id_user = $user_id;
            $updateEventUsers->status = $request->status;
            $updateEventUsers->save();
            return response()->json(['message'=>'Registro Actualizado'],200);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->errorInfo[2]],400);
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventsUsers  $eventsUsers
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $eventUsers = EventsUsers::findOrFail($id);
            $eventUsers->delete();
            return response()->json('Postulación Eliminada');
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->errorInfo[2]],400);
        }        
    }
}
