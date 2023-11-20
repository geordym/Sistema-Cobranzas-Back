<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Aloha!</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
        }
    </style>

</head>

<body>

    <table width="100%">
        <tr>
            <td valign="top"><img src="{{asset('img/logo.jpg')}}" alt="" width="100" /></td>
            <td align="right">

            </td>
        </tr>

    </table>

    <table width="100%">
        <tr>
            <td><strong>SISTEMA COBRANZAS</td>

        </tr>

        <tr>
            <td><strong>De:</strong> {{$data["client_names"]}}</td>
        </tr>
        <tr>
        <td><strong>Fecha:</strong> {{$data["date_payment"]}}</td>
        </tr>
    </table>

    <br />

    <table width="100%">
        <thead style="background-color: lightgray;">
            <tr>
                <th>#</th>
                <th>Codigo</th>
                <th>Monto</th>
                <th>Metodo de Pago</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>{{$data["code_payment"]}}</td>
                <td>{{$data["amount_payment"]}}</td>
                <td>{{$data["method_payment"]}}</td>
            </tr>

        </tbody>


    </table>

</body>

</html>
