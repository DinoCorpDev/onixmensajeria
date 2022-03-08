<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UsersRoles;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function register(Request $data)
    {     
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),            
            'last_name' => $data['last_name'],
            'artistic_name' => $data['artistic_name'],
            'date_birthday' => $data['date_birthday'],
            'gender' => $data['gender'],
            'height' => $data['height'],
            'shirt_size' => $data['shirt_size'],
            'pant_size' => $data['pant_size'],
            'shoes_size' => $data['shoes_size'],
            'hair_color' => $data['hair_color'],
            'eyes_color' => $data['eyes_color'],
            'weight' => $data['weight'],
            'attitudes' => $data['attitudes'],
            'technical_professional' => $data['technical_professional'],
            'events_participed' => $data['events_participed'],
            'description_professional_short' => $data['description_professional_short'],
            'description_professional_long' => $data['description_professional_long'],
            'phone' => $data['phone'],
            'id_number' => $data['id_number'],
            'address' => $data['address'],
            'city' => $data['city'],
            'instagram' => $data['instagram'],
            'facebook' => $data['facebook'],
            'twitter' => $data['twitter'],
            'snapchat' => $data['snapchat'],
            'youtube_url' => $data['youtube_url'],
            'spotify' => $data['spotify'],
            'deezer' => $data['deezer'],
            'autorization' => $data['autorization'] === 'true' ? true : false,
            'photographic_register' => $data['photographic_register'],
            'pictures' => $data['pictures'],
            'video' => $data['video'],
            'terms_conditions' => $data['terms_conditions'] === 'true' ? true : false,
        ]);

        $roles = json_decode($data['roles']);
        $roles_length = count($roles);

        for ($i=0; $i < $roles_length ; $i++) { 
            UsersRoles::create([
                'id_rol' => $roles[$i],
                'id_user' => $user->id,
            ]);   
        }        

        return 'User Created';
    }
}
