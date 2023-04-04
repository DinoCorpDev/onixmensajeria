<?php

namespace App\Http\Controllers;

use App\Models\Stores;
use App\Models\Categories;
use App\Models\StoresCategories;
use App\Models\ServicesStores;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllStores()
    {
        $stores = Stores::with('services')
            ->with('categories')
            ->get();
        return response()->json($stores);
    }

    public function getMyStores()
    {
        $stores = Stores::where('user_id', auth()->id())
            ->with('services')
            ->with('categories')
            ->get();
        return response()->json($stores);
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

        if ($request->image !== null) {
            $image = $this->saveImageB64(
                $id_user,
                $request->name . '_banner',
                $request->image
            );
            $store->image = $image;
        }

        $store->name = $request->name;
        $store->description = $request->description;
        $store->location = ucfirst($request->location);
        $store->schedule = $request->schedule;
        $store->user_id = $id_user;
        $store->payment_method = $request->payment_method;
        $store->phone = $request->phone;
        $store->save();
        $categories = $request->categories;
        $services = $request->services;

        //        $storeData = Stores::query()
        //            ->where('user_id', auth()->id())
        //            ->latest('id')
        //            ->first();

        //        foreach ($services as $key => $service) {
        //
        //            $id = "";
        //
        //            if (isset($service['id'])) {
        //                $id = $service['id'];
        //            }
        //
        //            if (isset($service['id_services'])) {
        //                $id = $service['id_services'];
        //            }
        //
        //
        //            ServicesStores::create([
        //                'stores_id' => $store->id,
        //                'services_id' => $id,
        //            ]);
        //        }

        foreach ($services as $service) {
            // dd($service);
            //
            //            $id = "";
            //
            //            if (isset($service['id'])) {
            //                $id = $service['id'];
            //            }
            //
            //            if (isset($service['id_services'])) {
            //                $id = $service['id_services'];
            //            }

            ServicesStores::create([
                'stores_id' => $store->id,
                'services_id' => $service,
            ]);
        }

        //
        //        foreach ($categories as $key => $category) {
        //            StoresCategories::create([
        //                'stores_id' => $store->id,
        //                'categories_id' => $category['id_category'],
        //            ]);
        //        }

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
        $services_stores = Stores::where('id', $id)
            ->with('services')
            ->get();
        return response()->json($services_stores);
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

        if ($request->image !== $store->image) {
            $image = $this->saveImageB64(
                $id_user,
                $request->name . '_banner',
                $request->image
            );
            $store->image = $image;
        }

        $store->name = $request->name;
        $store->description = $request->description;
        $store->location = $request->location;
        $store->schedule = $request->schedule;
        $store->payment_method = $request->payment_method;
        $store->phone = $request->phone;
        $store->user_id = $id_user;
        $store->update();

        $store->categories()->sync($request->categories);

        /**
         * Recordar que si se desea guardar una categoria mas,
         * se debe enviar la nueva categoria en el metodo put
         */

        //        $categories = $request->categories;
        //        if ($categories) {
        //            foreach ($categories as $key => $category) {
        //                $storeCaregories = StoresCategories::where('stores_id', $id)->where('categories_id',
        //                    $category['id_category'])->first();
        //                if ($storeCaregories) {
        //                    $storeCaregories->stores_id = $id;
        //                    $storeCaregories->categories_id = $category['id_category'];
        //                    $storeCaregories->save();
        //                } else {
        //                    StoresCategories::create([
        //                        'stores_id' => $id,
        //                        'categories_id' => $category['id_category'],
        //                    ]);
        //                }
        //            }
        //        }

        $store->services()->sync($request->services);

        //        $services = $request->services;
        //        if ($categories) {
        //            foreach ($services as $key => $service) {
        //                $storeServices = ServicesStores::where('stores_id', $id)->where('services_id',
        //                    $service['id_services'])->first();
        //                if ($storeServices) {
        //                    $storeServices->stores_id = $id;
        //                    $storeServices->services_id = $service['id_services'];
        //                    $storeServices->save();
        //                } else {
        //                    ServicesStores::create([
        //                        'stores_id' => $id,
        //                        'services_id' => $service['id_services'],
        //                    ]);
        //                }
        //            }
        //        }

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

        //        if ($store->state === 1) {
        //            $store->state = 0;
        //            $store->save();
        //            return response()->json(['message' => 'Local Desactivado']);
        //        } else {
        //            $store->state = 1;
        //            $store->save();
        //            return response()->json(['message' => 'Local Activado']);
        //        }
    }
}
