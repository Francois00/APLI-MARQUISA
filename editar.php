<?php
include '../funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$config = include '../config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['nro_oc'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'La Orden de Compra no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $ordenCompra = [
      "nro_oc" => $_GET['nro_oc'],
      "solic_por" => $_POST['solic_por'],
      "autor_por" => $_POST['autor_por'],
      "fec_emi" => $_POST['fec_emi'],
      // Agrega más campos según sea necesario
    ];

    $consultaSQL = "UPDATE cabecera_orden_compra SET
        solic_por = :solic_por,
        autor_por = :autor_por,
        fec_emi = :fec_emi,
        -- Agrega más campos según sea necesario
        updated_at = NOW()
        WHERE nro_oc = :nro_oc";
    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($ordenCompra);

  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $nro_oc = $_GET['nro_oc'];
  $consultaSQL = "SELECT * FROM cabecera_orden_compra WHERE nro_oc =" . $nro_oc;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $ordenCompra = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$ordenCompra) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado la Orden de Compra';
  }

} catch (PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "../templates/header.php"; ?>

<?php
if ($resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($_POST['submit']) && !$resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          La Orden de Compra ha sido actualizada correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($ordenCompra) && $ordenCompra) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando la Orden de Compra
          <?= escapar($ordenCompra['nro_oc']) . ' ' . escapar($ordenCompra['solic_por']) ?>
        </h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="solicitado_por">Solicitado por</label>
            <input type="text" name="solic_por" id="solicitado_por" value="<?= escapar($ordenCompra['solic_por']) ?>"
              class="form-control">
          </div>
          <div class="form-group">
            <label for="autorizado_por">Autorizado por</label>
            <input type="text" name="autor_por" id="autorizado_por" value="<?= escapar($ordenCompra['autor_por']) ?>"
              class="form-control">
          </div>
          <div class="form-group">
            <label for="fecha_emision">Fecha de Emisión</label>
            <input type="date" name="fec_emi" id="fecha_emision" value="<?= escapar($ordenCompra['fec_emi']) ?>"
              class="form-control">
          </div>
          <!-- Agrega más campos según sea necesario -->
          <div class="form-group">
            <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
            <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
            <a class="btn btn-primary" href="index_orden_compra.php">Regresar al inicio
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php require "../templates/footer.php"; ?>