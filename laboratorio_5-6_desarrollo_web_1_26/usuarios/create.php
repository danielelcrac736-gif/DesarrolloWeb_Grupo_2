<?php
header('Content-Type: application/json');

if (isset($_POST['nombre']) && isset($_POST['carnet'])) {
    $nombre = trim($_POST['nombre']);
    $carnet = trim($_POST['carnet']);
    $telefono = trim($_POST['telefono'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    
    if (empty($nombre) || empty($carnet)) {
        echo json_encode(["status" => "error", "mensaje" => "Nombre y Carnet son obligatorios"]);
        exit();
    }
    
    if (!empty($correo) && !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "mensaje" => "Correo electrónico no válido"]);
        exit();
    }
    
    include('../conexion.php');
    
    $check = $con->prepare("SELECT id FROM usuarios WHERE carnet = ?");
    $check->bind_param("s", $carnet);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        echo json_encode(["status" => "error", "mensaje" => "El carnet ya está registrado"]);
        $check->close();
        $con->close();
        exit();
    }
    $check->close();
    
    $sql = "INSERT INTO usuarios (nombre, carnet, telefono, correo) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $carnet, $telefono, $correo);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "ok", "mensaje" => "Usuario registrado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "mensaje" => "Error al registrar el usuario"]);
    }
    
    $stmt->close();
    $con->close();
} else {
    echo json_encode(["status" => "error", "mensaje" => "Datos incompletos"]);
}
?>