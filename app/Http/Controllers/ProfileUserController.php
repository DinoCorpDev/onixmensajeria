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
use SimpleXMLElement;
use Excel;
use App\Imports\UserImport;

class ProfileUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyUser(){
        $user = Auth::user();
        if($user) {
            return response()->json(['data'=>$user],200);
        }else{
            return response()->json(['status'=>500, 'statusText'=>'Sin Usuario'],500);
        }
    }

    public function getAllUsers(){
        try {
            $data=[];
            $users = User::orderBy('id','DESC')->paginate(20);
            foreach ($users as $key => $users) {
                $dataToPush=[
                    "id"=>$users->id,
                    "name" => $users->name,
                    "lastname" => $users->lastname,
                    "contact" => json_decode($users->contact),
                    "email" => $users->email,
                    "nickname" => $users->nickname,
                    "birthday" => $users->birthday,
                    "gender" => $users->gender,
                    "physical" =>json_decode($users->pyshical),
                    "competences" =>json_decode($users->competences),
                    "education" =>json_decode($users->education),
                    "experience" =>json_decode($users->experience),
                    "identification" => $users->identification,
                    "address" => $users->address,
                    "city" => $users->city,

                    "profile" => $users->profile,
                    "photos" => $users->photos,
                    "video" =>$users->video,

                    "autorization" => $users->autorization === "1" ? true : false,
                    "terms_conditions" =>$users->terms_conditions === "1" ? true : false,
                    "roles" =>json_decode($users->roles),
                    "provisionalPassword" => $users->provisionalPassword === 1 ? true : false,
                    "firstLogin" =>$users->firstLogin === "1" ? true : false,
                    "verified" =>$users->verified === "1" ? true : false,
                ];
                array_push($data, $dataToPush);
            }
            return response()->json(['data'=>$data],200);
        } catch (\Throwable $th) {
            return response()->json(['status'=>500, 'statusText'=>throw $th],500);
        }
    }
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
                "gender" => json_decode($user->gender),
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

                "autorization" => $user->autorization === "1" ? true : false,
                "terms_conditions" =>$user->terms_conditions === "1" ? true : false,
                "roles" =>json_decode($user->roles),
                "provisionalPassword" => $user->provisionalPassword === "1" ? true : false,
                "firstLogin" =>$user->firstLogin === "1" ? true : false,
                "verified" =>$user->verified === "1" ? true : false,
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
    public function show($searchParam)
    {
        try {
            $data=[];
            $users = User::where('name','LIKE','%'.$searchParam.'%')->orWhere('lastname','LIKE','%'.$searchParam.'%')->orWhere('email','LIKE','%'.$searchParam.'%')->get();
            foreach ($users as $key => $users) {
                $dataToPush=[
                    "id"=>$users->id,
                    "name" => $users->name,
                    "lastname" => $users->lastname,
                    "contact" => json_decode($users->contact),
                    "email" => $users->email,
                    "nickname" => $users->nickname,
                    "birthday" => $users->birthday,
                    "gender" => $users->gender,
                    "physical" =>json_decode($users->pyshical),
                    "competences" =>json_decode($users->competences),
                    "education" =>json_decode($users->education),
                    "experience" =>json_decode($users->experience),
                    "identification" => $users->identification,
                    "address" => $users->address,
                    "city" => $users->city,

                    "profile" => $users->profile,
                    "photos" => $users->photos,
                    "video" =>$users->video,

                    "autorization" => $users->autorization === "1" ? true : false,
                    "terms_conditions" =>$users->terms_conditions === "1" ? true : false,
                    "roles" =>json_decode($users->roles),
                    "provisionalPassword" => $users->provisionalPassword === 1 ? true : false,
                    "firstLogin" =>$users->firstLogin === "1" ? true : false,
                    "verified" =>$users->verified === "1" ? true : false,
                ];
                array_push($data, $dataToPush);
            }
            return response()->json(['data'=>$data],200);
        } catch (\Throwable $th) {
            return response()->json(['status'=>500, 'statusText'=>throw $th],500);
        }
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

    public function updateUserInAdmin(Request $request, $id){
        try {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->contact = json_encode($request->contact);
            $user->nickname = $request->nickname;
            $user->address = $request->address;
            $user->city = $request->city;
            $user->country = $request->country;
            $user->save();
            return response()->json(['status' => 200,'statusText' => 'Usuario Actualizado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 400,'statusText' =>$th], 400);
        }
    }

    public function adminRegisterUser(Request $request){
        try {
            $user = User::create([
                "name" => $request->name,
                "lastname" => $request->lastname,
                "contact" => json_encode($request->contact),
                "email" => $request->email,
                "password" => Hash::make($request->password),

                "autorization" => $request->autorization,
                "terms_conditions" =>$request->terms_conditions,
            ]);

            return response()->json(['status' => 200,'statusText' => 'Usuario Creado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 400,'statusText' =>$th], 400);
        }
    }

    public function updateUser(Request $request, $id){
        try {
            $user = User::findOrFail($id);
            $photosToSave=[];
            $videosToSave=[];

            $user->profile = $request->profile;


            if($request->video){
                $user->video = $request->video;
            }

            if($request->photos){
                $photosDelete = json_decode($user->photos);

                if($request->photos){
                    $photos = $request->photos;
                    $arrPhotos = [];
                    foreach ($photos as $key => $photo) {
                        array_push($arrPhotos, $photo);
                    }
                    $user->photos = $arrPhotos;
                }
            }

            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->contact = json_encode($request->contact);
            $user->nickname = $request->nickname;
            $user->birthday = $request->birthday;
            $user->gender = $request->gender;
            $user->pyshical = json_encode($request->physical);
            $user->competences = json_encode($request->competences);
            $user->education = json_encode($request->education);
            $user->experience = json_encode($request->experience);
            $user->identification = $request->identification;
            $user->address = $request->address;
            $user->city = $request->city;
            $user->roles = json_encode($request->roles);
            $user->update();

            $dataToPush=[
                "id"=>$user->id,
                "name" => $user->name,
                "lastname" => $user->lastname,
                "contact" => json_decode($user->contact),
                "email" => $user->email,
                "nickname" => $user->nickname,
                "birthday" => $user->birthday,
                "gender" => $user->gender,
                "pyshical" =>json_decode($user->pyshical),
                "competences" =>json_decode($user->competences),
                "education" =>json_decode($user->education),
                "experience" =>json_decode($user->experience),
                "identification" => $user->identification,
                "address" => $user->address,
                "city" => $user->city,

                "profile" => $user->profile,
                "photos" => $user->photos,
                "video" =>$user->video,

                "autorization" => $user->autorization === "1" ? true : false,
                "terms_conditions" =>$user->terms_conditions === "1" ? true : false,
                "roles" =>json_decode($user->roles),
                "provisionalPassword" => $user->provisionalPassword === 1 ? true : false,
                "firstLogin" =>$user->firstLogin === "1" ? true : false,
                "verified" =>$user->verified === "1" ? true : false,
            ];

            return response()->json(['status' => 200,'data' => $dataToPush], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 400,'statusText' =>[$th]], 400);
        }
    }

    public function updateFirstLogin(Request $request, $id){
        $user = User::findOrFail($id);
        $user->firstLogin = $request->firstLogin;
        $user->update();

        return response()->json(['status' => 200,'statusText' => 'Campo Actualizado'], 200);
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
                return response()->json(['status'=>400,'statusMessage'=>$th]);
            }
        }else{
            return response()->json(['status'=>400,'statusMessage'=>'El correo No Existe']);
        }
    }

    public function updatePassword(Request $request){
        try {
            $user_email = $request->email;
            $changeP = User::where('email',$user_email)->first();
            $changeP->password = Hash::make($request->password);
            $changeP->provisionalPassword = false;
            $changeP->save();

            return response()->json(['status'=>200,'statusText'=>'Contraseña Actualizada'],200);
        } catch (\Throwable $th) {
            return response()->json(['status'=>400,'statusText'=>$th],400);
        }
    }

    public function disableUser(Request $request, $id){
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['status' => 200,'statusText' => 'Usuario Desabilitado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 400,'statusText' => $th], 400);
        }
    }

    public function importUsersCSV(Request $request){
        set_time_limit(0);
        try {
            if($request->hasFile('file')){
                $file = $request->file('file')->getRealPath();
                $data = Excel::import(new UserImport, $file);
            }
            return response()->json(['status' => 200,'statusText' => 'Usuarios Importados por Completo'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 400,'statusText' => $th], 400);
        }
    }
}
