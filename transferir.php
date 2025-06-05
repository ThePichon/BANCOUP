<?php
// transferir.php
header('Content-Type: application/json');

// Configura tu conexión
$conexion = new mysqli("localhost", "root", "", "proyecto_transferencia");

// Leer el cuerpo del request
$data = json_decode(file_get_contents("php://input"), true);

$cuenta_origen = $data["cuenta_origen"];
$cuenta_destino = $data["cuenta_destino"];
$monto = $data["monto"];
$concepto = $data["concepto"];

// Validaciones básicas
if ($monto < 500) {
    echo json_encode(["error" => "Monto mínimo $500"]);
    exit;
}

if ($cuenta_origen === $cuenta_destino) {
    echo json_encode(["error" => "No puedes transferirte a ti mismo"]);
    exit;
}

// Consultar cuentas
$q1 = $conexion->query("SELECT * FROM cuentas WHERE numero_cuenta = '$cuenta_origen'");
$q2 = $conexion->query("SELECT * FROM cuentas WHERE numero_cuenta = '$cuenta_destino'");

if ($q1->num_rows === 0 || $q2->num_rows === 0) {
    echo json_encode(["error" => "Cuenta no encontrada"]);
    exit;
}

$origen = $q1->fetch_assoc();
$destino = $q2->fetch_assoc();

if ($origen["saldo"] < $monto) {
    $estatus = "Error";
    $descripcion = "Saldo insuficiente";
} else {
    $estatus = "Exitosa";
    $descripcion = "";
}

// Insertar transferencia
$conexion->query("INSERT INTO transferencias (
    cuenta_remitente_id, cuenta_destinataria_id, monto, concepto, estatus, descripcion, fecha_hora
) VALUES (
    {$origen['id']}, {$destino['id']}, $monto, '$concepto', '$estatus', '$descripcion', NOW()
)");

// Actualizar saldos si fue exitosa
if ($estatus === "Exitosa") {
    $conexion->query("UPDATE cuentas SET saldo = saldo - $monto WHERE id = {$origen['id']}");
    $conexion->query("UPDATE cuentas SET saldo = saldo + $monto WHERE id = {$destino['id']}");
    echo json_encode([
        "mensaje" => "Transferencia realizada con éxito",
        "origen" => [
            "cuenta" => $cuenta_origen,
            "antes" => $origen["saldo"],
            "despues" => $origen["saldo"] - $monto
        ],
        "destino" => [
            "cuenta" => $cuenta_destino,
            "antes" => $destino["saldo"],
            "despues" => $destino["saldo"] + $monto
        ]
    ]);
} else {
    echo json_encode(["error" => $descripcion]);
}
?>
