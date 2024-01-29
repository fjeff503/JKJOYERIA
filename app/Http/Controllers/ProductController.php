<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Provider;
use App\Models\Fail;
use Illuminate\Http\Request;
use App\Models\Galery;
use Illuminate\Support\Facades\Storage;


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
        $galeria = ["https://static.wixstatic.com/media/e5cc7f_9eab5500f8e842f39fd11d668fd7b679~mv2.png/v1/fill/w_500,h_497,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/e5cc7f_9eab5500f8e842f39fd11d668fd7b679~mv2.png", "https://static.wixstatic.com/media/e5cc7f_9eab5500f8e842f39fd11d668fd7b679~mv2.png/v1/fill/w_500,h_497,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/e5cc7f_9eab5500f8e842f39fd11d668fd7b679~mv2.png", "https://static.wixstatic.com/media/e5cc7f_9eab5500f8e842f39fd11d668fd7b679~mv2.png/v1/fill/w_500,h_497,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/e5cc7f_9eab5500f8e842f39fd11d668fd7b679~mv2.png"];
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
            // Verificar si ya existe un Product con el mismo codeProduct, codeProductProvider
            $existingProduct = Product::withTrashed()
                ->where('codeProduct', $validatedData['codeProduct'])
                ->where('codeProductProvider', $validatedData['codeProductProvider'])
                ->first();

            if ($existingProduct) {
                // Si ya existe un Product con el mismo nombre, idDay, e idParcel, verifica si está eliminado lógicamente
                if ($existingProduct->trashed() != null) {
                    // Restaurar el Product eliminado lógicamente
                    $existingProduct->restore();
                    return redirect('products')->with('info', 'Producto restaurado correctamente');
                }
            }

            // Verificar si ya existe un Product con el mismo codeProduct
            $existingCodeProduct = Product::withTrashed()
                ->where('codeProduct', $validatedData['codeProduct'])
                ->first();

            if ($existingCodeProduct) {
                // Si ya existe un Product con el mismo nombre, idDay, e idParcel, verifica si está eliminado lógicamente
                if ($existingCodeProduct->trashed() != null) {
                    // Restaurar el Product eliminado lógicamente
                    $existingCodeProduct->restore();
                    return redirect('products')->with('info', 'Producto restaurado correctamente');
                }
            }

            // Si no existe un encomendista con el mismo nombre, crea un nuevo Punto de Entrega
            $product = Product::create($validatedData);

            //almacenar las imagenes
            try {
                // Guardar imágenes en AWS S3
                $images = $request->file('images');

                if ($images) {
                    foreach ($images as $image) {
                        $path = $image->store('images', 's3'); // 'images' es la carpeta en tu bucket

                        // Guardar la URL en la tabla 'gallery'
                        $url = Storage::disk('s3')->url($path);
                        // Guardar la URL en la tabla 'gallery' asociada al producto
                        $product->galery()->create(['url' => $url]);
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
                        'error' => 'Error no reconocido' . $th,
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
                    'error' => 'Error no reconocido' . $th,
                ));
            }
        }
    }

    public function edit(Product $product)
    {
        //extraemos el producto y sus imágenes
        $product = Product::with('galery')->findOrFail($product->idProduct);
        //extraemos las categorias
        $categories = Category::get();
        //extraemos los proveedores
        $providers = Provider::get();

        return view('/admin/product/update', compact('categories', 'providers', 'product'));
    }

    public function update(UpdateProductRequest $request, $idProduct)
    { {
            //intento
            try {
                // Traemos la data del item que estamos modificando
                $product = Product::findOrFail($idProduct);

                // Verificar si el nuevo valor del campo "telefono" ya existe en otro registro
                if ($product->codeProduct !== $request->input('codeProduct') && Product::where('codeProduct', $request->input('codeProduct'))->exists()) {
                    return redirect()->back()->withErrors(['codeProduct' => 'El código del producto ya está siendo utilizado por otro registro.'])->withInput();
                } else if ($product->codeProductProvider !== $request->input('codeProductProvider') && Product::where('codeProductProvider', $request->input('codeProductProvider'))->exists()) {
                    return redirect()->back()->withErrors(['codeProductProvider' => 'El código del proveedor ya está siendo utilizado por otro registro.'])->withInput();
                }

                // Actualizamos los datos
                $product->codeProduct = $request->input('codeProduct');
                $product->codeProductProvider = $request->input('codeProductProvider');
                $product->name = $request->input('name');
                $product->sellPrice = $request->input('sellPrice');
                $product->stock = $request->input('stock');
                $product->description = $request->input('description');
                $product->idCategory = $request->input('idCategory');
                $product->idProvider = $request->input('idProvider');
                // Guardamos los cambios
                $product->save();

                //---------------------------------//
                //Si traemos imagenes
                //---------------------------------//
                if ($images = $request->file('images')) {
                    try {
                        //---------------------------------//
                        // Elimina las imágenes del bucket
                        //---------------------------------//
                        foreach ($product->galery as $image) {
                            // Extraer la ruta relativa desde la URL completa
                            $relativePath = parse_url($image->url, PHP_URL_PATH);
                            Storage::disk('s3')->delete($relativePath);
                        }

                        // Elimina relaciones en la tabla Gallery
                        $product->galery()->delete();
                    } catch (\Throwable $th) {
                        // Retornamos el mensaje
                        Fail::create(array(
                            'tableName' => 'products',
                            'action' => 'destroy',
                            'message' => $th->getMessage(),
                            'file' => $th->getFile(),
                            'line' => $th->getLine()
                        ));
                        return redirect('products')->with(array(
                            'error' => 'La acción no pudo ser realizada',
                        ));
                    }
                    //---------------------------------//
                    //Intentamos almacenar las imagenes
                    //---------------------------------//
                    try {
                        // Guardar imágenes en AWS S3
                        $images = $request->file('images');

                        if ($images) {
                            foreach ($images as $image) {
                                $path = $image->store('images', 's3'); // 'images' es la carpeta en tu bucket

                                // Guardar la URL en la tabla 'gallery'
                                $url = Storage::disk('s3')->url($path);
                                // Guardar la URL en la tabla 'gallery' asociada al producto
                                $product->galery()->create(['url' => $url]);
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
                                'error' => 'Error no reconocido' . $th,
                            ));
                        }
                    }
                }
                // Retornamos a la vista principal
                return redirect('products')->with('success', 'Producto actualizado correctamente');
            } catch (\Throwable $th) {
                try {
                    // Retornamos el mensaje
                    Fail::create(array(
                        'tableName' => 'products',
                        'action' => 'update',
                        'message' => $th->getMessage(),
                        'file' => $th->getFile(),
                        'line' => $th->getLine()
                    ));
                    return redirect('products')->with(array(
                        'error' => 'La acción no pudo ser realizada',
                    ));
                } catch (\Throwable $th) {
                    return redirect('products')->with(array(
                        'error' => 'Error no reconocido',
                    ));
                }
            }
        }
    }

    public function destroy(Product $product)
    {
        try {
            // Elimina las imágenes del bucket
            foreach ($product->galery as $image) {
                // Extraer la ruta relativa desde la URL completa
                $relativePath = parse_url($image->url, PHP_URL_PATH);
                Storage::disk('s3')->delete($relativePath);
            }

            // Elimina relaciones en la tabla Gallery
            $product->galery()->delete();

            // Elimina el producto
            $product->delete();

            // Retornar una respuesta json
            return response()->json(['res' => true]);
        } catch (\Throwable $th) {
            // Retornamos el mensaje
            Fail::create(array(
                'tableName' => 'products',
                'action' => 'destroy',
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ));
            return redirect('products')->with(array(
                'error' => 'La acción no pudo ser realizada',
            ));
        }
    }
}
