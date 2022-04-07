<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

use App\Models\User;
use App\Models\UsersRoles;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

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

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function register(Request $request)
    {      
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
            return response()->json(['status' => 400,'statusText' => 'Hubo un error'], 400);
        }        
    }
}
