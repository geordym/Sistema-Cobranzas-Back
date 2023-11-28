<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;


use App\Models\Suscription;
use App\Models\Client;
use App\Models\Option;
use App\Models\Plan;
use App\Models\Renew;
use Carbon\Carbon;

class SuscriptionController extends Controller
{



    public function list()
    {
        $suscriptions = Suscription::with(['client', 'plan'])->get();
        return json_encode($suscriptions);
    }


    public function renew(Request $request){
        $json = $request->json()->all();
        $validator = Validator::make($json, [
            'suscription_id' => 'required|numeric',
            'bill_code' => 'required',
            'duration' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $suscription_id = $json["suscription_id"];
        $bill_code = $json["bill_code"];
        $duration = $json["duration"];

        $bill = Bill::where('code', $bill_code)->first();
        if (!$bill) {
            return response()->json(['errors' => 'La factura no existe en el sistema'], 400);
        }

        $suscription = Suscription::find($suscription_id);
        if (!$suscription) {
            return response()->json(['errors' => 'La suscripcion no existe en el sistema'], 400);
        }

        $renewValidateUnique = Renew::where('bill_id', $bill->id)->first();
        if ($renewValidateUnique) {
            return response()->json(['errors' => 'La suscripcion ya fue renovada con esta factura'], 400);
        }



        $suscription_expiration_date = $suscription->expiration_date;
        $suscription_expiration_date = Carbon::parse($suscription_expiration_date);


        $suscription_NewExpiration_date = $suscription_expiration_date->addDays($duration);
        $suscription->expiration_date = $suscription_NewExpiration_date;
        $suscription->save();


        $renew = Renew::create([
            'bill_id' => $bill->id,
            'suscription_id' => $suscription->id,
            'duration' => $duration
        ]);

        return response()->json($renew, 200);
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


        $duration_suscription = Option::where('property', 'duration_suscription')->first();
        $dateCarbon = Carbon::parse($start_date);
        $expiration_date = $dateCarbon->addDays($duration_suscription->value);
        $suscription = Suscription::create([
            'plan_id' => $id_plan,
            'client_id' => $id_client,
            'cost' => $cost,
            'start_date' => $start_date,
            'expiration_date' => $expiration_date
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
