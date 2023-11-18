<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Plan;


class PlanController extends Controller
{
    //

    public function index(){

        $plans = Plan::all();
        return view('planes.index')->with('plans', $plans);
    }

    public function list(){
        $plans = Plan::all();
        return response()->json($plans, 200);
    }

    public function create(Request $request){
        // Validaciones
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'cost' => 'required|numeric',
        ]);

        // Si las validaciones pasan, se obtienen los datos validados
        $name = $validatedData['name'];
        $description = $validatedData['description'];
        $cost = $validatedData['cost'];

        // Crear el plan
        $plan = Plan::create([
            'name' => $name,
            'description' => $description,
            'cost' => $cost,
        ]);

        // Responder con un JSON
        return response()->json($plan, 201);
    }
}
