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
        $user = User::where('email', $request->email)->first();

        // se verifica que el usuario exista y que la contraseña sea correcta
        if (!$user || !Hash::check($request->password, $user->password)) {
            // si no se cumple la validacion se lanza una excepcion de validacion
            throw ValidationException::withMessages([
                'email' => ['Credenciales incorrectas'] // mensaje de validacion que recibira el cliente
            ]);
        }

        // para poder utilizar el metodo createToken(), es necesario que en el modelo se este usando el trait HasApiTokens
        return $user->createToken('authToken')->plainTextToken; // si las credenciales son validas, se genera un token con Sanctum
    }
}
