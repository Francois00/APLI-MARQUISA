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
  $consultaSQL = "SELECT c.nro_oc, cc.cod_art, a.nom AS nom_articulo, a.und, a.prec_uni, cc.subtotal_uni
                FROM cabecera_orden_compra c
                INNER JOIN cuerpo_orden_compra cc ON c.nro_oc = cc.nro_oc
                INNER JOIN articulo a ON cc.cod_art = a.cod
                ORDER BY c.nro_oc";

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
  echo "<th>Nro OC</th>";
  echo "<th>Cod Art</th>";
  echo "<th>Nom Articulo</th>";
  echo "<th>Und</th>";
  echo "<th>Prec Uni</th>";
  echo "<th>Subtotal Uni</th>";
  echo "</tr>";

  foreach ($resultados as $fila) {

    echo "<tr>";
    echo "<td>" . $fila['nro_oc'] . "</td>";
    echo "<td>" . $fila['cod_art'] . "</td>";
    echo "<td>" . $fila['nom_articulo'] . "</td>";
    echo "<td>" . $fila['und'] . "</td>";
    echo "<td>" . $fila['prec_uni'] . "</td>";
    echo "<td>" . $fila['subtotal_uni'] . "</td>";
    echo "</tr>";

  }

  echo "</table>";

} else {

  echo "<p>No hay resultados para mostrar.</p>";

}

?>
