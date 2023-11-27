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
  cliente.nom AS cliente_nombre,
  cabecera_orden_compra.nro_oc,
  cuerpo_orden_compra.cod_art,
  articulo.nom AS articulo_nombre,
  cabecera_orden_compra.obra AS obra_nom
FROM cliente
JOIN cabecera_orden_compra ON cliente.ruc = cabecera_orden_compra.ruc_cli
JOIN cuerpo_orden_compra ON cabecera_orden_compra.nro_oc = cuerpo_orden_compra.nro_oc
JOIN articulo ON cuerpo_orden_compra.cod_art = articulo.cod
ORDER BY cliente.nom;
";

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
  echo "<th>Cliente</th>";
  echo "<th>Nro OC</th>";
  echo "<th>Cod Art</th>";
  echo "<th>Articulo</th>";
  echo "</tr>";

  foreach ($resultados as $fila) {

    echo "<tr>";
    echo "<td>" . $fila['cliente_nombre'] . "</td>";
    echo "<td>" . $fila['nro_oc'] . "</td>";
    echo "<td>" . $fila['cod_art'] . "</td>";
    echo "<td>" . $fila['articulo_nombre'] . "</td>";
    echo "</tr>";

  }

  echo "</table>";

} else {

  echo "<p>No hay resultados para mostrar.</p>";

}

?>