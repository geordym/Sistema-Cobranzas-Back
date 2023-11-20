<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\Payment;
use App\Models\Client;
use App\Models\Bill;

use PDF;

class PaymentController extends Controller
{
    //

    public function create(Request $request){
        $json = $request->json()->all();


        $validator = Validator::make($json, [
            'code' => 'required',
            'client_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'payment_method' => 'required',
            'notes' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $code = $json["code"];
        $client_id = $json["client_id"];
        $amount = $json["amount"];
        $payment_method = $json["payment_method"];
        //$status = $json["status"];
        $notes = $json["notes"];

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $client = Client::find($client_id);

        if (!$client) {
            return response()->json(['errors' => 'El cliente no existe en el sistema'], 400);
        }

        $bill = Bill::where('code', $code)->first();

        if (!$bill) {
            return response()->json(['errors' => 'La factura no existe en el sistema'], 400);
        }


        $payment = Payment::create([
           'bill_id' => $bill->id,
           'client_id' => $client_id,
           'amount' => $amount,
           'payment_method' => $payment_method,
           'status' => "",
           'notes' => $notes
        ]);
        $dateWithoutTime = substr($payment->created_at, 0, 10);
        $dateWithoutDashes = str_replace("-", "", $dateWithoutTime);

        $code =  $dateWithoutDashes . $bill->id . $client_id . $payment->id;

        $payment->code = $code;
        $payment->save();

        return response()->json($payment, 200);

    }

    public function list(){
        $payments = Payment::with(['client', 'bill'])->get();
        return response()->json($payments, 200);

    }

    public function printTicket($code){


        $payment = Payment::with('client')->where('code', $code)->first();
        $client = $payment->client;

        $names = $client->names;
        $datePayment = $payment->created_at;
        $code = $payment->code;
        $remitente = "SISTEMA COBRANZAS";
        $payment_method = $payment->payment_method;
        $data = [
            'client_names' => $names,
            'method_payment' => $payment_method,
            'amount_payment' => $payment->amount,
            'date_payment' => $datePayment,
            'code_payment' => $code,
        ];
        $customPaper = array(0, 0, 567.00, 283.80);

        $pdf = PDF::loadView('prints.payment_ticket', compact('data'))->setPaper($customPaper, 'landscape');

        return $pdf->download('mi_pdf.pdf');
    }


}
