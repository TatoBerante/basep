<?php
require_once "conn.php";

function updateClientes () {
  $mysqli = mysqli_conn();
  $txt_file = file_get_contents('../update-source/clientes.csv');
  $rows = explode("\n", $txt_file);
  array_shift($rows); // Quita el primer valor del array (evita fila de nombres)
  $errors = 0;
  $new = 0;
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
        $stmt = mysqli_stmt_init ($mysqli);
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
            $new++;
            mysqli_stmt_close($stmt);
          }
          else {
            // error report (fallo por cliente ya registrado previamente):
            /*
            echo "<p>";
            echo "<p>Cliente ".$cliente.": ".mysqli_stmt_error($stmt)."</p>";
            $errors++;
            */
          }
        }
      }
    }
  }
  //echo "<p>ERRORES: ".$errors."</p>";
  mysqli_close($mysqli);
  return $new;
}
function updateProfesionales () {
  return rand (0, 3);
}
function updateVendedores () {
  return rand (0, 3);
}
function updateCirugias () {
  return rand (0, 500);
}
?>