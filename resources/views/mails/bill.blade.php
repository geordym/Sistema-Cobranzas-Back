<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura Electrónica</title>
</head>
<body>
    <h2>Factura Electrónica</h2>

    <p>Ha recibido un documento electrónico generado y enviado mediante el sistema cobranzas</p>

    <h3>Datos del Emisor</h3>
    <ul>
        <li><strong>Empresa:</strong> SISTEMA COBRANZAS</li>
        <li><strong>Identificación:</strong> 1o2321042104</li>
        <li><strong>Correo de autorespuesta:</strong> sistemacobranzas@gmail.com</li>
    </ul>

    <h3>Información del Documento</h3>
    <ul>
        <li><strong>Fecha:</strong> {{$data->fecha}}</li>
        <li><strong>Tipo:</strong> {{$data->tipo}}</li>
        <li><strong>Número:</strong> {{$data->numero}}</li>
        <li><strong>Moneda:</strong> {{$data->tipo_moneda}}</li>
        <li><strong>Valor Total:</strong> {{$data->valor_total}}</li>
    </ul>

    <p><a href="#">Clic aquí para información adicional</a></p>

    <p>Adjunto encontrará la representación gráfica del documento en formato PDF y el documento electrónico en formato XML.</p>

    <!-- Puedes agregar aquí cualquier otro contenido o estilos necesarios -->

</body>
</html>
