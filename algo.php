<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_emision = $_POST["fecha_emision"];
    $monto = $_POST["monto"];

    // Calcula la fecha de vencimiento (30 días después de la fecha de emisión)
    $fecha_vencimiento = date('Y-m-d', strtotime($fecha_emision . ' + 30 days'));

    // Guarda la factura en la base de datos
    $conexion = new mysqli("localhost", "usuario", "contrasena", "facturas");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "INSERT INTO facturas (fecha_emision, monto, fecha_vencimiento) VALUES ('$fecha_emision', $monto, '$fecha_vencimiento')";

    if ($conexion->query($sql) === TRUE) {
        echo "Factura guardada con éxito.<br>";
    } else {
        echo "Error al guardar la factura: " . $conexion->error . "<br>";
    }

    // Calcular intereses para facturas vencidas
    $hoy = date('Y-m-d');
    $sql = "SELECT id, fecha_vencimiento FROM facturas WHERE fecha_vencimiento < '$hoy'";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $factura_id = $row["id"];
            $fecha_vencimiento = $row["fecha_vencimiento"];
            
            // Calcula los días de retraso
            $fecha_actual = new DateTime($hoy);
            $fecha_vencimiento = new DateTime($fecha_vencimiento);
            $dias_retraso = $fecha_actual->diff($fecha_vencimiento)->days;

            // Calcula los intereses según la lógica que mencionaste
            $interes = calcularInteres($dias_retraso);

            // Actualiza la factura con los intereses
            $sql = "UPDATE facturas SET interes = $interes WHERE id = $factura_id";
            $conexion->query($sql);
        }
    }

    $conexion->close();
}

// Función para calcular intereses según la lógica que mencionaste
function calcularInteres($dias_retraso) {
    // Implementa la lógica de cálculo de intereses aquí
    // Por ejemplo, puedes usar una estructura condicional para definir las tasas de interés según los días de retraso.
    // Luego, calcula el interés según el monto de la factura y la tasa aplicable.
    // Finalmente, devuelve el interés calculado.

    // Ejemplo:
    if ($dias_retraso == 1) {
        $tasa_interes = 0.05; // 5% para 1 día de retraso
    } elseif ($dias_retraso >= 2 && $dias_retraso <= 4) {
        $tasa_interes = 0.07; // 7% para 2 a 4 días de retraso
    } else {
        $tasa_interes = 0.1; // 10% para más de 4 días de retraso
    }

    $monto_factura = /* Obtén el monto de la factura desde la base de datos */;
    $interes = $monto_factura * $tasa_interes;

    return $interes;
}
?>
