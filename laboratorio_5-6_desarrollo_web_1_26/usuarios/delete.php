<?php
header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    include('../conexion.php');
    
    $check = $con->prepare("SELECT id FROM prestamos WHERE id_usuario = ? AND estado = 'Activo'");
    $check->bind_param("i", $id);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        echo json_encode(["status" => "error", "mensaje" => "No se puede eliminar el usuario porque tiene préstamos activos"]);
        $check->close();
        $con->close();
        exit();
    }
    $check->close();
    
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "ok", "mensaje" => "Usuario eliminado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "mensaje" => "Error al eliminar el usuario"]);
    }
    
    $stmt->close();
    $con->close();
} else {
    echo json_encode(["status" => "error", "mensaje" => "ID no proporcionado"]);
}
?>