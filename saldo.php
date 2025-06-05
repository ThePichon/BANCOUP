<?php
header("Content-Type: application/json");
$cuenta = $_GET["cuenta"] ?? null;

$conexion = new mysqli("localhost", "root", "", "proyecto_transferencia");

if (!$cuenta) {
  echo json_encode(["error" => "Falta número de cuenta"]);
  exit;
}

$result = $conexion->query("SELECT saldo FROM cuentas WHERE numero_cuenta = '$cuenta'");
if ($result->num_rows > 0) {
  $dato = $result->fetch_assoc();
  echo json_encode(["saldo" => $dato["saldo"]]);
} else {
  echo json_encode(["error" => "Cuenta no encontrada"]);
}
?>