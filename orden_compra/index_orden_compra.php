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

  if (isset($_POST['nro_oc'])) {
    $consultaSQL = "SELECT * FROM cabecera_orden_compra WHERE nro_oc LIKE '%" . $_POST['nro_oc'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM cabecera_orden_compra";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $ordenesCompra = $sentencia->fetchAll();

} catch (PDOException $error) {
  $error = $error->getMessage();
}

$titulo = isset($_POST['nro_oc']) ? 'Lista de Órdenes de Compra (' . $_POST['nro_oc'] . ')' : 'Lista de Órdenes de Compra';
?>

<?php include "../templates/header.php"; ?>

<?php
if ($error) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $error ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <a href="crear_orden_compra.php" class="btn btn-primary mt-4">Crear Orden de Compra</a>
      <hr>
      <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input type="text" id="nro_oc" name="nro_oc" placeholder="Buscar por Nro. de Orden de Compra"
            class="form-control">
        </div>
        <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
        <button type="submit" name="submit" class="btn btn-primary">Ver resultados</button>
      </form>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-3">
        <?= $titulo ?>
      </h2>
      <table class="table">
        <thead>
          <tr>
            <th>Nro. de Orden de Compra</th>
            <th>Solicitado por</th>
            <th>Autorizado por</th>
            <th>Fecha Emisión</th>
            <th>Obra</th>
            <th>Requerimiento Origen</th>
            <th>Cliente</th>
            <th>Proveedor</th>
            <th>Total Giro</th>
            <!-- Agrega más columnas según sea necesario -->
          </tr>
        </thead>
        <tbody>
          <?php
          if ($ordenesCompra && $sentencia->rowCount() > 0) {
            foreach ($ordenesCompra as $fila) {
              ?>
              <tr>
                <td>
                  <?php echo escapar($fila["nro_oc"]); ?>
                </td>
                <td>
                  <?php echo escapar($fila["solic_por"]); ?>
                </td>
                <td>
                  <?php echo escapar($fila["autor_por"]); ?>
                </td>
                <td>
                  <?php echo escapar($fila["fec_emi"]); ?>
                </td>
                <td>
                  <?php echo escapar($fila["obra"]); ?>
                </td>
                <td>
                  <?php echo escapar($fila["nro_req_ori"]); ?>
                </td>
                <td>
                  <?php echo escapar($fila["ruc_prov"]); ?>
                </td>
                <td>
                  <?php echo escapar($fila["ruc_cli"]); ?>
                </td>
                <td>
                  <?php echo escapar($fila["tot_giro"]); ?>
                </td>
                <!-- Agrega más celdas según sea necesario -->
                <td>
                  <a href="<?= 'borrar_orden_compra.php?nro_oc=' . escapar($fila["nro_oc"]) ?>">🗑️Borrar</a>
                  <a href="<?= 'editar_orden_compra.php?nro_oc=' . escapar($fila["nro_oc"]) ?>">✏️Editar</a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        <tbody>
      </table>
    </div>
  </div>
</div>

<?php include "../templates/footer.php"; ?>