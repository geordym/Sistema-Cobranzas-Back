<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Client;
use App\Models\Bill;
use App\Models\ItemBill;

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

        $bill = Bill::create([
            'client_id'=> $client_id,
            'date'=> $date,
            'total' => $totalBill
        ]);

        $bill->items()->createMany($billItems);


        return response()->json(['message' => 'Operación exitosa'], 200);


    }

    public function list()
    {
        $bills = Bill::with(['client', 'items'])->get();

        return response()->json( $bills, 200);
    }
}
