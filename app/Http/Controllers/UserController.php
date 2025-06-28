<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Fail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\VarDumper;

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
            "users.email",
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
            $user->idRole = $request->input('idRole');
    
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
        $user->delete();
        //Retornar una respuesta json
        return response()->json(array('res' => true));
    }
}
