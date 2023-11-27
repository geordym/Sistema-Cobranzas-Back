<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Client;
use App\Models\Bill;
use App\Models\ItemBill;
use App\Models\Option;
use App\Models\Payment;
use PDF;
use Carbon\Carbon;

class BillController extends Controller
{
    //


    public function create(Request $request)
    {

        $json = $request->json()->all();

        $validator = Validator::make($json, [
            'client_id' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'required',
            'items' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $client_id = $json["client_id"];
        $date = $json["date"];
        $status = $json["status"];
        $billItems = $json["items"];
        $billItems2 = ["items" => $billItems];

        $rulesBillItems = [
            'items.*.quantity' => 'required|numeric',
            'items.*.cost' => 'required|numeric',
            'items.*.description' => 'required',
            'items.*.total' => 'required|numeric',
        ];

        $validatorBillItems = Validator::make($billItems2, $rulesBillItems);
        if ($validatorBillItems->fails()) {
            // Manejo de errores, por ejemplo, devolver mensajes de error al cliente
            return response()->json(['errors' => $validatorBillItems->errors()], 400);
        }

        $client = Client::find($client_id);

        if (!$client) {
            return response()->json(['errors' => 'El cliente no existe en el sistema'], 400);
        }

        $totalBill = 0;
        foreach($billItems as $item){
            $totalBill+= $item["total"];
        }

        $days_expiration_bills = Option::where('property', 'days_expiration_bills')->first();
        $dateCarbon = Carbon::parse($date);
        $expiration_date = $dateCarbon->addDays($days_expiration_bills->value);


        $dateWithoutDashes = str_replace("-", "", $date);

        $bill = Bill::create([
            'client_id'=> $client_id,
            'date'=> $date,
            'total' => $totalBill,
            'expiration_date' => $expiration_date,
            'code' => ""
        ]);

        $code = "F" . $dateWithoutDashes . $client_id . $bill->id;
        $bill->code = $code;
        $bill->save();

        $bill->items()->createMany($billItems);


        return response()->json(['message' => 'Operación exitosa'], 200);


    }

    public function list()
    {
        $bills = Bill::with(['client', 'items', 'payments'])->get();

        return response()->json( $bills, 200);
    }


    public function findByCode($code){

        if($code === ""){
            return response()->json(['errors' => 'El codigo no puede estar vacio'], 400);
        }

        $bill = Bill::with(['client', 'items', 'payments'])->where('code', $code)->first();

        if (!$bill) {
            return response()->json(['errors' => 'La factura no existe en el sistema'], 400);
        }

        return response()->json($bill, 200);

    }


    public function printNormal($code)
    {
        $bill = Bill::with(['client', 'items'])->where('code', $code)->first();
        if (!$bill) {
            return response()->json(['errors' => 'La factura no existe en el sistema'], 400);
        }
        $client = $bill->client;
        $names = $client->names;
        $dateBill = $bill->created_at;
        $code = $bill->code;
        $remitente = "SISTEMA COBRANZAS";
        $items = $bill->items;

        $data = [
            'names' => $names,
            'dateBill' => $dateBill,
            'code' => $code,
            'remitente' => $remitente,
            'items' => $items
        ];

        $pdf = PDF::loadView('prints.billnormal', compact('data'));

        return $pdf->download('mi_pdf.pdf');
    }


}
