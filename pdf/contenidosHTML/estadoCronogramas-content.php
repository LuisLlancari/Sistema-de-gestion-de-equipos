<?php
date_default_timezone_set("America/Lima");

$dia = date("d/m/Y");
$hora = date("H:i");
?>
<page orientation="portrait" >
    <bookmark title="Document" level="0" ></bookmark>
    <a name="document_reprise"></a>
    <table cellspacing="0" style="width: 100%; margin: 3%;">
        <tr>
            <td style="width: 100%;">
                <img style="width: 90%" src="../images/banerRecortado.jpg" alt="reparacionBANNER" >
            </td>
        </tr>
        <tr>
            <td style="width: 100%; text-align: center; text-decoration: underline; font-weight: bold; font-size: 20pt">
                <span style="font-size: 10pt"><br></span>
                REPORTE DEL ESTADO DE LOS CRONOGRAMAS
            </td>
        </tr>
    </table>
    <table cellspacing="1" style="width: 100%; border: solid 2px #000000; ">
        <tr>
            <td style="width: 100%; font-size: 12pt;">
                <span style="font-size: 15pt; font-weight: bold;">Información<br></span>
                <br>
                Día: <?=$dia?><br>
                Apellidos y nombres : <?=$_SESSION["apellidos"]?>, <?=$_SESSION["nombres"]?><br>
                Cargo: <?=$_SESSION["rol"]?><br>
                Correo electrónico: <?=$_SESSION["email"]?><br>
                <br>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <table cellspacing="0" style="padding: 1px; width: 100%; border: solid 2px #000000; font-size: 11pt; ">
        <tr>
            <th style="width: 100%; text-align: center; border: solid 1px #000000;" colspan="2">
                Cronograma
            </th>
        </tr>
        <tr>
            <th style="width: 100%; text-align: center; border: solid 1px #000000;" colspan="2">
                Cronograma por estado
            </th>
        </tr>
        <tr>
            <th style="width: 30%; border: solid 1px #000000;text-align: center;">Cantidad</th>
            <th style="width: 70%; border: solid 1px #000000;">Estados</th>
        </tr>

    <?php foreach ($registros as $registro):?>
    <tr>
        <td style="width: 30%; border: solid 1px #000000; text-align: center;"><?=$registro["cantidad_tipo"]?></td>
        <td style="width: 70%; border: solid 1px #000000;"><?=$registro["estado"]?></td>
    </tr>
    <?php endforeach;?>

    </table>
    <br>
    <br>
    <table cellspacing="0" style="padding: 1px; width: 100%; border: solid 2px #000000; font-size: 11pt; ">
        <tr>
            <th style="width: 100%; text-align: center; border: solid 1px #000000;" colspan="5">
                Cronograma
            </th>
        </tr>
        <tr>
            <th style="width: 100%; text-align: center; border: solid 1px #000000;" colspan="5">
                Cronograma general
            </th>
        </tr>
        <tr>
            <th style="width: 20%; border: solid 1px #000000;">Nª de serie</th>
            <th style="width: 20%; border: solid 1px #000000;">Descripción</th>
            <th style="width: 25%; border: solid 1px #000000;">Categorías</th>
            <th style="width: 15%; border: solid 1px #000000;">Estado</th>
            <th style="width: 20%; border: solid 1px #000000;">Fecha programada</th>
        </tr>


        <?php foreach($cronogramas as $cronograma):?>
        <tr>
            <td style="width: 20%; border: solid 1px #000000;"><?=$cronograma["numero_serie"]?></td>
            <td style="width: 20%; border: solid 1px #000000;text-align: left; word-wrap: break-word"><?=$cronograma["modelo_equipo"]?></td>
            <td style="width: 25%; border: solid 1px #000000;"><?=$cronograma["tipo_mantenimiento"]?></td>
            <td style="width: 15%; border: solid 1px #000000;"><?=$cronograma["estado"]?></td>
            <td style="width: 20%; border: solid 1px #000000;"><?=$cronograma["fecha_programada"]?></td>
        </tr>
        <?php endforeach;?>
        <tr>
            <td style="width: 20%; border: solid 1px #000000;">&nbsp;</td>
            <td style="width: 20%; border: solid 1px #000000;">&nbsp;</td>
            <td style="width: 25%; border: solid 1px #000000;">&nbsp;</td>
            <td style="width: 15%; border: solid 1px #000000;">&nbsp;</td>
            <td style="width: 20%; border: solid 1px #000000;">&nbsp;</td>
        </tr>
    </table>
    <br>
    <br>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 8pt">
        <tr>
            <td style="width: 100%">
                <b><u>Estados de los equipos</u></b><br>
                1 - Activo<br>
                2 - Inactivo<br>
                3 - Mantenimiento<br>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <table cellspacing="0" style="width: 100%; border: solid 2px #000000; text-align: center; font-size: 10pt">
        <tr>
            <td style="width: 30%"></td>
            <td style="width: 40%">Desarrolladores</td>
            <td style="width: 30%"></td>
        </tr>
        <tr>
            <td style="width: 30%"><br><br>Adriana Arlet Durand Buenamarca</td>
            <td style="width: 30%"><br><br>Lucas Alfredo Atuncar Valerio</td>
            <td style="width: 30%"><br><br>Luis Miguel Llancari Vicerrel</td>
        </tr>
    </table>
    <br>
    <br>
    <table cellspacing="0" style="width: 100%; border: solid 2px #000000; text-align: left; font-size: 10pt">
        <tr>
            <th style="width: 30%;">
                Comentarios: <br>
                Respuestas: <br>
                &nbsp;<br>
                &nbsp;<br>
            </th>
            <td style="width: 70%;">
            </td>
        </tr>
    </table>
    <br>
    <br>
    <span style="font-size: 13pt"><b><u>Cualquier comentario es bien recibido para nuestra mejora</u></b></span>
</page>