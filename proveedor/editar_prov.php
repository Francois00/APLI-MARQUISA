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

if (!isset($_GET['ruc'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El proveedor no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $proveedor = [
      "ruc" => $_GET['ruc'],
      "nom" => $_POST['nom'],
      "dir" => $_POST['dir']
    ];

    $consultaSQL = "UPDATE proveedor SET
        nom = :nom,
        dir = :dir,
        updated_at = NOW()
        WHERE ruc = :ruc";
    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($proveedor);

  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $ruc = $_GET['ruc'];
  $consultaSQL = "SELECT * FROM proveedor WHERE ruc =" . $ruc;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $proveedor = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$proveedor) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el proveedor';
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
          El proveedor ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($proveedor) && $proveedor) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el proveedor
          <?= escapar($proveedor['ruc']) . ' ' . escapar($proveedor['nom']) ?>
        </h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="nombre">NOMBRE</label>
            <input type="text" name="nom" id="nombre" value="<?= escapar($proveedor['nom']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="direccion">DIRECCION</label>
            <input type="text" name="dir" id="direccion" value="<?= escapar($proveedor['dir']) ?>"
              class="form-control">
          </div>
          <div class="form-group">
            <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
            <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
            <a class="btn btn-primary" href="index_prov.php">Regresar al inicio</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php require "../templates/footer.php"; ?>