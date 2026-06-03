<?php
header('Content-Type: application/json');

if (isset($_POST['id']) && isset($_POST['titulo']) && isset($_POST['autor'])) {
    $id = (int)$_POST['id'];
    $titulo = trim($_POST['titulo']);
    $autor = trim($_POST['autor']);
    $isbn = trim($_POST['isbn'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $stock = (int)$_POST['stock'];

    if (empty($titulo) || empty($autor)) {
        echo json_encode(["status" => "error", "mensaje" => "Título y autor son obligatorios"]);
        exit();
    }
    
    if ($stock < 0) {
        echo json_encode(["status" => "error", "mensaje" => "El stock no puede ser negativo"]);
        exit();
    }

    include('../conexion.php');

    $sql = "UPDATE libros SET titulo = ?, autor = ?, isbn = ?, categoria = ?, stock = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssii", $titulo, $autor, $isbn, $categoria, $stock, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "ok", "mensaje" => "Libro actualizado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "mensaje" => "Error al actualizar el libro"]);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode(["status" => "error", "mensaje" => "Datos incompletos"]);
}
?>