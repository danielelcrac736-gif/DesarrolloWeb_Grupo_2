<?php
header('Content-Type: application/json');

if (isset($_POST['titulo']) && isset($_POST['autor'])) {
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

    $sql = "INSERT INTO libros (titulo, autor, isbn, categoria, stock) VALUES (?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssi", $titulo, $autor, $isbn, $categoria, $stock);

    if ($stmt->execute()) {
        echo json_encode(["status" => "ok", "mensaje" => "Libro registrado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "mensaje" => "Error al registrar el libro"]);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode(["status" => "error", "mensaje" => "Datos incompletos"]);
}
?>