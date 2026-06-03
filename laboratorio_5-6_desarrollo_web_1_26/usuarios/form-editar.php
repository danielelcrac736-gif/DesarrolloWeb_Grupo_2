<?php
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    include('../conexion.php');
    
    $sql = "SELECT id, nombre, carnet, telefono, correo FROM usuarios WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($usuario = $resultado->fetch_assoc()) {
?>
        <h2>Editar Usuario</h2>
        <form id="formeditar">
            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
            
            <div>
                <label for="nombre">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo ($usuario['nombre']); ?>" required>
            </div>
            
            <div>
                <label for="carnet">Carnet / CI:</label>
                <input type="text" id="carnet" name="carnet" value="<?php echo ($usuario['carnet']); ?>" required>
            </div>
            
            <div>
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" value="<?php echo ($usuario['telefono']); ?>">
            </div>
            
            <div>
                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" value="<?php echo ($usuario['correo']); ?>">
            </div>
            
            <div>
                <input type="button" value="Actualizar Usuario" onclick="updateUsuario()">
                <input type="button" value="Cancelar" onclick="cargarContenido('usuarios/lista.php')" style="background-color: #6c757d;">
            </div>
        </form>
<?php
    } else {
        echo "<div class='mensaje error'>Usuario no encontrado</div>";
    }
    $stmt->close();
    $con->close();
} else {
    echo "<div class='mensaje error'>ID no proporcionado</div>";
}
?>