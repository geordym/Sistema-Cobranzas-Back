<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PDF;

class ReporteController extends Controller
{
    //

    public function reporteClientes(Request $request){
        $data = [
            'titulo' => 'Mi PDF desde Laravel',
            'contenido' => 'Este es el contenido de mi PDF.',
        ];

        $pdf = PDF::loadView('reportes.clientes', $data);

        return $pdf->download('mi_pdf.pdf');
    }

    public function reportePagos(Request $request){

    }


    public function reporteFacturas(Request $request){

    }

    public function reporteSuscripciones(Request $request){

    }


}
