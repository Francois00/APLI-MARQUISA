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

if (!isset($_GET['cod'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El articulo no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $articulo = [
      "cod" => $_GET['cod'],
      "nom" => $_POST['nom'],
      "und" => $_POST['und'],
      "prec_uni" => $_POST['prec_uni']
    ];

    $consultaSQL = "CALL sp_actualizar articulo(:cod,
        und = :und,
        prec_uni = :prec_uni)";
    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($articulo);

  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $cod = $_GET['cod'];
  $consultaSQL = "SELECT * FROM articulo WHERE cod = :cod";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->bindParam(':cod', $cod, PDO::PARAM_STR);
  $sentencia->execute();

  $articulo = $sentencia->fetch(PDO::FETCH_ASSOC);


  if (!$articulo) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el articulo';
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
          El articulo ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($articulo) && $articulo) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el articulo
          <?= escapar($articulo['cod']) . ' ' . escapar($articulo['nom']) ?>
        </h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="nombre">NOMBRE</label>
            <input type="text" name="nom" id="nombre" value="<?= escapar($articulo['nom']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="undeccion">UNIDAD</label>
            <input type="text" name="und" id="und" value="<?= escapar($articulo['und']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="undeccion">PRECIO UNITARIO</label>
            <input type="text" name="prec_uni" id="prec_uni" value="<?= escapar($articulo['prec_uni']) ?>"
              class="form-control">
          </div>
          <div class="form-group">
            <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
            <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
            <a class="btn btn-primary" href="index_art.php">Regresar al inicio</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php require "../templates/footer.php"; ?>