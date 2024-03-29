<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //

    public function login(Request $request){
        $json = $request->json()->all();
        $correo = $json["correo"];
        $contraseña = $json["contraseña"];

        // Buscar usuario por correo y contraseña
        $usuario = User::with('role')->where('email', $correo)->first();

        // Comprobar si el cliente existe
        if (!$usuario) {
            return response()->json(['errors' => 'Usuario no encontrado'], 404);
        }

        if($usuario->status == 0){
            return response()->json(['message' => 'Este usuario se encuentra desactivado'], 401);
        }

        // Verificar si el usuario existe y si la contraseña es correcta
        if ($usuario && Hash::check($contraseña, $usuario->password)) {
            // Usuario autenticado correctamente
            // Puedes generar y devolver un token de acceso aquí si estás usando Laravel Passport

            return response()->json($usuario, 200);
        } else {
            // Usuario no encontrado o contraseña incorrecta
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }
    }

}
