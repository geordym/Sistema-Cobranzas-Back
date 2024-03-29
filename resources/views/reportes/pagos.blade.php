<!-- resources/views/pdf/mi_vista.blade.php -->

<!DOCTYPE html>
<html>

<head>
</head>

<body>

    <div class="row">

        <div class="col-xs-2">
            <img class="img img-responsive img-thumbnail img-fluid" src="{{ asset('img/logo.jpg') }}" alt="Logotipo" style="width: 100px; heigth: 100px;">
        </div>
    </div>

    <h1>Listado de pagos en el sistema</h1>
    <p>{{ $contenido }}</p>


    <!-- En tu archivo de la vista Blade -->

    <table>
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Cliente</th>
                <th>Monto</th>
                <th>Fecha de pago</th>
                <th>Metodo de pago</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->code }}</td>
                <td>{{ $payment->client->names }}</td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->created_at }}</td>
                <td>{{ $payment->payment_method }}</td>
                <td>{{ $payment->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
