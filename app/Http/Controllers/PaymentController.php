<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\Payment;
use App\Models\Client;
use App\Models\Bill;

class PaymentController extends Controller
{
    //

    public function create(Request $request){
        $json = $request->json()->all();


        $validator = Validator::make($json, [
            'bill_id' => 'required|numeric',
            'client_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'payment_method' => 'required',
            'status' => 'required',
            'notes' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $bill_id = $json["bill_id"];
        $client_id = $json["client_id"];
        $amount = $json["amount"];
        $payment_method = $json["payment_method"];
        $status = $json["status"];
        $notes = $json["notes"];

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $client = Client::find($client_id);

        if (!$client) {
            return response()->json(['errors' => 'El cliente no existe en el sistema'], 400);
        }

        $bill = Bill::find($bill_id);

        if (!$bill) {
            return response()->json(['errors' => 'La factura no existe en el sistema'], 400);
        }


        $payment = Payment::create([
           'bill_id' => $bill_id,
           'client_id' => $client_id,
           'amount' => $amount,
           'payment_method' => $payment_method,
           'status' => $status,
           'notes' => $notes
        ]);

        return response()->json(['message' => 'Operación exitosa'], 200);

    }

    public function list(){
        $payments = Payment::all();
        return response()->json(['payments' => $payments], 200);

    }
}
