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
      "nro_oc" => $_POST['nro_oc'],
      "solic_por" => $_POST['solic_por'],
      "autor_por" => $_POST['autor_por'],
      "fec_emi" => $_POST['fec_emi'],
      "nota" => $_POST['nota'],
      "obra" => $_POST['obra'],
      "nro_req_ori" => $_POST['nro_req_ori'],
      "obs" => $_POST['obs'],
      "ruc_prov" => $_POST['ruc_prov'],
      "ruc_cli" => $_POST['ruc_cli'],
      "cod_mon" => $_POST["cod_mon"],
      "padrones" => $_POST["padrones"],
      "representante" => $_POST["representante"],
      "form_pago" => $_POST["form_pago"],
      "subtotal" => $_POST["subtotal"],
      "igv" => $_POST["igv"],
      "total" => $_POST["total"],
      "ret_tot" => $_POST["ret_tot"],
      "det_tot" => $_POST["det_tot"],
      "per_tot" => $_POST["per_tot"],
      "tot_giro" => $_POST["tot_giro"]
    ];

    $consultaSQL = 'CALL sp_actualizar_cabecera_orden_compra(:nro_oc,:solic_por, :autor_por, :fec_emi ,
    :nota, :obra , :nro_req_ori ,
    :obs, :ruc_prov , :ruc_cli,
    :cod_mon, :padrones, :representante,
    :form_pago, :subtotal, :igv,
    :total, :ret_tot , :det_tot,
    :per_tot , :tot_giro)';
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
            <label for="solic_por">Solicitado por</label>
            <input type="text" name="solic_por" id="solic_por" value="<?= escapar($ordenCompra['solic_por']) ?>"
              class="form-control">
          </div>
          <div class="form-group">
            <label for="autor_por">Autorizado por</label>
            <input type="text" name="autor_por" id="autor_por" value="<?= escapar($ordenCompra['autor_por']) ?>"
              class="form-control">
          </div>
          <div class="form-group">
            <label for="fec_emi">Fecha de Emisión</label>
            <input type="date" name="fec_emi" id="fec_emi" value="<?= escapar($ordenCompra['fec_emi']) ?>"
              class="form-control">
          </div>
          <div class="form-group">
            <label for="nota">Nota</label>
            <textarea name="nota" id="nota" class="form-control"><?= escapar($ordenCompra['nota']) ?></textarea>
          </div>
          <div class="form-group">
            <label for="obra">Obra</label>
            <input type="text" name="obra" id="obra" value="<?= escapar($ordenCompra['obra']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="nro_req_ori">Número de Requisición Original</label>
            <input type="text" name="nro_req_ori" id="nro_req_ori" value="<?= escapar($ordenCompra['nro_req_ori']) ?>"
              class="form-control">
          </div>
          <div class="form-group">
            <label for="obs">Observaciones</label>
            <textarea name="obs" id="obs" class="form-control"><?= escapar($ordenCompra['obs']) ?></textarea>
          </div>
          <div class="form-group">
            <label for="ruc_prov">RUC del Proveedor</label>
            <input type="text" name="ruc_prov" id="ruc_prov" value="<?= escapar($ordenCompra['ruc_prov']) ?>"
              class="form-control">
          </div>
          <div class="form-group">
            <label for="ruc_cli">RUC del Cliente</label>
            <input type="text" name="ruc_cli" id="ruc_cli" value="<?= escapar($ordenCompra['ruc_cli']) ?>"
              class="form-control">
          </div>
          <div class="form-group">
            <label for="cod_mon">Código de Moneda</label>
            <input type="text" name="cod_mon" id="cod_mon" value="<?= escapar($ordenCompra['cod_mon']) ?>"
              class="form-control">
          </div>
          <div class="form-group">
            <label for="padrones">Padrones</label>
            <input type="text" name="padrones" id="padrones" value="<?= escapar($ordenCompra['padrones']) ?>"
              class="form-control">
          </div>
          <div class="form-group">
            <label for="representante">Representante</label>
            <input type="text" name="representante" id="representante"
              value="<?= escapar($ordenCompra['representante']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="form_pago">Forma de Pago</label>
            <input type="text" name="form_pago" id="form_pago" value="<?= escapar($ordenCompra['form_pago']) ?>"
              class="form-control">
          </div>
          <div class="form-group">
            <label for="subtotal">Subtotal</label>
            <input type="text" name="subtotal" id="subtotal" value="<?= escapar($ordenCompra['subtotal']) ?>"
              class="form-control">
          </div>
          <div class="form-group">
            <label for="igv">IGV</label>
            <input type="text" name="igv" id="igv" value="<?= escapar($ordenCompra['igv']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="ret_tot">Retención Total</label>
            <input type="text" name="ret_tot" id="ret_tot" value="<?= escapar($ordenCompra['ret_tot']) ?>"
              class="form-control">
          </div>
          <div class="form-group">
            <label for="det_tot">Detracción Total</label>
            <input type="text" name="det_tot" id="det_tot" value="<?= escapar($ordenCompra['det_tot']) ?>"
              class="form-control">
          </div>
          <div class="form-group">
            <label for="per_tot">Percepción Total</label>
            <input type="text" name="per_tot" id="per_tot" value="<?= escapar($ordenCompra['per_tot']) ?>"
              class="form-control">
          </div>

          <div class="form-group">
            <label for="total">Total</label>
            <input type="text" name="total" id="total" value="<?= escapar($ordenCompra['total']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="det_tot">Detracción Total</label>
            <input type="text" name="tot_giro" id="tot_giro" value="<?= escapar($ordenCompra['tot_giro']) ?>"
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