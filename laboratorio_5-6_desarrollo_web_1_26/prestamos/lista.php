<h2>Listado de Préstamos</h2>

<?php
include('../conexion.php');

$filtro_libro = $_GET['filtro_libro'] ?? '';
$filtro_usuario = $_GET['filtro_usuario'] ?? '';
$filtro_estado = $_GET['filtro_estado'] ?? '';

$where = [];
$params = [];
$types = "";

if (!empty($filtro_libro)) {
    $where[] = "l.titulo LIKE ?";
    $params[] = "%$filtro_libro%";
    $types .= "s";
}
if (!empty($filtro_usuario)) {
    $where[] = "u.nombre LIKE ?";
    $params[] = "%$filtro_usuario%";
    $types .= "s";
}
if (!empty($filtro_estado)) {
    $where[] = "p.estado = ?";
    $params[] = $filtro_estado;
    $types .= "s";
}

$where_clause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

$sql = "SELECT p.*, l.titulo AS libro_titulo, l.autor, u.nombre AS usuario_nombre, u.carnet 
        FROM prestamos p
        JOIN libros l ON p.id_libro = l.id
        JOIN usuarios u ON p.id_usuario = u.id
        $where_clause
        ORDER BY p.fecha_prestamo DESC";

$stmt = $con->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="filtros">
    <div>
        <label>Filtrar por Libro:</label>
        <input type="text" id="filtro_libro" placeholder="Buscar libro..." value="<?php echo ($filtro_libro); ?>">
    </div>
    <div>
        <label>Filtrar por Usuario:</label>
        <input type="text" id="filtro_usuario" placeholder="Buscar usuario..." value="<?php echo ($filtro_usuario); ?>">
    </div>
    <div>
        <label>Filtrar por Estado:</label>
        <select id="filtro_estado">
            <option value="">Todos</option>
            <option value="Activo" <?php echo $filtro_estado == 'Activo' ? 'selected' : ''; ?>>Activo</option>
            <option value="Devuelto" <?php echo $filtro_estado == 'Devuelto' ? 'selected' : ''; ?>>Devuelto</option>
            <option value="Vencido" <?php echo $filtro_estado == 'Vencido' ? 'selected' : ''; ?>>Vencido</option>
        </select>
    </div>
    <div>
        <button onclick="filtrarPrestamos()">Aplicar Filtros</button>
        <button onclick="cargarContenido('prestamos/lista.php')">Limpiar</button>
    </div>
</div>

<?php if ($result->num_rows > 0) { ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Libro</th>
                <th>Usuario</th>
                <th>Fecha Préstamo</th>
                <th>Fecha Devolución</th>
                <th>Estado</th>
                <th>Observaciones</th>
                <th>Operaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $hoy = date('Y-m-d');
            while ($prestamo = mysqli_fetch_assoc($result)) {
                $fecha_dev = $prestamo['fecha_devolucion'];
                $estado = $prestamo['estado'];
                $esVencido = ($estado == 'Activo' && $fecha_dev < $hoy);
                
                if ($esVencido) {
                    $update = $con->prepare("UPDATE prestamos SET estado = 'Vencido' WHERE id = ?");
                    $update->bind_param("i", $prestamo['id']);
                    $update->execute();
                    $update->close();
                    $estado = 'Vencido';
                }
                
                $clase_vencido = ($estado == 'Vencido') ? 'prestamo-vencido' : '';
            ?>
                <tr class="<?php echo $clase_vencido; ?>">
                    <td><?php echo $prestamo['id']; ?></td>
                    <td><?php echo ($prestamo['libro_titulo'] . " - " . $prestamo['autor']); ?></td>
                    <td><?php echo ($prestamo['usuario_nombre'] . " (" . $prestamo['carnet'] . ")"); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($prestamo['fecha_prestamo'])); ?></td>
                    <td><?php echo $fecha_dev ? date('d/m/Y', strtotime($fecha_dev)) : 'No definida'; ?></td>
                    <td class="estado-<?php echo strtolower($estado); ?>">
                        <?php
                        if ($estado == 'Activo') echo "Activo";
                        elseif ($estado == 'Devuelto') echo "Devuelto";
                        else echo "Vencido";
                        ?>
                    </td>
                    <td><?php echo ($prestamo['observaciones'] ?? '-'); ?></td>
                    <td>
                        <?php if ($estado == 'Activo') { ?>
                            <button class="btn-devolver" onclick="devolverPrestamo(<?php echo $prestamo['id']; ?>)">Marcar Devuelto</button>
                        <?php } else { ?>
                            <span style="color:#6c757d;">Completado</span>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <p>No hay préstamos registrados.</p>
<?php } ?>

<?php
$stmt->close();
$con->close();
?>