<?php
function conectar(){
    $host="localhost";
    $user="root";
    $pass="";
    $bd="facturas";

    $con=mysqli_connect($host,$user,$pass);

    mysqli_select_db($con,$bd);

    return $con;
}

function calcularInteres($dias_retraso) {
    $c = conectar();
    $sql = "SELECT * FROM interes";
    $query = mysqli_query($c, $sql);
    $tasa_interes = 0;
    while ($row = mysqli_fetch_assoc($query)) {
        if ($dias_retraso <= $row['int_dia1']) {
            $tasa_interes = 0;
            break;
        }elseif ($dias_retraso >= $row['int_dia1'] & $dias_retraso < $row['int_dia2']) {
            $tasa_interes = $row['int_1'];
            break;
        } elseif ($dias_retraso >= $row['int_dia2'] & $dias_retraso < $row['int_dia3']) {
            $tasa_interes = $row['int_2'];
            break;
        } else {
            $tasa_interes = $row['int_3'];
        }
    }
    return $tasa_interes;
}

function interes(){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dia1 = $_POST['dia1'];
        $dia2 = $_POST['dia2'];
        $dia3 = $_POST['dia3'];
        $int1= $_POST['int1'];
        $int2= $_POST['int2'];
        $int3= $_POST['int3'];

        $c=conectar();
        $sql = "UPDATE interes SET int_1 = $int1, int_dia1 = $dia1, int_2 = $int2, int_dia2 =$dia2, int_3 = $int3, int_dia3 = $dia3 WHERE int_id = 1;";
        $query=mysqli_query($c, $sql);
        return $query;
    }
}

function mostrar(){
    $c = conectar();
    $sql = "SELECT * FROM facturas;";
    $query = mysqli_query($c, $sql);
    return $query;
}
function mostrarInteres(){
    $c = conectar();
    $sql = "SELECT * FROM interes;";
    $query = mysqli_query($c, $sql);
    return $query;
}


function retraso($registro){
    $dia=date("Y-m-d");
    $hoy = strtotime($dia);
        
    $fecha_emision = strtotime($registro['fac_emision']);
    $fecha_vencimiento = strtotime($registro['fac_vencimiento']);
    $dias_retraso = round(($hoy - $fecha_vencimiento)  / 86400);
    return $dias_retraso;
    
}


function procesar(){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fecha_emision = $_POST["fecha_emision"];
        $monto = $_POST["monto"];

        $fecha_vencimiento = date('Y-m-d', strtotime($fecha_emision . ' + 30 days'));
     
        $c=conectar();
    
        $sql = "INSERT INTO facturas (fac_emision, fac_monto, fac_vencimiento) VALUES ('$fecha_emision', $monto, '$fecha_vencimiento')";
    
        $query=mysqli_query($c, $sql);
        return $query;
    }
}

?>
