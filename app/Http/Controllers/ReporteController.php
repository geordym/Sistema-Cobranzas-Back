<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use PDF;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Suscription;

class ReporteController extends Controller
{
    //

    public function reporteClientes(Request $request){
        $json = $request->json()->all();
        $validator = Validator::make($json, [
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $start_date = $json["start_date"];
        $end_date = $json["end_date"];

        $clients = Client::whereBetween('created_at', [$start_date, $end_date])->get();

        $data = [
            'titulo' => 'Mi PDF desde Laravel',
            'contenido' => '',
            'clients' => $clients
        ];

        $pdf = PDF::loadView('reportes.clientes', $data);

        return $pdf->download('mi_pdf.pdf');
    }

    public function reportePagos(Request $request){
        $json = $request->json()->all();
        $validator = Validator::make($json, [
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $start_date = $json["start_date"];
        $end_date = $json["end_date"];

        $payments = Payment::with(['client'])->whereBetween('created_at', [$start_date, $end_date])->get();
        $data = [
            'titulo' => 'Mi PDF desde Laravel',
            'contenido' => '',
            'payments' => $payments
        ];

        $pdf = PDF::loadView('reportes.pagos', $data);

        return $pdf->download('mi_pdf.pdf');
    }


    public function reporteFacturas(Request $request){
        $json = $request->json()->all();
        $validator = Validator::make($json, [
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $start_date = $json["start_date"];
        $end_date = $json["end_date"];

        $bills = Bill::with(['client'])->whereBetween('created_at', [$start_date, $end_date])->get();



        $data = [
            'titulo' => 'Mi PDF desde Laravel',
            'contenido' => '',
            'bills' => $bills
        ];

        $pdf = PDF::loadView('reportes.facturas', $data);

        return $pdf->download('mi_pdf.pdf');
    }

    public function reporteSuscripciones(Request $request){
        $json = $request->json()->all();
        $validator = Validator::make($json, [
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $start_date = $json["start_date"];
        $end_date = $json["end_date"];

        $suscriptions = Suscription::with(['client', 'plan'])->whereBetween('created_at', [$start_date, $end_date])->get();



        $data = [
            'titulo' => 'Mi PDF desde Laravel',
            'contenido' => '',
            'suscriptions' => $suscriptions
        ];

        $pdf = PDF::loadView('reportes.suscripciones', $data);

        return $pdf->download('mi_pdf.pdf');
    }


}
