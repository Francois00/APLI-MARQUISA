<?php

// Configuración de la conexión a la base de datos
$dsn = 'mysql:host=tu_host;dbname=orden_de_compra_marquisa';
$usuario = 'tu_usuario';
$contrasena = 'tu_contrasena';

try {

  // Crear una nueva conexión PDO
  $conexion = new PDO($dsn, $usuario, $contrasena);

  // Configurar PDO para lanzar excepciones en caso de error
  $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Consulta SQL
  $consultaSQL = "SELECT
                 YEAR(cabecera_orden_compra.fec_emi) AS año,
                 COUNT(cabecera_orden_compra.nro_oc) AS cantidad_generada
                FROM cabecera_orden_compra
                WHERE YEAR(cabecera_orden_compra.fec_emi) = 2021
                GROUP BY YEAR(cabecera_orden_compra.fec_emi);";

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
  echo "<th>Año</th>";
  echo "<th>Cantidad Generada</th>";
  echo "</tr>";

  foreach ($resultados as $fila) {

    echo "<tr>";
    echo "<td>" . $fila['año'] . "</td>";
    echo "<td>" . $fila['cantidad_generada'] . "</td>";
    echo "</tr>";

  }

  echo "</table>";

} else {

  echo "<p>No hay resultados para mostrar.</p>";

}

?>
