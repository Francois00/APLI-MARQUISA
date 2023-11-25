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
  $resultado['mensaje'] = 'La moneda no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $moneda = [
      "cod" => $_GET['cod'],
      "nom" => $_POST['nom'],
      "tipo" => $_POST['tipo']
    ];

    $consultaSQL = "UPDATE moneda SET
        nom = :nom,
        tipo = :tipo,
        updated_at = NOW()
        WHERE cod = :cod";
    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($moneda);

  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $cod = $_GET['cod'];
  $consultaSQL = "SELECT * FROM moneda WHERE cod =" . $cod;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $moneda = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$moneda) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el moneda';
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
          La moneda ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($moneda) && $moneda) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando la moneda
          <?= escapar($moneda['cod']) . ' ' . escapar($moneda['nom']) ?>
        </h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="nombre">NOMBRE</label>
            <input type="text" name="nom" id="nombre" value="<?= escapar($moneda['nom']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="tipoeccion">TIPO DE MONEDA</label>
            <input type="text" name="tipo" id="tipo" value="<?= escapar($moneda['tipo']) ?>"
              class="form-control">
          </div>
          <div class="form-group">
            <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
            <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
            <a class="btn btn-primary" href="index_mon.php">Regresar al inicio</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php require "../templates/footer.php"; ?>