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
                 cliente.nom_cli AS cliente_nombre,
                 cabecera_orden_compra.nro_oc,
                 cuerpo_orden_compra.cod_art,
                 articulo.nom AS articulo_nombre,
                 obra.nom AS obra_nombre
                FROM cliente
                JOIN cabecera_orden_compra ON cliente.ruc_cli = cabecera_orden_compra.ruc_cli
                JOIN cuerpo_orden_compra ON cabecera_orden_compra.nro_oc = cuerpo_orden_compra.nro_oc
                JOIN articulo ON cuerpo_orden_compra.cod_art = articulo.cod_art
                JOIN obra ON cabecera_orden_compra.cod_obra = obra.cod_obra
                ORDER BY cliente.nom_cli;";

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
  echo "<th>Obra</th>";
  echo "</tr>";

  foreach ($resultados as $fila) {

    echo "<tr>";
    echo "<td>" . $fila['cliente_nombre'] . "</td>";
    echo "<td>" . $fila['nro_oc'] . "</td>";
    echo "<td>" . $fila['cod_art'] . "</td>";
    echo "<td>" . $fila['articulo_nombre'] . "</td>";
    echo "<td>" . $fila['obra_nombre'] . "</td>";
    echo "</tr>";

  }

  echo "</table>";

} else {

  echo "<p>No hay resultados para mostrar.</p>";

}

?>
