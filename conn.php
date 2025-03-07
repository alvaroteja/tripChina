<?php
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'trips';

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        $conn->connect_error;
    }
    // echo 'Conectado a la Base de Datos!';
?>