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
  $consultaSQL = "SELECT p.nom AS nom_proveedor, a.nom AS nom_articulo
                FROM proveedor p
                JOIN cabecera_orden_compra cobra ON p.ruc = cobra.ruc_prov
                JOIN cuerpo_orden_compra coco ON cobra.nro_oc = coco.nro_oc
                JOIN articulo a ON coco.cod_art = a.cod
                ORDER BY p.nom, a.nom";

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
  echo "<th>Nombre Proveedor</th>";
  echo "<th>Nombre Articulo</th>";
  echo "</tr>";

  foreach ($resultados as $fila) {

    echo "<tr>";
    echo "<td>" . $fila['nom_proveedor'] . "</td>";
    echo "<td>" . $fila['nom_articulo'] . "</td>";
    echo "</tr>";

  }

  echo "</table>";

} else {

  echo "<p>No hay resultados para mostrar.</p>";

}

?>
