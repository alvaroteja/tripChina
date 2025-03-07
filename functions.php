<?php
function esNumeroPositivo($texto) {
    if (is_numeric($texto) && $texto >= 0) {
        return true;
    }
    return false;
}

function obtenerIva($tipo){
    $iva=0;
    switch ($tipo) {
        case 'Compras':
        $iva= IVA_BASE;
        break;
        case 'Alcohol':
        $iva= IVA_BASE*2;
        break;
        case 'Comida':
        $iva= IVA_BASE*0.5;
        break;
        case 'Gifts':
        $iva= IVA_BASE*0.25 ;
        break;
        default:
        $iva=0;
        break;
    }
    return $iva;

}
function redondearADosDecimales($texto) {

    $numero = floatval($texto);
    $numero_redondeado = round($numero, 2);

    if (floor($numero_redondeado) == $numero_redondeado) {
        return $numero_redondeado . '.00';
    }

    return number_format($numero_redondeado, 2, '.', '');
}

function convertirFecha($fecha) {
    // Crear un objeto DateTime a partir de la fecha dada
    $date = new DateTime($fecha);

    // Formatear la fecha al formato deseado: "d/m/Y h:i:s a"
    return $date->format('d/m/Y h:i:s a');
}

//Funciones para debug
function echoDebugInfo($message){
    if (DEBUGER_ON) {
        echo $message;
        echo "<br >";
    }
}
function printRDebug($var){
    if (DEBUGER_ON) {
        print_r($var);
        echo "<br >";
    }
}
function echoDebugError($error){
    if (DEBUGER_ON) {
        echo "Error!!!: ";
        echo $error;
        echo "<br >";
    }
}

// funciones para queries
function ejecutar_query($sql){
    include 'conn.php';
    if ($conn->query($sql) === TRUE) {
        return 'ok';
    } else {
        echoDebugError($conn->error);
    }
    $conn->close();
}
?>