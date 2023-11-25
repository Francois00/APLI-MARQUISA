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

  if (isset($_POST['ruc'])) {
    $consultaSQL = "SELECT * FROM proveedor WHERE ruc LIKE '%" . $_POST['ruc'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM proveedor";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $proveedor = $sentencia->fetchAll();

} catch (PDOException $error) {
  $error = $error->getMessage();
}

$titulo = isset($_POST['ruc']) ? 'Lista de proveedores (' . $_POST['ruc'] . ')' : 'Lista de proveedores';
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
            <th>RUC</th>
            <th>NOMBRE</th>
            <th>DIRECCION</th>
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
                <td>
                  <a href="<?= 'borrar_prov.php?ruc=' . escapar($fila["ruc"]) ?>">🗑️Borrar</a>
                  <a href="<?= 'editar_prov.php?ruc=' . escapar($fila["ruc"]) ?>">✏️Editar</a>
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