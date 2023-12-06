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

    <h1>Listado de Suscripciones en el sistema</h1>
    <p>{{ $contenido }}</p>


    <!-- En tu archivo de la vista Blade -->

    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Plan</th>
                <th>Costo</th>
                <th>Fecha de inicio</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suscriptions as $suscription)
            <tr>
                <td>{{ $suscription->client->names }}</td>
                <td>{{ $suscription->plan->name }}</td>
                <td>{{ $suscription->cost }}</td>
                <td>{{ $suscription->created_at }}</td>
                <td>{{ $suscription->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
