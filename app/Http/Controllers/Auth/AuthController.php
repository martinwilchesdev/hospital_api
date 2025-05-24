<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request) {
        // se valida que tanto el usuario como la contraseña se hayan enviado correctamente
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // se busca el usuario en la base de datos a partir del usuario
        $user = User::where('correo', $request->email)->first();

        // se verifica que el usuario exista y que la contraseña sea correcta
        if (!$user || !Hash::check($request->password, $user->contraseña)) {
            // si no se cumple la validacion se lanza una excepcion de validacion
            throw ValidationException::withMessages([
                'email' => ['Credenciales incorrectas'] // mensaje de validacion que recibira el cliente
            ]);
        }

        // para poder utilizar el metodo createToken(), es necesario que en el modelo se este usando el trait HasApiTokens
        return $user->createToken('token')->plainTextToken; // si las credenciales son validas, se genera un token con Sanctum
    }

    public function register(Request $request) {
        // se valida que se hayan enviado correctamente los datos (email, password, password_confirmation)
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed' // confirmed garantizar que la contraseña haya sido confirmada desde el cliente (password_confirmation)
        ]);

        // se crea el usuario en base de datos
        $user = User::create([
            'nombre' => $fields['name'],
            'correo' => $fields['email'],
            'contraseña' => Hash::make($fields['password'])
        ]);

        // se crea el token de acceso de Sanctum
        $token = $user->createToken('token')->plainTextToken;

        // se retorna el token al cliente
        return response($token, 201);
    }
}
