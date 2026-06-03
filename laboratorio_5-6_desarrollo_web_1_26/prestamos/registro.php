<h2>Registrar Nuevo Préstamo</h2>

<?php
include('../conexion.php');

$sql_libros = "SELECT id, titulo, autor, stock FROM libros WHERE stock > 0 ORDER BY titulo";
$libros = mysqli_query($con, $sql_libros);

$sql_usuarios = "SELECT id, nombre, carnet FROM usuarios ORDER BY nombre";
$usuarios = mysqli_query($con, $sql_usuarios);
?>

<form id="forminsertar">
    <div>
        <label for="id_libro">Libro:</label>
        <select id="id_libro" name="id_libro" required>
            <option value="">Seleccione un libro</option>
            <?php while ($libro = mysqli_fetch_assoc($libros)) { ?>
                <option value="<?php echo $libro['id']; ?>">
                    <?php echo ($libro['titulo'] . " - " . $libro['autor'] . " (Stock: " . $libro['stock'] . ")"); ?>
                </option>
            <?php } ?>
        </select>
    </div>
    
    <div>
        <label for="id_usuario">Usuario:</label>
        <select id="id_usuario" name="id_usuario" required>
            <option value="">Seleccione un usuario</option>
            <?php while ($usuario = mysqli_fetch_assoc($usuarios)) { ?>
                <option value="<?php echo $usuario['id']; ?>">
                    <?php echo ($usuario['nombre'] . " - " . $usuario['carnet']); ?>
                </option>
            <?php } ?>
        </select>
    </div>
    
    <div>
        <label for="fecha_prestamo">Fecha de Préstamo:</label>
        <input type="date" id="fecha_prestamo" name="fecha_prestamo" value="<?php echo date('Y-m-d'); ?>" required>
    </div>
    
    <div>
        <label for="fecha_devolucion">Fecha de Devolución Esperada:</label>
        <input type="date" id="fecha_devolucion" name="fecha_devolucion" required>
    </div>
    
    <div>
        <label for="observaciones">Observaciones:</label>
        <textarea id="observaciones" name="observaciones" rows="3" style="width:100%; padding:8px;"></textarea>
    </div>
    
    <div>
        <input type="button" value="Registrar Préstamo" onclick="createPrestamo()">
        <input type="button" value="Cancelar" onclick="cargarContenido('prestamos/lista.php')" style="background-color: #6c757d;">
    </div>
</form>

<script>
var hoy = new Date();
var manana = new Date(hoy);
manana.setDate(hoy.getDate() + 1);
document.getElementById('fecha_devolucion').min = manana.toISOString().split('T')[0];
document.getElementById('fecha_devolucion').value = manana.toISOString().split('T')[0];
</script>

<?php
mysqli_close($con);
?>