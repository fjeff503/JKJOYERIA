<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Provider;
use App\Models\Fail;
use App\Models\Galery;

class ProductController extends Controller
{
    public function index()
    {
        //Extraemos las Categorias
        $data = Product::select(
            "products.idProduct",
            "products.codeProduct",
            "products.codeProductProvider",
            "products.name",
            "products.sellPrice",
            "products.stock",
            "products.description",
            "providers.name as provider",
            "categories.name as category",
            "galeries.url as fotos"  // Agrega los campos de la tabla 'galleries' que necesitas
        )
        ->join("categories", "categories.idCategory", "=", "products.idCategory")
        ->join("providers", "providers.idProvider", "=", "products.idProvider")
        ->leftJoin("galeries", "galeries.idProduct", "=", "products.idProduct") // Se utiliza leftJoin para incluir resultados incluso si no hay coincidencias en la tabla 'galeries'
        ->get()
        ->groupBy('idProduct');  // Agrupar resultados por 'idProduct'
        $galeria = ["https://static.wixstatic.com/media/e5cc7f_9eab5500f8e842f39fd11d668fd7b679~mv2.png/v1/fill/w_500,h_497,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/e5cc7f_9eab5500f8e842f39fd11d668fd7b679~mv2.png","https://static.wixstatic.com/media/e5cc7f_9eab5500f8e842f39fd11d668fd7b679~mv2.png/v1/fill/w_500,h_497,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/e5cc7f_9eab5500f8e842f39fd11d668fd7b679~mv2.png","https://static.wixstatic.com/media/e5cc7f_9eab5500f8e842f39fd11d668fd7b679~mv2.png/v1/fill/w_500,h_497,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/e5cc7f_9eab5500f8e842f39fd11d668fd7b679~mv2.png"];
        return view('/admin/product/index', compact('data', 'galeria'));
    }

    public function create()
    {
        //extraemos las categorias
        $categories = Category::get();
        //extraemos los proveedores
        $providers = Provider::get();
        
        return view('/admin/product/create', compact('categories', 'providers'));
    }

    public function store(StoreProductRequest $request)
    {
        
        try {
            // Validamos la data
            $validatedData = $request->validated();
            // Verificar si ya existe un Product con el mismo nombre, idCategory, e idProvider
            $existingProduct = Product::withTrashed()
                ->where('name', $validatedData['name'])
                ->where('idCategory', $validatedData['idCategory'])
                ->where('idProvider', $validatedData['idProvider'])
                ->first();

            if ($existingProduct) {
                // Si ya existe un Product con el mismo nombre, idDay, e idParcel, verifica si está eliminado lógicamente
                if ($existingProduct->trashed() != null) {
                    // Restaurar el Product eliminado lógicamente
                    $existingProduct->restore();
                    return redirect('products')->with('info', 'Producto restaurado correctamente');
                }
            }

            // Si no existe un encomendista con el mismo nombre, crea un nuevo Punto de Entrega
            $product = Product::create($validatedData);

            //almacenar las imagenes
            try{
                // Asociar imágenes
                $images = $request->input('images');

                if ($images) {
                    foreach ($images as $imageUrl) {
                        if($imageUrl){
                            // Crea la relación con la tabla Gallery
                            $galleryImage = new Galery(['url' => $imageUrl]);
                            // Guarda la relación
                            $product->galery()->save($galleryImage);
                        }
                    }
                }
            } catch (\Throwable $th) {
            try {
                // Retornamos el mensaje
                Fail::create(array(
                    'tableName' => 'galery',
                    'action' => 'store',
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine()
                ));
                return redirect('products')->with(array(
                    'error' => 'La acción no pudo ser realizada',
                ));
            } catch (\Throwable $th) {
                return redirect('products')->with(array(
                    'error' => 'Error no reconocido'.$th,
                ));
            }
        }

            return redirect('products')->with('success', 'Producto creado correctamente');
        } catch (\Throwable $th) {
            try {
                // Retornamos el mensaje
                Fail::create(array(
                    'tableName' => 'products',
                    'action' => 'store',
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine()
                ));
                return redirect('products')->with(array(
                    'error' => 'La acción no pudo ser realizada',
                ));
            } catch (\Throwable $th) {
                return redirect('products')->with(array(
                    'error' => 'Error no reconocido'.$th,
                ));
            }
        }
    }

    public function edit(Product $product)
    {
        //extraemos las categorias
        $categories = Category::get();
        //extraemos los proveedores
        $providers = Provider::get();

        return view('/admin/product/update', compact('categories', 'providers', 'product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());
        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
