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

    public function saveImageB64(String $idItalentt, String $nameEvent, String $image_b64){        
        $img = $this->getB64Image($image_b64);        
            // Obtener la extensión de la Imagen
        $img_extension = $this->getB64Extension($image_b64);
            // Crear un nombre aleatorio para la imagen
        $img_name = $idItalentt.'-'.$nameEvent.'.'.$img_extension;
            // Usando el Storage guardar en el disco creado anteriormente y pasandole a 
            // la función "put" el nombre de la imagen y los datos de la imagen como 
            // segundo parametro
        $imageSaved = Storage::disk('images_events')->put($img_name, $img);
        $url = storage_path('app\images_events/').$img_name;       
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
            $banner = $this->$this->saveImageB64($request->idItalentt,$request->name,$request->banner);
            $newEvent = new Events();

            $newEvent->idItalentt = $request->idItalentt;
            $newEvent->name = $request->name;
            $newEvent->banner = $banner;
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
