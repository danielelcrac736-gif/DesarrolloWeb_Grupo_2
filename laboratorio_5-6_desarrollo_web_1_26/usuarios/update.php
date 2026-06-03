<?php
header('Content-Type: application/json');

if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['carnet'])) {
    $id = (int)$_POST['id'];
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
    
    $check = $con->prepare("SELECT id FROM usuarios WHERE carnet = ? AND id != ?");
    $check->bind_param("si", $carnet, $id);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        echo json_encode(["status" => "error", "mensaje" => "El carnet ya está registrado por otro usuario"]);
        $check->close();
        $con->close();
        exit();
    }
    $check->close();
    
    $sql = "UPDATE usuarios SET nombre = ?, carnet = ?, telefono = ?, correo = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssi", $nombre, $carnet, $telefono, $correo, $id);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "ok", "mensaje" => "Usuario actualizado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "mensaje" => "Error al actualizar el usuario"]);
    }
    
    $stmt->close();
    $con->close();
} else {
    echo json_encode(["status" => "error", "mensaje" => "Datos incompletos"]);
}
?>