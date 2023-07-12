<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // Obtener el límite de elementos por página del request o de la sesión, por defecto 10
        $perPage = $request->input('per_page', session('per_page', 10));

        // Almacena el valor seleccionado en la sesión
        session(['per_page' => $perPage]);

        // Obtén los datos paginados según el límite seleccionado
        $categories = Category::paginate($perPage);

        return view('/admin/category/index', compact('categories'));
    }

    public function create()
    {
        return view('/admin/category/create');
    }

    public function store(StoreCategoryRequest $request)
    {
        //Validamos la data
        $validatedData = $request->validated();
        //este toma los parametros y reglas pa guardar del Http\Requests\Category\StoreRequest
        Category::create($validatedData);
        return redirect('categories')->with('success', 'Categoría creada correctamente');
    }

    public function edit(Category $category)
    {
        //Mostrar la vista 
        return view('/admin/category/update')->with(['category' => $category]);
    }

    public function update(UpdateCategoryRequest $request, $idCategory)
    {
        //traemos la data si el iteme que estamos modificando
        $category = Category::findOrFail($idCategory);

        // Verificar si el nuevo valor del campo "name" ya existe en otro registro
        if ($category->name !== $request->input('name') && Category::where('name', $request->input('name'))->exists()) {
            return redirect()->back()->withErrors(['name' => 'El nombre ya está siendo utilizado por otro registro.'])->withInput();
        }

        //actualizamos los datos
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        
        //guardamos los cambios
        $category->save();

        //retornamos a la vista principal
        return redirect('categories')->with('success', 'Categoría actualizada correctamente');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        //Retornar una respuesta json
        return response()->json(array('res' => true, 'delete'=>'Categoría eliminada correctamente'));
    }
}
