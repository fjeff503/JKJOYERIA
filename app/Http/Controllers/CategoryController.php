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
        // Validamos la data
        $validatedData = $request->validated();
    
        // Verificar si ya existe una categoría con el mismo nombre (incluyendo las eliminadas lógicamente)
        $existingCategory = Category::withTrashed()->where('name', $validatedData['name'])->first();
    
        if ($existingCategory) {
            // Si ya existe una categoría con el mismo nombre, verifica si está eliminada lógicamente
            if ($existingCategory->trashed()) {
                // Restaurar la categoría eliminada lógicamente
                $existingCategory->restore();
                return redirect('categories')->with('success', 'Categoría restaurada correctamente');
            } else {
                // Si la categoría no está eliminada lógicamente, muestra un mensaje de error
                return redirect()->back()->withErrors('El nombre de categoría ya está en uso');
            }
        }
    
        // Si no existe una categoría con el mismo nombre, crea una nueva categoría
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
        return response()->json(array('res' => true));
    }
}
