<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UsersRoles;
use Auth;

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

    public function updateUser(Request $request, $id){        
        try {            
            $user = User::findOrFail($id);            
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

            $user->profile = $request->profile;
            $user->photos = $request->photos;
            $user->video = $request->video;        
            
            $user->autorization = $request->autorization;
            $user->terms_conditions = $request->terms_conditions;
            $user->rol = json_encode($request->rol);
            $user->update();
            return response()->json(['status' => 200,'statusText' => 'Usuario Actualizado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 400,'statusText' => $th], 200);
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
