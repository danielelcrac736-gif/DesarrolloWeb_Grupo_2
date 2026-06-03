<?php
header('Content-Type: application/json');

if (isset($_POST['id_libro']) && isset($_POST['id_usuario']) && isset($_POST['fecha_prestamo'])) {
    $id_libro = (int)$_POST['id_libro'];
    $id_usuario = (int)$_POST['id_usuario'];
    $fecha_prestamo = $_POST['fecha_prestamo'];
    $fecha_devolucion = $_POST['fecha_devolucion'] ?? null;
    $observaciones = trim($_POST['observaciones'] ?? '');
    
    if ($id_libro <= 0 || $id_usuario <= 0) {
        echo json_encode(["status" => "error", "mensaje" => "Seleccione libro y usuario válidos"]);
        exit();
    }
    
    include('../conexion.php');
    
    $check_stock = $con->prepare("SELECT stock FROM libros WHERE id = ?");
    $check_stock->bind_param("i", $id_libro);
    $check_stock->execute();
    $result = $check_stock->get_result();
    $libro = $result->fetch_assoc();
    
    if (!$libro || $libro['stock'] <= 0) {
        echo json_encode(["status" => "error", "mensaje" => "El libro no tiene stock disponible"]);
        $check_stock->close();
        $con->close();
        exit();
    }
    $check_stock->close();
    
    $con->begin_transaction();
    
    try {
        $sql = "INSERT INTO prestamos (id_libro, id_usuario, fecha_prestamo, fecha_devolucion, observaciones, estado) 
                VALUES (?, ?, ?, ?, ?, 'Activo')";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iisss", $id_libro, $id_usuario, $fecha_prestamo, $fecha_devolucion, $observaciones);
        
        if (!$stmt->execute()) {
            throw new Exception("Error al registrar préstamo");
        }
        
        $update_stock = $con->prepare("UPDATE libros SET stock = stock - 1 WHERE id = ?");
        $update_stock->bind_param("i", $id_libro);
        
        if (!$update_stock->execute()) {
            throw new Exception("Error al actualizar stock");
        }
        
        $con->commit();
        echo json_encode(["status" => "ok", "mensaje" => "Préstamo registrado correctamente"]);
        
        $stmt->close();
        $update_stock->close();
    } catch (Exception $e) {
        $con->rollback();
        echo json_encode(["status" => "error", "mensaje" => $e->getMessage()]);
    }
    
    $con->close();
} else {
    echo json_encode(["status" => "error", "mensaje" => "Datos incompletos"]);
}
?>