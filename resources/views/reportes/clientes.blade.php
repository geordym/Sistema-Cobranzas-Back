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


    <h1>Listado de clientes en el sistema</h1>
    <p>{{ $contenido }}</p>


    <!-- En tu archivo de la vista Blade -->

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Teléfono</th>
                <th>Correo Electrónico</th>
                <th>Dirección</th>
                <th>Género</th>
                <th>Fecha de Creación</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr>
                <td>{{ $client->names }}</td>
                <td>{{ $client->surnames }}</td>
                <td>{{ $client->phone }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->address }}</td>
                <td>{{ $client->gender }}</td>
                <td>{{ $client->created_at }}</td>
                <td>{{ $client->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
