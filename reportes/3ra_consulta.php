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
  $consultaSQL = "SELECT c.nom AS nom_cliente, cobra.obra, p.nom AS nom_proveedor
                FROM cliente c
                JOIN cabecera_orden_compra cobra ON c.ruc = cobra.ruc_cli
                JOIN proveedor p ON cobra.ruc_prov = p.ruc
                ORDER BY cobra.obra";

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
  echo "<th>Nombre Cliente</th>";
  echo "<th>Obra</th>";
  echo "<th>Nombre Proveedor</th>";
  echo "</tr>";

  foreach ($resultados as $fila) {

    echo "<tr>";
    echo "<td>" . $fila['nom_cliente'] . "</td>";
    echo "<td>" . $fila['obra'] . "</td>";
    echo "<td>" . $fila['nom_proveedor'] . "</td>";
    echo "</tr>";

  }

  echo "</table>";

} else {

  echo "<p>No hay resultados para mostrar.</p>";

}

?>
