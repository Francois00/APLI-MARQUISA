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
  $consultaSQL = "CALL GetOrdenCompraProveedorInfo()";

  // Preparar y ejecutar la consulta
  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();


  // Obtener resultados
  $resultados = $sentencia->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $error) {
  $error = $error->getMessage();
}

// Mostrar los resultados
if (isset($resultados) && count($resultados) > 0) {
  echo "<table border='1'>";
  echo "<tr>";
  echo "<th>Obra</th>";
  echo "<th>Proveedor</th>";
  echo "<th>Dirección</th>";
  echo "</tr>";

  foreach ($resultados as $fila) {
    echo "<tr>";
    echo "<td>" . $fila['obra'] . "</td>";
    echo "<td>" . $fila['nom'] . "</td>";
    echo "<td>" . $fila['dir'] . "</td>";
    echo "</tr>";
  }

  echo "</table>";
} else {
  echo "<p>No hay resultados para mostrar.</p>";
}
?>
<?php include "../templates/footer.php"; ?>