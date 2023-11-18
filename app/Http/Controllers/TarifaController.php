<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Tarifa;

class TarifaController extends Controller
{
    //

    public function list(){
        $tarifas = Tarifa::all();
        return response()->json($tarifas, 200);
    }

    public function create(Request $request){
        // Validaciones
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'cost' => 'required|numeric',
        ]);

        // Comprobar si las validaciones fallan
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Si las validaciones pasan, se obtienen los datos validados
        $name = $request->input('name');
        $description = $request->input('description');
        $cost = $request->input('cost');

        // Crear la tarifa
        $tarifa = Tarifa::create([
            'name' => $name,
            'description' => $description,
            'cost' => $cost,
        ]);

        // Responder con un JSON
        return response()->json(['tarifa' => $tarifa], 201);
    }

}
