<?php

include '../funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$error = false;
$config = include '../config.php';

try {

  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  // Consulta SQL
  $consultaSQL = "SELECT
                 cabecera_orden_compra.ruc_prov,
                 COUNT(cabecera_orden_compra.nro_oc) AS cantidad_ordenes
                FROM cabecera_orden_compra
                WHERE cabecera_orden_compra.ruc_prov = '20604029768'
                GROUP BY cabecera_orden_compra.ruc_prov;";

  // Preparar y ejecutar la consulta
  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  // Obtener los resultados
  $resultados = $sentencia->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $error) {

  // Manejar errores de la base de datos
  echo "Error: " . $error->getMessage();

}

// Mostrar los resultados
if (isset($resultados) && count($resultados) > 0) {

  echo "<table border='1'>";
  echo "<tr>";
  echo "<th>RUC Proveedor</th>";
  echo "<th>Cantidad Órdenes</th>";
  echo "</tr>";

  foreach ($resultados as $fila) {

    echo "<tr>";
    echo "<td>" . $fila['ruc_prov'] . "</td>";
    echo "<td>" . $fila['cantidad_ordenes'] . "</td>";
    echo "</tr>";

  }

  echo "</table>";

} else {

  echo "<p>No hay resultados para mostrar.</p>";

}

?>
