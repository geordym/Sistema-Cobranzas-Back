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

    <h1>Listado de facturas en el sistema</h1>
    <p>{{ $contenido }}</p>


    <!-- En tu archivo de la vista Blade -->

<table>
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Estatus</th>
            <th>Codigo</th>
            <th>Total</th>
            <th>Fecha de expedicion</th>
            <th>Fecha de vencimiento</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bills as $bill)
            <tr>
                <td>{{ $bill->client->names }}</td>
                <td>{{ $bill->status }}</td>
                <td>{{ $bill->code }}</td>
                <td>{{ $bill->total }}</td>
                <td>{{ $bill->created_at }}</td>
                <td>{{ $bill->expiration_date }}</td>

            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
