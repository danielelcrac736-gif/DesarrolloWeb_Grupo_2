<?php
header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    include('../conexion.php');
    
    $check = $con->prepare("SELECT id_libro FROM prestamos WHERE id = ? AND estado = 'Activo'");
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result();
    
    if ($result->num_rows == 0) {
        echo json_encode(["status" => "error", "mensaje" => "Préstamo no encontrado o ya fue devuelto"]);
        $check->close();
        $con->close();
        exit();
    }
    
    $prestamo = $result->fetch_assoc();
    $id_libro = $prestamo['id_libro'];
    $check->close();
    
    $con->begin_transaction();
    
    try {
        $update = $con->prepare("UPDATE prestamos SET estado = 'Devuelto', fecha_devolucion = CURDATE() WHERE id = ?");
        $update->bind_param("i", $id);
        
        if (!$update->execute()) {
            throw new Exception("Error al actualizar préstamo");
        }
        
        $update_stock = $con->prepare("UPDATE libros SET stock = stock + 1 WHERE id = ?");
        $update_stock->bind_param("i", $id_libro);
        
        if (!$update_stock->execute()) {
            throw new Exception("Error al actualizar stock");
        }
        
        $con->commit();
        echo json_encode(["status" => "ok", "mensaje" => "Préstamo marcado como devuelto correctamente"]);
        
        $update->close();
        $update_stock->close();
    } catch (Exception $e) {
        $con->rollback();
        echo json_encode(["status" => "error", "mensaje" => $e->getMessage()]);
    }
    
    $con->close();
} else {
    echo json_encode(["status" => "error", "mensaje" => "ID no proporcionado"]);
}
?>