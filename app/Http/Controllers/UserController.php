<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    //

    public function index(){
        return view('home'); // Asegúrate de que esta vista exista
    }


    public function profile(){
        $user = auth()->user();
        return view('profile', compact('user'));
    }

    public function list(){
        $users = User::with('role')->get();

        $newUsers = [];

        foreach ($users as $user) {
            $newUser = $user;
            $newUser->rol = $user->role->name;
            $newUsers[] = $newUser;
        }

        return response()->json($users, 200);
    }


    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'rol' => 'required|string|exists:roles,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $json = $request->json()->all();
        $name = $json['name'];
        $email = $json['email'];
        $rol =  $json['rol'];

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
