<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UsersRoles;
use Auth;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Mail\NotifyMail;

class ProfileUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user_id = Auth::user()->id;
            $user = User::findOrFail($user_id);

            $data=[
                "id"=>$user->id,
                "name" => $user->name,
                "lastname" => $user->lastname,
                "contact" => json_decode($user->contact),
                "email" => $user->email,
                "nickname" => $user->nickname,
                "birthday" => $user->birthday,
                "gender" => $user->gender,            
                "sectors" =>json_decode($user->sectors),
                "aptitud" =>json_decode($user->aptitud),
                "pyshical" =>json_decode($user->pyshical),
                "competences" =>json_decode($user->competences),
                "education" =>json_decode($user->education),
                "experience" =>json_decode($user->experience),
                "identification" => $user->identification,
                "address" => $user->address,
                "city" => $user->city,
                
                "profile" => $user->profile,
                "photos" => json_decode($user->photos),
                "video" =>$user->video,
                    
                "autorization" => $user->autorization,
                "terms_conditions" =>$user->terms_conditions,
                "rol" =>json_decode($user->rol)
            ];
            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->errorInfo[2]],400);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    public function saveImageB64(String $email, String $type, String $image_b64){        
        $img = $this->getB64Image($image_b64);        
            // Obtener la extensión de la Imagen
        $img_extension = $this->getB64Extension($image_b64);
            // Crear un nombre aleatorio para la imagen
        $img_name = $email.'-'.$type.'.'.$img_extension;
            // Usando el Storage guardar en el disco creado anteriormente y pasandole a 
            // la función "put" el nombre de la imagen y los datos de la imagen como 
            // segundo parametro
        $imageSaved = Storage::disk('images_base64')->put($img_name, $img);
        $url = storage_path('app\images_base64/').$img_name;       
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

    public function updateUser(Request $request, $id){                
        try {  
            $user = User::findOrFail($id);    
            if($request->profile){     
                if($user->profile){
                    File::delete($user->profile);
                }
                $profile = $this->saveImageB64($user->email,'profile',$request->profile);                
                $user->profile = $profile;
            }

            if($request->video){
                if($user->video){                    
                    File::delete($user->video);
                }                
                $videoUploaded = $this->saveImageB64($user->email,'video',$request->video);
                $user->video = $videoUploaded;
            }

            $photosDelete = json_decode($user->photos);            
            if($photosDelete){                
                foreach ($photosDelete as $key => $photo) {
                    File::delete($photo);
                }
            }          

            if($request->photos){                  
                $photos = $request->photos;
                $arrPhotos = [];
                foreach ($photos as $key => $photo) {                              
                    $picture = $this->saveImageB64($user->email,'photos'.$key,$photo[$key]);
                    array_push($arrPhotos, $picture);
                }
                $user->photos = $arrPhotos;
            }            
            
            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->contact = json_encode($request->contact);        
            $user->nickname = $request->nickname;
            $user->birthday = $request->birthday;
            $user->gender = $request->gender;            
            $user->sectors = json_encode($request->sectors);
            $user->aptitud = json_encode($request->aptitud);
            $user->pyshical = json_encode($request->pyshical);
            $user->competences = json_encode($request->competences);
            $user->education = json_encode($request->education);
            $user->experience = json_encode($request->experience);
            $user->identification = $request->identification;
            $user->address = $request->address;
            $user->city = $request->city;                    
                    
            $user->rol = json_encode($request->rol);
            $user->update();
            return response()->json(['status' => 200,'statusText' => 'Usuario Actualizado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 400,'statusText' => throw $th], 200);
        }        
    }

    public function sendPassword(Request $request){
        $dataUser = User::where('email',$request->email)->first();
        if($dataUser){        
            $caracteres = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-#!';
            $password = null;
            
            $aleatoria = substr(str_shuffle($caracteres), 0, 10);
            $password = $aleatoria;        
        
            $data=[
                $request->email,
                $password,
            ];
            try {
                $changeP = User::where('email',$request->email)->first();
                $changeP->password = Hash::make($password);
                $changeP->provisionalPassword = true;
                $changeP->save();

                Mail::to($request->email)->send(new NotifyMail($data));

                return response()->json(['status'=>200,'statusMessage'=>'Correo con nueva contraseña enviada']);
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json(['status'=>400,'statusMessage'=>throw $th]);
            }
        }else{
            return response()->json(['status'=>400,'statusMessage'=>'El correo No Existe']);
        }        
    }

    public function updatePassword(Request $request){        
        try {            
            $user = Auth::user();
            $changeP = User::where('email',$user->email)->first();            
            $changeP->password = Hash::make($request->get('password'));            
            $changeP->provisionalPassword = false;
            $changeP->save();
            
            return response()->json(['status'=>200,'statusMessage'=>'Contraseña Actualizada']);
        } catch (\Throwable $th) {
            
            return response()->json(['status'=>400,'statusMessage'=>'Verifica La Información']);
        }
    }

    public function disableUser(Request $request, $id){
        try {
            $user = User::findOrFail($id);
            $user->delete();
            
            return response()->json(['status' => 200,'statusText' => 'Usuario Desabilitado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 400,'statusText' => $th], 200);
        }        
    }
}
