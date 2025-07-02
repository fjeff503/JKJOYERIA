<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'lastname' => ['required', 'string', 'max:255', 'min:3'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->whereNull('deleted_at')
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function storeProfilePhoto($photo)
    {
        // Guarda en S3 en carpeta 'profile-photos', genera un nombre único
        $path = $photo->store('profile-photos', 's3');

        // Opcional: hacer pública la imagen (depende de tu configuración)
        Storage::disk('s3')->setVisibility($path, 'public');

        // Retorna la URL completa
        return Storage::disk('s3')->url($path);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::withTrashed()->where('email', $data['email'])->first();

        if ($user) {
            if ($user->trashed()) {
                // Restaurar usuario eliminado
                $user->restore();
            
                $user->name = $data['name'];
                $user->lastname = $data['lastname'];
                $user->phone = $data['phone'];
                $user->address = $data['address'];
                $user->password = Hash::make($data['password']);
                $user->idRole = 1; // asignar rol de user
                 // Subir imagen al bucket si se envió una nueva
                if (isset($data['profile_photo']) && $data['profile_photo'] instanceof \Illuminate\Http\UploadedFile) {
                    $path = $data['profile_photo']->store('profile-photos', 's3');
                    $user->profile_photo = Storage::disk('s3')->url($path);
                }
            
                $user->save();
            
                return $user;
            }
    
            // Si el usuario ya existe y NO está eliminado
            // Puedes redirigir o lanzar una excepción
            redirect('/login')->with('status', 'Este correo ya está registrado. Inicia sesión.');
            exit;
        }
    
            // Nuevo usuario
            $userData = [
                'name' => $data['name'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'password' => Hash::make($data['password']),
                'idRole' => 1,
            ];

    // Guardar imagen si existe
    if (isset($data['profile_photo'])) {
        $userData['profile_photo'] = $this->storeProfilePhoto($data['profile_photo']);
    }

    return User::create($userData);
    }
}
