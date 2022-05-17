<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\EventsUsers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $filterParam = $request->search ? $request->search : ''; 
        $dataToFilter=[];     
        $data=[];
        $id_events_users=[];  
        $user_id = Auth::user()->id;
        $eventsUsers = EventsUsers::where('id_user',$user_id)->with('events')->get();        
        /**
         * Validar mediante fecha
         */
        switch ($filterParam) {
            case 'open':
                $events = Events::where('status',$filterParam)->orderBy('id','DESC')->get();                
                foreach ($events as $key => $event) {
                    // if(isset($eventsUsers[$key]) && ){
                        $data[$key]=[
                            'id'=>$event->id,
                            'idItalentt' => $event->idItalentt,
                            'name'=>$event->name,
                            'banner'=>$event->banner,
                            'aboutPersonal'=>json_decode($event->typePersonal),
                            'initialDate'=>$event->initialDate,
                            'endDate'=>$event->endDate,
                            'hourly'=>json_decode($event->hourly),
                            'city'=>$event->city,
                            'location'=>$event->location,
                            'address'=>json_decode($event->address),
                            'totalBudget'=>$event->totalBudget,
                            'dailyBudget'=>$event->dailyBudget,
                            'status'=>$event->status,
                        ];
                    // }                    
                }
                break;
            case 'close':
                $events = Events::where('status',$filterParam)->orderBy('id','DESC')->get();
                foreach ($events as $key => $event) {
                    $data[$key]=[
                        'id'=>$event->id,
                        'idItalentt' => $event->idItalentt,
                        'name'=>$event->name,
                        'banner'=>$event->banner,
                        'aboutPersonal'=>json_decode($event->typePersonal),
                        'initialDate'=>$event->initialDate,
                        'endDate'=>$event->endDate,
                        'hourly'=>json_decode($event->hourly),
                        'city'=>$event->city,
                        'location'=>$event->location,
                        'address'=>json_decode($event->address),
                        'totalBudget'=>$event->totalBudget,
                        'dailyBudget'=>$event->dailyBudget,
                        'status'=>$event->status,
                    ];
                }
                break;
            case 'accept':
                $user_id = Auth::user()->id;
                $eventsUsers = EventsUsers::where('id_user',$user_id)->where('status',$filterParam)->with('events')->get();        

                foreach ($eventsUsers as $key => $eventsUser) {
                    $data[$key]=[                
                        "id"=>$eventsUser->events->id,
                        "idItalentt"=>$eventsUser->events->idItalentt,
                        "name"=>$eventsUser->events->name,
                        "banner"=>$eventsUser->events->banner,
                        "aboutPersonal"=>json_decode($eventsUser->events->typePersonal),
                        "initialDate"=>$eventsUser->events->initialDate,
                        "endDate"=>$eventsUser->events->endDate,
                        "hourly"=>json_decode($eventsUser->events->hourly),
                        "city"=>$eventsUser->events->city,
                        "location"=>$eventsUser->events->location,
                        "address"=>json_decode($eventsUser->events->address),
                        "totalBudget"=>$eventsUser->events->totalBudget,
                        "dailyBudget"=>$eventsUser->events->dailyBudget,
                        "status"=>$eventsUser->events->status
                    ];
                }
                break;
            
            case 'skip':
                $user_id = Auth::user()->id;
                $eventsUsers = EventsUsers::where('id_user',$user_id)->where('status',$filterParam)->with('events')->get();        

                foreach ($eventsUsers as $key => $eventsUser) {
                    $data[$key]=[                
                        "id"=>$eventsUser->events->id,
                        "idItalentt"=>$eventsUser->events->idItalentt,
                        "name"=>$eventsUser->events->name,
                        "banner"=>$eventsUser->events->banner,
                        "aboutPersonal"=>json_decode($eventsUser->events->typePersonal),
                        "initialDate"=>$eventsUser->events->initialDate,
                        "endDate"=>$eventsUser->events->endDate,
                        "hourly"=>json_decode($eventsUser->events->hourly),
                        "city"=>$eventsUser->events->city,
                        "location"=>$eventsUser->events->location,
                        "address"=>json_decode($eventsUser->events->address),
                        "totalBudget"=>$eventsUser->events->totalBudget,
                        "dailyBudget"=>$eventsUser->events->dailyBudget,
                        "status"=>$eventsUser->events->status
                    ];
                }
                break;
            
                case 'reject':
                    $user_id = Auth::user()->id;
                    $eventsUsers = EventsUsers::where('id_user',$user_id)->where('status',$filterParam)->with('events')->get();        
    
                    foreach ($eventsUsers as $key => $eventsUser) {
                        $data[$key]=[                
                            "id"=>$eventsUser->events->id,
                            "idItalentt"=>$eventsUser->events->idItalentt,
                            "name"=>$eventsUser->events->name,
                            "banner"=>$eventsUser->events->banner,
                            "aboutPersonal"=>json_decode($eventsUser->events->typePersonal),
                            "initialDate"=>$eventsUser->events->initialDate,
                            "endDate"=>$eventsUser->events->endDate,
                            "hourly"=>json_decode($eventsUser->events->hourly),
                            "city"=>$eventsUser->events->city,
                            "location"=>$eventsUser->events->location,
                            "address"=>json_decode($eventsUser->events->address),
                            "totalBudget"=>$eventsUser->events->totalBudget,
                            "dailyBudget"=>$eventsUser->events->dailyBudget,
                            "status"=>$eventsUser->events->status
                        ];
                    }
                    break;
            default:
                # code...
                break;
        }        
        return response()->json($data);
    }

    public function saveImageB64(String $idItalentt, String $nameEvent, String $image_b64){        
        $img = $this->getB64Image($image_b64);        
            // Obtener la extensión de la Imagen
        $img_extension = $this->getB64Extension($image_b64);
            // Crear un nombre aleatorio para la imagen
        $img_name = $idItalentt.'-'.$nameEvent.'.'.$img_extension;
            // Usando el Storage guardar en el disco creado anteriormente y pasandole a 
            // la función "put" el nombre de la imagen y los datos de la imagen como 
            // segundo parametro
        $imageSaved = Storage::disk('public')->put($img_name, $img);
        $url = Storage::disk('public')->url($img_name);
        return $url;
    }

    public function getB64Image($base64_image){  
        // Obtener el String base-64 de los datos         
        $image_service_str = substr($base64_image, strpos($base64_image, ",")+1);
        // Decodificar ese string y devolver los datos de la imagen        
        $image = base64_decode($image_service_str);   
        // Retornamos el string decodificado
        return $image; 
   }

    public function getB64Extension($base64_image){  
        // Obtener mediante una expresión regular la extensión imagen y guardarla
        // en la variable "img_extension"        
        preg_match("/^data:image\/(.*);base64/i",$base64_image, $img_extension);   
        // Dependiendo si se pide la extensión completa o no retornar el arreglo con
        // los datos de la extensión en la posición 0 - 1        
        return $img_extension[1];  
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
            $newEvent = new Events();

            $newEvent->idItalentt = $request->idItalentt;
            $newEvent->name = $request->name;
            $newEvent->banner = $request->banner;
            $newEvent->typePersonal = json_encode($request->aboutPersonal);
            $newEvent->initialDate = $request->initialDate;
            $newEvent->endDate = $request->endDate;
            $newEvent->hourly = json_encode($request->hourly);
            $newEvent->city = $request->city;
            $newEvent->location = $request->location;
            $newEvent->address = json_encode($request->address);
            $newEvent->totalBudget = $request->totalBudget;
            $newEvent->dailyBudget = $request->dailyBudget;
            
            $newEvent->save();

            return response()->json(['status' => 200,'statusText' => 'Evento Guardado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 400,'statusText' => $th], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function show($idItalentt)
    {        
        $event = Events::where('idItalentt',$idItalentt)->first();
        $data=[
            'id'=>$event->id,
            'idItalentt' => $event->idItalentt,
            'name'=>$event->name,
            'banner'=>$event->banner,
            'aboutPersonal'=>json_decode($event->typePersonal),
            'initialDate'=>$event->initialDate,
            'endDate'=>$event->endDate,
            'hourly'=>json_decode($event->hourly),
            'city'=>$event->city,
            'location'=>$event->location,
            'address'=>json_decode($event->address),
            'totalBudget'=>$event->totalBudget,
            'dailyBudget'=>$event->dailyBudget,
            'status'=>$event->status,
        ];

        return response()->json($data);
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
            
            $newEvent->banner = $request->banner;            
            $newEvent->idItalentt = $request->idItalentt;
            $newEvent->name = $request->name;            
            $newEvent->typePersonal = json_encode($request->aboutPersonal);
            $newEvent->initialDate = $request->initialDate;
            $newEvent->endDate = $request->endDate;
            $newEvent->hourly = json_encode($request->hourly);
            $newEvent->city = $request->city;
            $newEvent->location = $request->location;
            $newEvent->address = json_encode($request->address);
            $newEvent->totalBudget = $request->totalBudget;
            $newEvent->dailyBudget = $request->dailyBudget;
            
            $newEvent->save();

            return response()->json(['status' => 200,'statusText' => 'Evento Actualizado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 400,'statusText' => $th], 200);
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
        return response()->json(['status' => 200,'statusText' => 'Evento Eliminado'], 200);
    }
}
