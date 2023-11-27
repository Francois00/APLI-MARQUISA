<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

  <?php
  include("../templates/header.php");
  ?>

<ul class="btn-group" aria-label="Basic example" reversed>
    <a href="../reportes/1er_consulta.php" class="btn btn-primary" onclick="mostrarConsulta()">Obras/Proveedores</a>
    <a href="../reportes/2da_consulta.php" class="btn btn-primary">Articulos de Ordenes de compra</a>
    <a href="../reportes/3ra_consulta.php" class="btn btn-primary">Cliente/Obra/Proveedor</a>
    <a href="../reportes/4ta_consulta.php" class="btn btn-primary">Proveedor/Articulo</a>
    <a href="../reportes/5ta_consulta.php" class="btn btn-primary">OC/Moneda/Subtotal</a>
    <a href="../reportes/6ta_consulta.php" class="btn btn-primary">Obra/Proveedor/Num.OC/Articulo/Moneda/Subtotal</a>
    <a href="../reportes/7ma_consulta.php" class="btn btn-primary">Cliente/Num.OC/Cod.Artículo/Nom.Artículo/Obra</a>
    <a href="../reportes/8va_consulta.php" class="btn btn-primary">Año/Num.OC</a>
    <a href="../reportes/9na_consuñta.php" class="btn btn-primary">Ruc.Proveedor/Nom.Proveedor/Num.OC</a>
    <a href="../reportes/10ma_consulta.php" class="btn btn-primary">OC entre años</a>
  </ul>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script>
    function mostrarConsulta() {
      // Enviar una solicitud AJAX al servidor
      $.ajax({
        url: "obras-proveedores.php",
        type: "GET",
        success: function(data) {
          // Mostrar los resultados de la consulta
          $(data).appendTo("#contenido");
        }
      });
    }
  </script>

  <div id="contenido"></div>

</body>
</html>