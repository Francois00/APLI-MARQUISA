<?php

include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El proveedor ' . escapar($_POST['nom']) . ' ha sido agregado con éxito'
  ];

  $config = include 'config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $proveedor = [
      "ruc"   => $_POST['ruc'],
      "nom" => $_POST['nom'],
      "dir"    => $_POST['dir'],
    ];

    $consultaSQL = "INSERT INTO proveedor (ruc, nom, dir)";
    $consultaSQL .= "values (:" . implode(", :", array_keys($proveedor)) . ")";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($proveedor);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
?>

<?php include 'templates/header.php'; ?>

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
      <h2 class="mt-4">Crea un Proveedor</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="nombre">RUC</label>
          <input type="text" name="ruc" id="ruc" class="form-control">
        </div>
        <div class="form-group">
          <label for="apellido">Nombre y Apellido</label>
          <input type="text" name="nom" id="nom" class="form-control">
        </div>
        <div class="form-group">
          <label for="email">Direccion</label>
          <input type="text" name="dir" id="dir" class="form-control">
        </div>
                <div class="form-group">
          <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'templates/footer.php'; ?>