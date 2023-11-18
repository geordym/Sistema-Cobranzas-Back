<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;


use App\Models\Suscription;
use App\Models\Client;
use App\Models\Plan;

class SuscriptionController extends Controller
{



    public function list()
    {
        $suscriptions = Suscription::with(['client', 'plan'])->get();
        return json_encode($suscriptions);
    }


    public function create(Request $request)
    {
        $json = $request->json()->all();

        $validator = Validator::make($json, [
            'plan_id' => 'required|numeric',
            'client_id' => 'required|numeric',
            'cost' => 'required|numeric',
            'start_date' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }



        $id_plan = $json["plan_id"];
        $id_client = $json["client_id"];
        $cost = $json["cost"];
        $start_date = $json["start_date"];



        $plan = Plan::find($id_plan);
        if (!$plan) {
            return response()->json(['errors' => 'El plan no existe en el sistema'], 400);
        }

        $client = Client::find($id_client);
        if (!$client) {
            return response()->json(['errors' => 'El cliente no existe en el sistema'], 400);
        }


        $isAlreadySubscribed = $client->suscriptions->contains('plan_id', $id_plan);
        if ($isAlreadySubscribed) {
            return response()->json(['errors' => 'El cliente ya está suscrito a este plan'], 400);
        }


        $suscription = Suscription::create([
            'plan_id' => $id_plan,
            'client_id' => $id_client,
            'cost' => $cost,
            'start_date' => $start_date
        ]);


        return response()->json(['message' => 'Operación exitosa'], 200);
    }

    public function update(Request $request)
    {
    }

    public function destroy(Request $request)
    {
    }
}
