<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UsersRoles;

class ProfileUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        $user = User::findOrFail($id)->first();
        return response()->json($user);
    }

    public function updateUser(Request $request, $id){
        $user = User::findOrFail($id);
        $user->name = $request->name;        
        $user->last_name = $request->last_name;
        $user->artistic_name = $request->artistic_name;
        $user->date_birthday = $request->date_birthday;
        $user->gender = $request->gender;
        $user->height = $request->height;
        $user->shirt_size = $request->shirt_size;
        $user->pant_size = $request->pant_size;
        $user->shoes_size = $request->shoes_size;
        $user->hair_color = $request->hair_color;
        $user->eyes_color = $request->eyes_color;
        $user->weight = $request->weight;
        $user->attitudes = $request->attitudes;
        $user->technical_professional = $request->technical_professional;
        $user->events_participed = $request->events_participed;
        $user->description_professional_short = $request->description_professional_short;
        $user->description_professional_long = $request->description_professional_long;
        $user->phone = $request->phone;
        $user->id_number = $request->id_number;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->instagram = $request->instagram;
        $user->facebook = $request->facebook;
        $user->twitter = $request->twitter;
        $user->snapchat = $request->snapchat;
        $user->youtube_url = $request->youtube_url;
        $user->spotify = $request->spotify;
        $user->deezer = $request->deezer;
        $user->autorization = $request->autorization === 'true' ? true : false;
        $user->photographic_register = $request->photographic_register;
        $user->pictures = $request->pictures;
        $user->video = $request->video;
        $user->terms_conditions = $request->terms_conditions  === 'true' ? true : false;
        $user->save();

        return response()->json('User Updated');
    }

    public function disableUser(Request $request, $id){
        $user = User::where('id',$id)->first();
        $user->state = $request->state;
        $user->save();

        return response()->json('User Updated');
    }
}
