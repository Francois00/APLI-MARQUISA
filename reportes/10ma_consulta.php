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
  $consultaSQL = "SELECT
                 COUNT(cabecera_orden_compra.nro_oc) AS cantidad_en_un_lapso_de_tiempo
                FROM cabecera_orden_compra
                WHERE cabecera_orden_compra.fec_emi BETWEEN '2019-01-01' AND '2021-01-01';";

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

  echo "<p>La cantidad de órdenes de compra en el periodo de 2019-01-01 a 2021-01-01 es: " . $resultados[0]['cantidad_en_un_lapso_de_tiempo'] . "</p>";

} else {

  echo "<p>No hay resultados para mostrar.</p>";

}

?>
<?php include "../templates/footer.php"; ?>