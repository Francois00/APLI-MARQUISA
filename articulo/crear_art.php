<?php

include '../funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El articulo ' . escapar($_POST['nom']) . ' ha sido agregado con éxito'
  ];

  $config = include '../config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    $articulo = [
      "in_cod" => $_POST['cod'],
      "in_nom" => $_POST['nom'],
      "in_und" => $_POST['und'],
      "in_prec_uni" => $_POST["prec_uni"],
    ];

    $consultaSQL = "CALL sp_insertar_articulo(:in_cod, :in_nom, :in_und, :in_prec_uni)";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->bindParam(':in_cod', $articulo['in_cod'], PDO::PARAM_STR);
    $sentencia->bindParam(':in_nom', $articulo['in_nom'], PDO::PARAM_STR);
    $sentencia->bindParam(':in_und', $articulo['in_und'], PDO::PARAM_STR);
    $sentencia->bindParam(':in_prec_uni', $articulo['in_prec_uni'], PDO::PARAM_STR);


    $sentencia->execute($articulo);

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
      <h2 class="mt-4">Crea un articulo</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="nombre">Codigo</label>
          <input type="text" name="cod" id="cod" class="form-control">
        </div>
        <div class="form-group">
          <label for="apellido">Nombre </label>
          <input type="text" name="nom" id="nom" class="form-control">
        </div>
        <div class="form-group">
          <label for="email">Unidad</label>
          <input type="text" name="und" id="und" class="form-control">
        </div>
        <div class="form-group">
          <label for="email">Precio Unitario</label>
          <input type="text" name="prec_uni" id="prec_uni" class="form-control">
        </div>
        <div class="form-group">
          <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href=" index_art.php">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include '../templates/footer.php'; ?>