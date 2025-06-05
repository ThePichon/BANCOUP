<?php
header('Content-Type: application/json');
$conexion = new mysqli("localhost", "root", "", "proyecto_transferencia");

$data = json_decode(file_get_contents("php://input"), true);
$usuario = $data["email"] ?? null;
$password = $data["password"] ?? null;

if (!$usuario || !$password) {
  echo json_encode(["error" => "Faltan datos"]);
  exit;
}

$query = $conexion->prepare("SELECT * FROM usuarios WHERE email = ?");
$query->bind_param("s", $usuario);
$query->execute();
$resultado = $query->get_result();

if ($resultado->num_rows === 1) {
  $usuarioBD = $resultado->fetch_assoc();
  
  // Si la contraseña está sin encriptar, compara directo
  if ($usuarioBD["password"] === $password) {
    echo json_encode([
    "success" => true,
    "numero_cuenta" => $usuarioBD["numero_cuenta"]
]);

  } else {
    echo json_encode(["error" => "Contraseña incorrecta"]);
  }
} else {
  echo json_encode(["error" => "Usuario no encontrado"]);
}

$query->close();
$conexion->close();
?>
