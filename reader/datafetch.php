<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Consolas;
    }
  </style>
  <title>Datafetch</title>
</head>
<body>
<?php
date_default_timezone_set('Etc/GMT+3');
include "DBconnect.php";
$txt_file = file_get_contents('clientes-local.csv');
$rows = explode("\n", $txt_file);
array_shift($rows); // Quita el primer valor del array (evita fila de nombres)
$errors = 0;
foreach($rows as $row => $data) {
  if ($row > 0) { // Evita la segunda línea (+-----+-----+)
    //get row data
    $row_data = explode('|', $data);
    if (count($row_data) > 1) {
      $empresa = trim ($row_data[0]);
      $id_cliente = trim ($row_data[1]);
      $cliente = trim ($row_data[2]);
      $tipo_cliente = trim ($row_data[3]);
      $condicion_pago = trim ($row_data[4]);
      $condicion = trim ($row_data[5]);

      $sql = "INSERT INTO clientes (id_cliente, empresa, cliente, tipo_cliente, condicion_pago, condicion)
                VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_stmt_init ($conn);
      if (!mysqli_stmt_prepare ($stmt, $sql)) {
          // error report:
          echo "<p>";
          print_r (mysqli_stmt_error($stmt));
          echo " Cliente (mysqli_stmt_prepare): ".$cliente."</p>*****";
          $errors++;
      }
      else {
        mysqli_stmt_bind_param ($stmt, "ssssss", $id_cliente, $empresa, $cliente, $tipo_cliente, $condicion_pago, $condicion);
        if (mysqli_stmt_execute ($stmt)) {
          mysqli_stmt_close($stmt);
        }
        else {
          // error report:
          echo "<p>";
          echo "<p>Cliente ".$cliente.": ".mysqli_stmt_error($stmt)."</p>";
          $errors++;
        }
      }
    }
  }
}
echo "<p>ERRORES: ".$errors."</p>";
mysqli_close($conn);
?>
</body>