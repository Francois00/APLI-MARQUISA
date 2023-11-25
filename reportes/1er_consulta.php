<?php
try {
    // Configuración de la conexión a la base de datos
    $dsn = 'mysql:host=tu_host;dbname=orden_de_compra_marquisa';
    $usuario = 'tu_usuario';
    $contrasena = 'tu_contrasena';

    // Crear una nueva conexión PDO
    $conexion = new PDO($dsn, $usuario, $contrasena);

    // Configurar PDO para lanzar excepciones en caso de error
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL
    $consultaSQL = "SELECT cabecera_orden_compra.obra, proveedor.nom, proveedor.dir
                    FROM cabecera_orden_compra
                    INNER JOIN proveedor ON cabecera_orden_compra.ruc_prov = proveedor.ruc
                    ORDER BY cabecera_orden_compra.obra";

    // Preparar y ejecutar la consulta
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();

    // Obtener los resultados
    $resultados = $sentencia->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $error) {
    // Manejar errores de la base de datos
    echo "Error: " . $error->getMessage();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Obra con Proveedores</title>
</head>
<body>

    <h2>Consulta de Obra con Proveedores</h2>

    <?php if (isset($resultados) && count($resultados) > 0): ?>
        <table border="1">
            <tr>
                <th>Obra</th>
                <th>Proveedor</th>
                <th>Dirección del Proveedor</th>
            </tr>
            <?php foreach ($resultados as $fila): ?>
                <tr>
                    <td><?= $fila['obra'] ?></td>
                    <td><?= $fila['nom'] ?></td>
                    <td><?= $fila['dir'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay resultados para mostrar.</p>
    <?php endif; ?>

</body>
</html>
