<?php include "../templates/header.php"; ?>
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
  $consultaSQL = "SELECT cabecera_orden_compra.nro_oc,
                 moneda.cod,
                 cuerpo_orden_compra.subtotal_uni
                FROM cabecera_orden_compra
                JOIN cuerpo_orden_compra ON cabecera_orden_compra.nro_oc = cuerpo_orden_compra.nro_oc
                JOIN moneda ON cabecera_orden_compra.cod_mon = moneda.cod
                ORDER BY cabecera_orden_compra.nro_oc;";

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
  echo "<th>Cod Moneda</th>";
  echo "<th>Subtotal</th>";
  echo "</tr>";

  foreach ($resultados as $fila) {

    echo "<tr>";
    echo "<td>" . $fila['nro_oc'] . "</td>";
    echo "<td>" . $fila['cod'] . "</td>";
    echo "<td>" . $fila['subtotal_uni'] . "</td>";
    echo "</tr>";

  }

  echo "</table>";

} else {

  echo "<p>No hay resultados para mostrar.</p>";

}

?>
<?php include "../templates/footer.php"; ?>