<?php

namespace App\Http\Controllers;

use App\Models\Services;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Services::all();
        return response()->json($services);
    }

    public function myServices()
    {
        $services = Services::query()
            ->where('user_id', auth()->id())
            ->get();
        return response()->json($services);
    }

    public function getServicesName()
    {
        $data = [];
        $services = Services::all();
        foreach ($services as $service) {
            array_push($data, [
                'name' => $service->name,
                'id_services' => $service->id
            ]);
        };

        return response()->json($data);
    }

    public function getMyServicesName()
    {
        $data = [];
        $services = Services::query()
            ->where('user_id', auth()->id())
            ->get();;
        foreach ($services as $service) {
            array_push($data, [
                'name' => $service->name,
                'id_services' => $service->id
            ]);
        };

        return response()->json($data);
    }

    public function saveImageB64(int $id_user, string $name, string $image_b64)
    {
        $img = $this->getB64Image($image_b64);
        // Obtener la extensión de la Imagen
        $img_extension = $this->getB64Extension($image_b64);
        // Crear un nombre aleatorio para la imagen
        $img_name = $id_user . '-' . $name . '.' . $img_extension;
        // Usando el Storage guardar en el disco creado anteriormente y pasandole a
        // la función "put" el nombre de la imagen y los datos de la imagen como
        // segundo parametro
        $imageSaved = Storage::disk('public')->put($img_name, $img);
        // $url = storage_path('app\images_base64/').$img_name;
        $url = Storage::disk('public')->url($img_name);
        return $url;
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
        // Obtener mediante una expresión regular la extensión imagen y guardarla
        // en la variable "img_extension"
        preg_match("/^data:image\/(.*);base64/i", $base64_image, $img_extension);
        // Dependiendo si se pide la extensión completa o no retornar el arreglo con
        // los datos de la extensión en la posición 0 - 1
        return $img_extension[1];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        try {
            $service = new Services;
            if ($request->image) {
                $profile = $request->image;
                $image = $this->saveImageB64($user_id, $request->name, $profile);
                $service->image = $image;
            } else {
                $service->image = 'null';
            }
            $service->name = $request->name;
            $service->description = $request->description;
            $service->price = $request->price;
            $service->user_id = $user_id;
            //            $service->payment_service = $request->payment_service;

            $service->save();

            return response()->json(['message' => 'Servicio Guardado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->errorInfo[2]], 400);
        }
    }

    public function show($name)
    {
        try {
            $service = Services::where('name', $name)->with('category')->get();
            return response()->json($service);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->errorInfo[2]], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Services $services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        try {
            $service = Services::findOrFail($id);
            if ($request->image !== $service->image) {
                if ($service->image !== null) {
                    File::delete($service->image);
                }
                $image = $this->saveImageB64($user_id, $request->name, $request->image);
                $service->image = $image;
            }
            $service->name = $request->name;
            $service->description = $request->description;
            $service->price = $request->price;
            $service->user_id = $user_id;
            //            $service->payment_service = $request->payment_service;

            $service->update();

            return response()->json(['message' => 'Servicio Actualizado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => "error"], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Services $services
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $service = Services::findOrFail($id);
            $service->delete();

            return response()->json(['message' => 'Servicio Eliminado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->errorInfo[2]], 400);
        }
    }
}
