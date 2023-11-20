@php
$cliente = "Luis Cabrera Benito";
$remitente = "Luis Cabrera Benito";
$web = "https://parzibyte.me/blog";
$mensajePie = "Gracias por su compra";
$numero = 1;
$descuento = 0;
$porcentajeImpuestos = 16;

$fecha = date("Y-m-d");

$subtotal = 0;
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="./bs3.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Factura</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">

</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-10 ">
            <h1>Factura</h1>
        </div>
        <div class="col-xs-2">
        <img class="img img-responsive img-thumbnail img-fluid" src="{{ asset('img/logo.jpg') }}" alt="Logotipo" style="width: 100px; heigth: 100px;">
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-10">
            <h1 class="h6">{{ $data['remitente'] }}</h1>
            <h1 class="h6"><?php echo $web ?></h1>
        </div>
        <div class="col-xs-2 text-center">
            <strong>Fecha</strong>
            <br>
            <?php echo $data["dateBill"] ?>
            <br>
            <strong>Factura No.</strong>
            <br>
            <?php echo $data["code"] ?>
        </div>
    </div>
    <hr>
    <div class="row text-center" style="margin-bottom: 2rem;">
        <div class="col-xs-6">
            <h1 class="h2">Cliente</h1>
            <strong><?php echo $data["names"] ?></strong>
        </div>
        <div class="col-xs-6">
            <h1 class="h2">Remitente</h1>
            <strong><?php echo $data["remitente"]?></strong>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-condensed table-bordered table-striped">
                <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data["items"] as $item)
                    <tr>
                        <td>{{$item->description}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->cost}}</td>
                        <td>{{$item->total}}</td>
                    </tr>

                    {{$subtotal += $item->total}}
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3" class="text-right">Subtotal</td>
                    <td>{{$subtotal}}</td>
                </tr>


                <tr>
                    <td colspan="3" class="text-right">
                        <h4>Total</h4></td>
                    <td>
                        <h4>{{$subtotal}}</h4>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-center">
        </div>
    </div>
</div>
</body>
</html>
