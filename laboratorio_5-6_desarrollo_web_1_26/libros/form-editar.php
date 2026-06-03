<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    include('../conexion.php');
    
    $sql = "SELECT id, titulo, autor, isbn, categoria, stock FROM libros WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($libro = $resultado->fetch_assoc()) {
?>
        <h2>Editar Libro</h2>
        <form id="formeditar">
            <input type="hidden" name="id" value="<?php echo $libro['id']; ?>">
            
            <div>
                <label for="titulo">Título del Libro:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo ($libro['titulo']); ?>" required>
            </div>
            
            <div>
                <label for="autor">Autor:</label>
                <input type="text" id="autor" name="autor" value="<?php echo ($libro['autor']); ?>" required>
            </div>
            
            <div>
                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn" value="<?php echo ($libro['isbn']); ?>">
            </div>
            
            <div>
                <label for="categoria">Categoría:</label>
                <input type="text" id="categoria" name="categoria" value="<?php echo ($libro['categoria']); ?>">
            </div>
            
            <div>
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" value="<?php echo $libro['stock']; ?>" min="0" required>
            </div>
            
            <div>
                <input type="button" value="Actualizar Libro" onclick="updateLibro()">
                <input type="button" value="Cancelar" onclick="cargarContenido('libros/lista.php')" style="background-color: #6c757d;">
            </div>
        </form>
<?php
    } else {
        echo "<div class='mensaje error'>Libro no encontrado.</div>";
    }
    $stmt->close();
    $con->close();
} else {
    echo "<div class='mensaje error'>ID no proporcionado.</div>";
}
?>