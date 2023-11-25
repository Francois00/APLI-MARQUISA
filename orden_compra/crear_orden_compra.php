<?php

include '../funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'La orden de compra ' . escapar($_POST['nro_oc']) . ' ha sido agregada con éxito'
  ];

  $config = include '../config.php';

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
      "cod_mon" => $_POST['cod_mon'],
      "padrones" => $_POST['padrones'],
      "representante" => $_POST['representante'],
      "form_pago" => $_POST['form_pago'],
      "subtotal" => $_POST['subtotal'],
      "igv" => $_POST['igv'],
      "total" => $_POST['total'],
      "ret_tot" => $_POST['ret_tot'],
      "det_tot" => $_POST['det_tot'],
      "per_tot" => $_POST['per_tot'],
      "tot_giro" => $_POST['tot_giro'],
    ];

    $consultaSQL = "INSERT INTO cabecera_orden_compra (nro_oc, solic_por, autor_por, fec_emi, nota, obra, nro_req_ori, obs, ruc_prov, ruc_cli, cod_mon, padrones, representante, form_pago, subtotal, igv, total, ret_tot, det_tot, per_tot, tot_giro)";
    $consultaSQL .= "VALUES (:" . implode(", :", array_keys($ordenCompra)) . ")";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($ordenCompra);

  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
?>

<?php include '../templates/header.php'; ?>

<?php
if (isset($resultado)) {
  ?>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
          <?= $resultado['mensaje'] ?>
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
      <h2 class="mt-4">Crear Orden de Compra</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="nro_oc">Número de Orden de Compra</label>
          <input type="text" name="nro_oc" id="nro_oc" class="form-control">
        </div>
        <div class="form-group">
          <label for="solic_por">Solicitado por</label>
          <input type="text" name="solic_por" id="solic_por" class="form-control">
        </div>
        <div class="form-group">
          <label for="autor_por">Autorizado por</label>
          <input type="text" name="autor_por" id="autor_por" class="form-control">
        </div>
        <div class="form-group">
          <label for="fec_emi">Fecha de Emisión</label>
          <input type="date" name="fec_emi" id="fec_emi" class="form-control">
        </div>
        <div class="form-group">
          <label for="nota">Nota</label>
          <textarea name="nota" id="nota" class="form-control"></textarea>
        </div>
        <div class="form-group">
          <label for="obra">Obra</label>
          <input type="text" name="obra" id="obra" class="form-control">
        </div>
        <div class="form-group">
          <label for="nro_req_ori">Número de Requisición Original</label>
          <input type="text" name="nro_req_ori" id="nro_req_ori" class="form-control">
        </div>
        <div class="form-group">
          <label for="obs">Observaciones</label>
          <textarea name="obs" id="obs" class="form-control"></textarea>
        </div>
        <div class="form-group">
          <label for="ruc_prov">RUC del Proveedor</label>
          <input type="text" name="ruc_prov" id="ruc_prov" class="form-control">
        </div>
        <div class="form-group">
          <label for="ruc_cli">RUC del Cliente</label>
          <input type="text" name="ruc_cli" id="ruc_cli" class="form-control">
        </div>
        <div class="form-group">
          <label for="cod_mon">Código de Moneda</label>
          <input type="text" name="cod_mon" id="cod_mon" class="form-control">
        </div>
        <div class="form-group">
          <label for="padrones">Padrones</label>
          <input type="text" name="padrones" id="padrones" class="form-control">
        </div>
        <div class="form-group">
          <label for="representante">Representante</label>
          <input type="text" name="representante" id="representante" class="form-control">
        </div>
        <div class="form-group">
          <label for="form_pago">Forma de Pago</label <input type="text" name="form_pago" id="form_pago"
            class="form-control">
        </div>
        <div class="form-group">
          <label for="subtotal">Subtotal</label>
          <input type="text" name="subtotal" id="subtotal" class="form-control">
        </div>
        <div class="form-group">
          <label for="igv">IGV</label>
          <input type="text" name="igv" id="igv" class="form-control">
        </div>
        <div class="form-group">
          <label for="total">Total</label>
          <input type="text" name="total" id="total" class="form-control">
        </div>
        <div class="form-group">
          <label for="ret_tot">Retención Total</label>
          <input type="text" name="ret_tot" id="ret_tot" class="form-control">
        </div>
        <div class="form-group">
          <label for="det_tot">Detracción Total</label>
          <input type="text" name="det_tot" id="det_tot" class="form-control">
        </div>
        <div class="form-group">
          <label for="per_tot">Percepción Total</label>
          <input type="text" name="per_tot" id="per_tot" class="form-control">
        </div>
        <div class="form-group">
          <label for="tot_giro">Total a Girar</label>
          <input type="text" name="tot_giro" id="tot_giro" class="form-control">
        </div>
        <div class="form-group">
          <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="index_orden_compra.php">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include '../templates/footer.php'; ?>