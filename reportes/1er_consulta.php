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

  // Agregar la sentencia `SET NAMES utf8mb4` para asegurar que los datos se devuelvan en la codificación UTF-8.
  $conexion->exec("SET NAMES utf8mb4");

  // Consulta SQL
  $consultaSQL = "SELECT cabecera_orden_compra.obra, proveedor.nom, proveedor.dir
                    FROM cabecera_orden_compra
                    INNER JOIN proveedor ON cabecera_orden_compra.ruc_prov = proveedor.ruc
                    ORDER BY cabecera_orden_compra.obra;";

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

  // Agregar un encabezado a la tabla
  echo "<table border='1'><tr><th>Obra</th><th>Proveedor</th><th>Dirección</th></tr>";

  // Recorrer los resultados y mostrarlos en la tabla
  foreach ($resultados as $fila) {
    echo "<tr><td>" . $fila['obra'] . "</td><td>" . $fila['nom'] . "</td><td>" . $fila['dir'] . "</td></tr>";
  }

  // Cerrar la tabla
  echo "</table>";

} else {

  // Mostrar un mensaje si no hay resultados
  echo "<p>No hay resultados para mostrar.</p>";

}

?>
