

?>
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

  

  $consultaSQL = "SELECT cabecera_orden_compra.obra, proveedor.nom, proveedor.dir
  FROM cabecera_orden_compra
  INNER JOIN proveedor ON cabecera_orden_compra.ruc_prov = proveedor.ruc
  ORDER BY cabecera_orden_compra.obra";

    // Preparar y ejecutar la consulta
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();

} catch (PDOException $error) {
  $error = $error->getMessage();
}
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
      <a href="crear_prov.php" class="btn btn-primary mt-4">Crear Proveedor</a>
      <hr>
      <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input type="text" id="ruc" name="ruc" placeholder="Buscar por RUC" class="form-control">
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
            <th>OBRA</th>
            <th>PROVEEDOR NOMBRE</th>
            <th>PROVEEDOR DIRECCION</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($proveedor && $sentencia->rowCount() > 0) {
            foreach ($proveedor as $fila) {
              ?>
              <tr>
                <td>
                  <?php echo escapar($fila["ruc"]); ?>
                </td>
                <td>
                  <?php echo escapar($fila["nom"]); ?>
                </td>
                <td>
                  <?php echo escapar($fila["dir"]); ?>
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