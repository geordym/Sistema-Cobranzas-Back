<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Client;

class ClientController extends Controller
{


    public function list(){
        $clients = Client::all();
        return response()->json($clients, 200);
    }


    public function listByNames($names){
        $clients = Client::where('names', 'like', '%' . $names . '%')->get();
        return response()->json($clients, 200);
    }

    public function listBySurnames($surnames){
        $clients = Client::where('surnames', 'like', '%' . $surnames . '%')->get();
        return response()->json($clients, 200);
    }

    public function listByIdentification($identification){
        $clients = Client::where('identification', 'like', '%' . $identification . '%')->get();
        return response()->json($clients, 200);
    }


    public function create(Request $request){
        // Validaciones
        $validator = Validator::make($request->all(), [
            'names' => 'required|string|max:255',
            'surnames' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'id_type' => 'required|string|max:255',
            'rtn' => 'required',
            'birth_date' => 'required',
            'gender' => 'required'

        ]);

        // Comprobar si las validaciones fallan
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Si las validaciones pasan, se obtienen los datos validados
        $names = $request->input('names');
        $surnames = $request->input('surnames');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $address = $request->input('address');
        $id_type = $request->input('id_type');
        $identification = $request->input('identification');
        $rtn = $request->input('rtn');
        $birth_date = $request->input('birth_date');
        $gender = $request->input('gender');

        // Crear el cliente
        $client = Client::create([
            'names' => $names,
            'surnames' => $surnames,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'id_type' => $id_type,
            'identification' => $identification,
            'rtn' => $rtn,
            'birth_date' => $birth_date,
            'gender' => $gender
        ]);

        // Responder con un JSON
        return response()->json($client, 201);
    }
}
