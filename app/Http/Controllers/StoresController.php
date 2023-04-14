<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Stores;
use App\Models\StoresCategories;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllStores()
    {
        $user = Auth::user();

        if ($user->id_rol === 1) {
            $stores = Stores::with('categories')->get();
        } else if ($user->id_rol === 2) {
            $stores = Stores::where('user_id', auth()->id())->with('categories')->get();
        } else if ($user->id_rol === 3) {
            $stores = Stores::where('driver_id', auth()->id())->with('categories')->get();
        }

        return response()->json($stores);
    }

    public function getDriversByStore($storeId)
    {
        $drivers = Stores::find($storeId)->drivers()->get();
        return response()->json($drivers);
    }

    public function index(Request $request)
    {
        $data = [];
        $filterParam = $request->search ? $request->search : '';
        $categoriesFilter = explode(' ', $filterParam);

        // remove forbidden words
        $forbiddenWords = ['de', 'la', 'y', 'con', 'para', 'un', 'el'];
        $categoriesFilter = array_diff($categoriesFilter, $forbiddenWords);

        foreach ($categoriesFilter as $key => $category) {
            $categories = Categories::where(
                'name',
                'LIKE',
                '%' . $category . '%'
            )
                ->with('Stores')
                ->get();
            foreach ($categories as $key => $categ) {
                $stores = $categ->stores;
                foreach ($stores as $key => $store) {
                    if ($store->state === 1 || $store->state === '1') {
                        array_push($data, $store);
                    }
                }
            }
        }

        $storesCleaned = array_filter($data, function ($obj) {
            static $idList = [];
            if (in_array($obj->id, $idList)) {
                return false;
            }
            $idList[] = $obj->id;
            return true;
        });

        return response()->json($storesCleaned);
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
        $image_service_str = substr(
            $base64_image,
            strpos($base64_image, ',') + 1
        );
        // Decodificar ese string y devolver los datos de la imagen
        $image = base64_decode($image_service_str);
        // Retornamos el string decodificado
        return $image;
    }

    public function getB64Extension($base64_image)
    {
        // Obtener mediante una expresión regular la extensión imagen y guardarla
        // en la variable "img_extension"
        preg_match(
            '/^data:image\/(.*);base64/i',
            $base64_image,
            $img_extension
        );
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
        $id_user = Auth::user()->id;
        $store = new Stores();

        if ($request->avatar !== null) {
            $avatar = $this->saveImageB64(
                $id_user,
                $request->name . '_avatar',
                $request->avatar
            );
            $store->avatar = $avatar;
        }

        $store->name = $request->name;
        $store->location = ucfirst($request->location);
        $store->user_id = $id_user;
        $store->driver_id = $request->driver_id;
        $store->payment_method = $request->payment_method;
        $store->phone = $request->phone;
        $store->save();

        $categories = $request->categories;

        foreach ($categories as $category) {
            StoresCategories::create([
                'stores_id' => $store->id,
                'categories_id' => $category,
            ]);
        }

        return response()->json($store);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Stores $stores
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Stores $stores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id_user = Auth::user()->id;
        $store = Stores::findOrFail($id);

        if ($request->avatar !== $store->avatar) {
            $avatar = $this->saveImageB64(
                $id_user,
                $request->name . '_avatar',
                $request->avatar
            );
            $store->avatar = $avatar;
        }

        $store->name = $request->name;
        $store->location = $request->location;
        $store->payment_method = $request->payment_method;
        $store->phone = $request->phone;
        $store->user_id = $id_user;
        $store->driver_id = $request->driver_id;
        $store->update();

        $store->categories()->sync($request->categories);

        return response()->json(['message' => 'Tienda Actualizado']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Stores $stores
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $store = Stores::findOrFail($id);
        $store->delete();
        return response()->json('Tienda eliminada correctamente');
    }
}
