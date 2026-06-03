<h2>Listado de Usuarios</h2>

<?php
include('../conexion.php');
$sql = "SELECT id, nombre, carnet, telefono, correo FROM usuarios ORDER BY nombre";
$consulta = mysqli_query($con, $sql);

if (mysqli_num_rows($consulta) > 0) {
?>
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Carnet</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Operaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($usuario = mysqli_fetch_assoc($consulta)) { ?>
        <tr>
            <td><?php echo ($usuario['nombre']); ?></td>
            <td><?php echo ($usuario['carnet']); ?></td>
            <td><?php echo ($usuario['telefono']); ?></td>
            <td><?php echo ($usuario['correo']); ?></td>
            <td>
                <a href="javascript:cargarEditarUsuario(<?php echo $usuario['id']; ?>)" class="btn-editar">Editar</a>
                <a href="javascript:eliminarUsuario(<?php echo $usuario['id']; ?>)" class="btn-eliminar">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php
} else {
    echo "<p>No hay usuarios registrados actualmente.</p>";
}
$con->close();
?>