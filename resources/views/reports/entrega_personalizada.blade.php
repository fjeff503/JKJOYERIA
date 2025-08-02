<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reporte Venta</title>
    <style>
        @page {
            margin: 10;
            /* Elimina todos los márgenes */
        }

        .cuerpo {
            height: 100%;
            width: 100%;
            border: solid 2px;
            font-size: 0.9em;
        }

        .titulo {
            align-items: center;
            text-align: center;
            font-size: 2em;
            margin: auto;
            padding: auto;
            height: 18%;
        }

        .tabla {
            border-collapse: collapse;
            width: 100%;
        }

        .clave {
            width: 25%;
            border: solid 1px;
            text-align: center;
        }

        .valor {
            width: 75%;
            border: solid 1px;
            text-align: center;
            white-space: nowrap;
            /* No hacer salto de línea */
            overflow: hidden;
            /* Oculta el contenido que se desborda */
            max-width: 100px;
        }

        .valor2 {
            width: 25%;
            border: solid 1px;
            text-align: center;

            white-space: nowrap;
            /* No hacer salto de línea */
            overflow: hidden;
            /* Oculta el contenido que se desborda */
            max-width: 100px;
        }

        td {
            padding: 2.3;
        }

        .direccion-alta {
            /* Ajusta según necesites */
            vertical-align: top;
            white-space: normal;
            /* para que el texto pueda hacer salto de línea */
        }
    </style>
</head>

<body class="cuerpo">
    <h2 class="titulo">JK Joyer&iacute;a</h2>
    <table class="tabla">
        <tr>
            <td class="clave"><strong>Cliente:</strong></td>
            <td class="valor" colspan="3">{{ $entrega->cliente ?? 'No definido' }}</td>
        </tr>
        <tr>
            <td class="clave"><strong>WhatsApp:</strong></td>
            <td class="valor" colspan="3">{{ $entrega->whatsapp ?? 'No definido' }}</td>
        </tr>
        <tr>
            <td class="clave"><strong>Direcci&oacute;n:</strong></td>
            <td class="valor direccion-alta" colspan="3">{{ $entrega->descripcion ?? 'No definido' }}</td>
        </tr>
        <tr>
            <td class="clave" rowspan="2"><strong>Total:</strong></td>
            <td class="valor2" rowspan="2">${{ number_format($entrega->total, 2) ?? 'No definido' }}</td>
            <td class="clave" colspan="2"><strong>Encomendista:</strong></td>
        </tr>
        <tr>
            <td class="valor" colspan="2">{{ $entrega->encomendista ?? 'No definido' }}</td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4">!Gracias por su compra!</td>
        </tr>
        <tr style="border-top: solid 1px; text-align: center;">
            <td colspan="4">!Escr&iacute;banos, ser&aacute; un gusto atenderle! &nbsp;&nbsp; 7128-1378</td>
        </tr>
    </table>
</body>

</html>
