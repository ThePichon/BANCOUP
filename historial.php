<?php
header("Content-Type: application/json");

$cuenta = $_GET["cuenta"] ?? null;

$conexion = new mysqli("localhost", "root", "", "proyecto_transferencia");

// Buscar ID de la cuenta
$res = $conexion->query("SELECT id FROM cuentas WHERE numero_cuenta = '$cuenta'");
if ($res->num_rows === 0) {
  echo json_encode(["error" => "Cuenta no encontrada"]);
  exit;
}
$cuenta_id = $res->fetch_assoc()["id"];

$query = "
SELECT 
  t.monto, 
  t.fecha_hora, 
  t.cuenta_remitente_id, 
  t.cuenta_destinataria_id,
  cr.numero_cuenta AS cuenta_origen,
  cd.numero_cuenta AS cuenta_destino
FROM 
  transferencias t
JOIN 
  cuentas cr ON t.cuenta_remitente_id = cr.id
JOIN 
  cuentas cd ON t.cuenta_destinataria_id = cd.id
WHERE 
  t.cuenta_remitente_id = $cuenta_id OR t.cuenta_destinataria_id = $cuenta_id
ORDER BY 
  t.fecha_hora DESC
";

$res = $conexion->query($query);
$movs = [];

while ($row = $res->fetch_assoc()) {
  $movs[] = $row;
}

echo json_encode($movs);
?>
