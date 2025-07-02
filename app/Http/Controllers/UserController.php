<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Fail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         //Extraemos los Usuarios
         $data = User::select(
            "users.id",
            "users.name",
            "users.lastname",
            "users.email",
            "users.phone",
            "users.profile_photo",
            "users.address",
            "roles.name as role"
        )
            ->join("roles", "roles.idRole", "=", "users.idRole")
            ->get();

        return view('/admin/users/index')->with(['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //extraemos los roles
        $roles = Role::get();

        return view('/admin/users/update', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $idUser)
    {
        try {
            // Traemos el usuario que estamos modificando
            $user = User::findOrFail($idUser);
    
            // Actualizamos los datos
            $user->name = $request->input('name');
            $user->lastname = $request->input('lastname');
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            
            // Solo actualizamos el rol si viene en el request (es decir, si el admin lo modificó)
            if ($request->input('idRole')) {
                $user->idRole = $request->input('idRole');
            }
    
            //Si se subió nueva imagen
            if ($request->hasFile('profile_photo')) {
                // Borra la anterior si existía
                $relativePath = parse_url($user->profile_photo, PHP_URL_PATH);
                Storage::disk('s3')->delete($relativePath);

            // Almacena nueva imagen
            $path = $request->file('profile_photo')->store('profile-photos', 's3');

            // Guarda la URL pública o path, según uses
            $user->profile_photo = Storage::disk('s3')->url($path);
        }

            // Guardamos los cambios
            $user->save();
    
            // Retornamos a la vista principal
            return redirect('users')->with('success', 'Usuario actualizado correctamente');
        } catch (\Throwable $th) {
            try {
                // Guardamos el error en la tabla 'fails'
                Fail::create([
                    'tableName' => 'users',
                    'action' => 'update',
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine(),
                ]);
    
                return redirect('users')->with('error', 'La acción no pudo ser realizada');
            } catch (\Throwable $th) {
                return redirect('users')->with('error', 'Error no reconocido');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            // Si tiene imagen de perfil, eliminarla del bucket S3
            if ($user->profile_photo && filter_var($user->profile_photo, FILTER_VALIDATE_URL)) {
                $relativePath = ltrim(parse_url($user->profile_photo, PHP_URL_PATH), '/');
                Storage::disk('s3')->delete($relativePath);
            }
    
            // Eliminar usuario (soft delete)
            $user->delete();
    
            return response()->json(['res' => true]);
        } catch (\Throwable $e) {
            return response()->json(['res' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
