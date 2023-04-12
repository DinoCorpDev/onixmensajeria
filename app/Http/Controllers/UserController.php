<?php

namespace App\Http\Controllers;

use App\Helpers\Uploader;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Mail;
use App\Mail\NotifyMail;
use Illuminate\Routing\Route;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->dni = $user->dni ? Storage::url($user->dni) : null;
            $user->doc_responsable = $user->doc_responsable ? Storage::url($user->doc_responsable) : null;
        }

        return response()->json($users);
    }

    public function drivers()
    {
        $drivers = User::where('id_rol', 4)->get();
        return response()->json($drivers);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json($token);
    }

    public function authenticateMovil(Request $request)
    {
        $credentials = $request->only('phone', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }


        return response()->json($token);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'names' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'names' => $request->get('names'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function registerMovil(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'names' => 'required|string|max:255',
            'phone' => 'required|string|max:10',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'names' => $request->get('names'),
            'phone' => $request->get('phone'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function createUserInAdmin(Request $request)
    {
        $user = User::create([
            'names' => $request->get('names'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'password' => Hash::make($request->get('password')),
            'id_rol' => $request->get('id_rol'),
        ]);

        if ($request->get('dni') && $request->get('doc_responsable')) {
            $dni = $this->saveImageB64($user->id, 'dni', $request->get('dni'), 'dnis');
            $doc_responsable = $this->saveImageB64($user->id, 'doc_responsable', $request->get('doc_responsable'), 'ids');

            $user->dni = $dni;
            $user->doc_responsable = $doc_responsable;
            $user->save();
        }

        return response()->json('Usuario Creado');
    }

    public function createProvider(Request $request)
    {
        if ($request->hasFile('dni')) {
            $dni = Uploader::uploadFile('dni', 'dnis');
        }
        if ($request->hasFile('doc_responsable')) {
            $docId = Uploader::uploadFile('doc_responsable', 'ids');
        }

        User::create([
            'names' => $request->get('names'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'id_rol' => 2,
            'dni' => "dnis/" . $dni,
            'doc_responsable' => "ids/" . $docId,
            'is_adult' => $request->get('is_adult') ? 1 : 0,
            'policy_privacy' => $request->get('policy_privacy') ? 1 : 0,
        ]);

        return response()->json('Usuario Creado');
    }

    public function updateUserInAdmin(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $dni = $user->dni;
        $doc_responsable = $user->doc_responsable;

        if ($request->id_rol === 2) {

            if ($user->dni != $request->dni) {
                $dni = $this->saveImageB64($user->id, 'dni', $request->get('dni'), 'dnis');
            }

            if ($user->doc_responsable != $request->doc_responsable) {
                $doc_responsable = $this->saveImageB64($user->id, 'doc_responsable', $request->doc_responsable, 'ids');
            }

            $user->names = $request->names;
            $user->id_rol = $request->id_rol;
            $user->email = $request->email;
            $user->dni = $dni;
            $user->doc_responsable = $doc_responsable;
            $user->update();
        } else {
            $user->names = $request->names;
            $user->id_rol = $request->id_rol;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->update();
        }

        return response()->json('Usuario Actualizado');
    }

    public function refresh(Request $request)
    {
        $new_token = JWTAuth::refresh($request->token);
        return response()->json(['token' => $new_token], 200);
    }

    public function getProfile()
    {
        $user = Auth::user();
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->names = $request->names;
        $user->update();

        return response()->json('Nombres Actualizados');
    }

    public function sendPassword(Request $request)
    {
        $dataUser = User::where('email', $request->email)->first();
        if ($dataUser) {
            $caracteres = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-#!';
            $password = null;

            $aleatoria = substr(str_shuffle($caracteres), 0, 10);
            $password = $aleatoria;

            $data = [
                $request->email,
                $password,
            ];
            try {
                $changeP = User::where('email', $request->email)->first();
                $changeP->password = Hash::make($password);
                $changeP->provisionalPassword = true;
                $changeP->save();

                Mail::to($request->email)->send(new NotifyMail($data));

                return response()->json(['status' => 200, 'statusMessage' => 'Correo con nueva contraseña enviada']);
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json(['status' => 400, 'statusMessage' => 'Intenta de Nuevo mas Tarde']);
            }
        } else {
            return response()->json(['status' => 400, 'statusMessage' => 'El correo No Existe']);
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $user = Auth::user();
            $changeP = User::where('email', $user->email)->first();
            $changeP->password = Hash::make($request->get('password'));
            $changeP->provisionalPassword = false;
            $changeP->save();

            return response()->json(['status' => 200, 'statusMessage' => 'Contraseña Actualizada']);
        } catch (\Throwable $th) {

            return response()->json(['status' => 400, 'statusMessage' => 'Verifica La Información']);
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json('Usuario eliminado correctamente');
    }

    public function logout()
    {
        Auth::logout();
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json('Sesión Cerrada');
    }

    public function saveImageB64(int $id_user, string $name, string $image_b64, string $folder)
    {
        $img = $this->getB64Image($image_b64);
        $img_extension = $this->getB64Extension($image_b64);
        $img_name = $id_user . '-' . $name . '.' . $img_extension;
        $img_path = $folder . '/' . $img_name;
        Storage::disk('public')->put($img_path, $img);
        return $img_path;
    }

    public function getB64Image($base64_image)
    {
        // Obtener el String base-64 de los datos
        $image_service_str = substr($base64_image, strpos($base64_image, ",") + 1);
        // Decodificar ese string y devolver los datos de la imagen
        $image = base64_decode($image_service_str);
        // Retornamos el string decodificado
        return $image;
    }

    public function getB64Extension($base64_image)
    {
        $extensions = [
            "/^data:image\/(.*);base64/i", "/^data:application\/(pdf);base64/i"
        ];

        foreach ($extensions as $key => $extension) {
            // Obtener mediante una expresión regular la extensión imagen y guardarla
            // en la variable "img_extension"
            $result = preg_match($extension, $base64_image, $img_extension);

            // Dependiendo si se pide la extensión completa o no retornar el arreglo con
            // los datos de la extensión en la posición 0 - 1
            if ($result == 1) {
                return $img_extension[1];
            }
        }
    }
}
