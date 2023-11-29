<?php

namespace App\Http\Controllers;

use App\Mail\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\BillController; // Asegúrate de ajustar el namespace según tu estructura de directorios
use App\Mail\MessageNormal;
use App\Models\Bill;
use App\Models\Client;
use Ramsey\Uuid\Uuid;

class MessageController extends Controller
{
    private $billController;

    public function __construct()
    {
        $this->billController = new BillController();
    }

    public function sendbill(Request $request)
    {
        $json = $request->json()->all();

        $validator = Validator::make($json, [
            'client_id' => 'required',
            'bill_code' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $bill = Bill::where('code', $json["bill_code"])->first();
        if (!$bill) {
            return response()->json(['errors' => 'El factura no existe en el sistema'], 400);
        }

        $client = Client::find($json["client_id"]);
        if (!$client) {
            return response()->json(['errors' => 'El cliente no existe en el sistema'], 400);
        }

        $pdfBytes = $this->billController->printNormal($bill->code);
        $pdfPath = "";
        // Verifica si el PDF se generó correctamente
        if ($pdfBytes !== false) {
            // Crea un archivo temporal
            $uuid = Uuid::uuid4()->toString();
            $pdfTempPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $uuid . '.pdf';
            file_put_contents($pdfTempPath, $pdfBytes);
            $pdfPath = $pdfTempPath;
        } else {
            // Puedes manejar el caso en el que la generación del PDF falla
            // Por ejemplo: throw new \Exception("Error al generar el PDF.");
        }


        $billdata = new \stdClass();
        $billdata->fecha = $bill->created_at;
        $billdata->tipo = "Factura";
        $billdata->numero = $bill->code;
        $billdata->tipo_moneda = "COP";
        $billdata->valor_total = $bill->total;
        $billdata->pdf = $pdfPath;
        Mail::to($client->email)->send(new Message($billdata));
    }

    public function sendmessage(Request $request)
    {
        $json = $request->json()->all();

        $validator = Validator::make($json, [
            'client_id' => 'required',
            'message' => 'required'
        ]);

        $client = Client::find($json["client_id"]);
        if (!$client) {
            return response()->json(['errors' => 'El cliente no existe en el sistema'], 400);
        }


        $maildata = new \stdClass();
        $maildata->message = $json["message"];
        Mail::to($client->email)->send(new MessageNormal($maildata));

        return response()->json("Correo enviado exitosamente", 200);
    }
}
