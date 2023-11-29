<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    //

    public function index(){
        return view('home'); // Asegúrate de que esta vista exista
    }

    public function findById($id){
        $user = User::with('role')->find($id);
        if (!$user) {
            return response()->json(['errors' => 'El usuario no existe en el sistema'], 400);
        }

        return response()->json($user);
    }

    public function update(Request $request){
        $json = $request->json()->all();

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
        ]);



        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $id = $json["id"];

        $user = User::find($id);
        if (!$user) {
            return response()->json(['errors' => 'El usuario no existe en el sistema'], 400);
        }

        if ($user->email !== $json["email"]) {
            $userEmail = User::where('email', $json["email"])->first();
            if($userEmail){
                return response()->json(['errors' => 'Este correo ya esta tomado'], 400);
            }
        }

        $id_rol = Role::where('name', $json['role']['name'])->first()->id;


        $user->name = $json["name"];
        $user->email = $json["email"];
        $user->id_rol = $id_rol;
        $user->save();

        return response()->json($user, 200);

    }


    public function profile(){
        $user = auth()->user();
        return view('profile', compact('user'));
    }

    public function list(){
        $users = User::with('role')->get();

        return response()->json($users, 200);
    }


    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $json = $request->json()->all();
        $name = $json['name'];
        $email = $json['email'];
        $rol =  $json['role']['name'];

        // Obtener el ID del rol a través de la consulta where
        $id_rol = Role::where('name', $rol)->first()->id;

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($email),
            'id_rol' => $id_rol,
        ]);

        return response()->json(['user' => $user], 201);
    }


    public function logout(){
        Auth::logout(); // Cierra la sesión del usuario
        return redirect('/login'); // Redirige al usuario a la página de inicio de sesión o a la página que desees después del cierre de sesión.
    }

    public function changepassword(Request $request) {
          // Validaciones
    $validator = Validator::make($request->all(), [
        'id' => 'required|numeric',
        'password' => 'required|string|min:8',
    ]);

    // Comprobar si las validaciones fallan
    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Obtener el usuario a actualizar
    $user = User::find($request->input('id'));

    // Comprobar si el usuario existe
    if (!$user) {
        return response()->json(['error' => 'Usuario no encontrado'], 404);
    }

    // Cambiar la contraseña
    $user->password = Hash::make($request->input('password'));

    // Guardar los cambios
    $user->save();

    // Responder con un JSON
    return response()->json($user, 200);
    }



    public function restorepassword($id){
        $user = User::find($id);
        if (!$user) {
            return response()->json(['errors' => 'El usuario no existe en el sistema'], 400);
        }

        $email = $user->email;
        $user->password = bcrypt($email);
        $user->save();
        return response()->json(['message' => "Usuario actualizado exitosamente"], 201);

    }

    public function desactivate($id){
        $user = User::find($id);
        if (!$user) {
            return response()->json(['errors' => 'El usuario no existe en el sistema'], 400);
        }

        if($user->status == 0){
            $user->status = 1;
        }else {
            $user->status = 0;
        }

        $user->save();
        return response()->json(['message' => "Usuario desactivado/activado exitosamente"], 201);
    }

    public function destroy(Request $request)
    {
        $json = $request->json()->all();

        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $id = $json["id"];
        $user = User::find($id);

        if (!$user) {
            return response()->json(['errors' => 'El usuario no existe en el sistema'], 400);
        }

        $user->delete(); // Corregir esta línea

        return response()->json(['message' => 'Usuario eliminado'], 200);
    }

}
