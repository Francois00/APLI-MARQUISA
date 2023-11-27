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
                 cabecera_orden_compra.obra AS obra,
                 proveedor.nom AS proveedor,
                 cabecera_orden_compra.nro_oc,
                 articulo.nom AS articulo,
                 moneda.nom AS moneda,
                 cuerpo_orden_compra.subtotal_uni AS subtotal
                FROM cabecera_orden_compra
                JOIN proveedor ON cabecera_orden_compra.ruc_prov = proveedor.ruc
                JOIN cuerpo_orden_compra ON cabecera_orden_compra.nro_oc = cuerpo_orden_compra.nro_oc
                JOIN articulo ON cuerpo_orden_compra.cod_art = articulo.cod
                JOIN moneda ON cabecera_orden_compra.cod_mon = moneda.cod
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

  echo "<table border='1'>";
  echo "<tr>";
  echo "<th>Obra</th>";
  echo "<th>Proveedor</th>";
  echo "<th>Nro OC</th>";
  echo "<th>Articulo</th>";
  echo "<th>Moneda</th>";
  echo "<th>Subtotal</th>";
  echo "</tr>";

  foreach ($resultados as $fila) {

    echo "<tr>";
    echo "<td>" . $fila['obra'] . "</td>";
    echo "<td>" . $fila['proveedor'] . "</td>";
    echo "<td>" . $fila['nro_oc'] . "</td>";
    echo "<td>" . $fila['articulo'] . "</td>";
    echo "<td>" . $fila['moneda'] . "</td>";
    echo "<td>" . $fila['subtotal'] . "</td>";
    echo "</tr>";

  }

  echo "</table>";

} else {

  echo "<p>No hay resultados para mostrar.</p>";

}

?>
