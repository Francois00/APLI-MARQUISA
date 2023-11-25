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

  if (isset($_POST['cod'])) {
    $consultaSQL = "SELECT * FROM moneda WHERE cod LIKE '%" . $_POST['cod'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM moneda";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $moneda = $sentencia->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = isset($_POST['cod']) ? 'Lista de monedaes (' . $_POST['cod'] . ')' : 'Lista de moneda es';
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
      <a href="crear_mon.php"  class="btn btn-primary mt-4">Crear moneda</a>
      <hr>
      <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input type="text" id="cod" name="cod" placeholder="Buscar por Codigo" class="form-control">
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
      <h2 class="mt-3"><?= $titulo ?></h2>
      <table class="table">
        <thead>
          <tr>
            <th>CODIGO</th>
            <th>NOMBRE</th>
            <th>TIPO</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($moneda && $sentencia->rowCount() > 0) {
            foreach ($moneda as $fila) {
              ?>
              <tr>
                <td><?php echo escapar($fila["cod"]); ?></td>
                <td><?php echo escapar($fila["nom"]); ?></td>
                <td><?php echo escapar($fila["tipo"]); ?></td>
                <td>
                  <a href="<?= 'borrar_mon.php?cod=' . escapar($fila["cod"]) ?>">🗑️Borrar</a>
                  <a href="<?= 'editar_mon.php?cod=' . escapar($fila["cod"]) ?>">✏️Editar</a>
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