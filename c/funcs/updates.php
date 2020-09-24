<?php
require_once "conn.php";

function updateClientes () {
  $mysqli = mysqli_conn();
  $txt_file = file_get_contents('../update-source/Clientes.csv');
  $rows = explode("\n", $txt_file);
  array_shift($rows); // Quita el primer valor del array (evita fila de nombres)
  $errors = 0;
  $new = 0;
  foreach($rows as $row => $data) {
    if ($row > 0) { // Evita la segunda línea (+-----+-----+)
      //get row data
      $row_data = explode('|', $data);
      if (count($row_data) > 1) {
        $empresa = trim ($row_data[1]);
        $id_cliente = trim ($row_data[2]);
        $cliente = trim ($row_data[3]);
        $tipo_cliente = trim ($row_data[4]);
        $condicion_pago = trim ($row_data[5]);
        $condicion = trim ($row_data[6]);

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
  // return rand (0, 3);
  $mysqli = mysqli_conn();
  $txt_file = file_get_contents('../update-source/Medicos.csv');
  $rows = explode("\n", $txt_file);
  array_shift($rows); // Quita el primer valor del array (evita fila de nombres)
  $errors = 0;
  $new = 0;
  foreach($rows as $row => $data) {
    if ($row > 0) { // Evita la segunda línea (+-----+-----+)
      //get row data
      $row_data = explode('|', $data);
      if (count($row_data) > 1) {
        $id_medico = trim ($row_data[0]);
        $medico = trim ($row_data[1]);

        $sql = "INSERT INTO medicos (id_medico, medico)
                  VALUES (?, ?)";
        $stmt = mysqli_stmt_init ($mysqli);
        if (!mysqli_stmt_prepare ($stmt, $sql)) {
            // error report:
            echo "<p>";
            print_r (mysqli_stmt_error($stmt));
            echo " Cliente (mysqli_stmt_prepare): ".$cliente."</p>*****";
            $errors++;
        }
        else {
          mysqli_stmt_bind_param ($stmt, "ss", $id_medico, $medico);
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
  mysqli_close($mysqli);
  return $new;
}
function updateVendedores () {
  $mysqli = mysqli_conn();
  $txt_file = file_get_contents('../update-source/Vendedores.csv');
  $rows = explode("\n", $txt_file);
  array_shift($rows); // Quita el primer valor del array (evita fila de nombres)
  $errors = 0;
  $new = 0;
  foreach($rows as $row => $data) {
    if ($row > 0) { // Evita la segunda línea (+-----+-----+)
      //get row data
      $row_data = explode('|', $data);
      if (count($row_data) > 1) {
        $id_vendedor = trim ($row_data[0]);
        $vendedor = trim ($row_data[1]);

        $sql = "INSERT INTO vendedores (id_vendedor, vendedor)
                  VALUES (?, ?)";
        $stmt = mysqli_stmt_init ($mysqli);
        if (!mysqli_stmt_prepare ($stmt, $sql)) {
            // error report:
            echo "<p>";
            print_r (mysqli_stmt_error($stmt));
            echo " Cliente (mysqli_stmt_prepare): ".$cliente."</p>*****";
            $errors++;
        }
        else {
          mysqli_stmt_bind_param ($stmt, "ss", $id_vendedor, $vendedor);
          if (mysqli_stmt_execute ($stmt)) {
            $new++;
            mysqli_stmt_close($stmt);
          }
          else {
            // error report (fallo por cliente ya registrado previamente):
            // echo "<p>Data:  ".$empresa." / ".$id_producro." / ".$descripcion.": ".mysqli_stmt_error($stmt)."</p>";
            $errors++;
            
          }
        }
      }
    }
  }
  mysqli_close($mysqli);
  return $new;
}
function updateProductos () {
  $mysqli = mysqli_conn();
  $txt_file = file_get_contents('../update-source/Productos.csv');
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
        $id_producto = trim ($row_data[1]);
        $descripcion = trim ($row_data[2]);

        $sql = "INSERT INTO productos (empresa, id_producto, descripcion)
                  VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init ($mysqli);
        if (!mysqli_stmt_prepare ($stmt, $sql)) {
            // error report:
            echo "<p>";
            print_r (mysqli_stmt_error($stmt));
            echo " Cliente (mysqli_stmt_prepare): ".$cliente."</p>*****";
            $errors++;
        }
        else {
          mysqli_stmt_bind_param ($stmt, "sss", $empresa, $id_producto, $descripcion);
          if (mysqli_stmt_execute ($stmt)) {
            $new++;
            mysqli_stmt_close($stmt);
          }
          else {
            // error report (fallo por cliente ya registrado previamente):
            // echo "<p>Data:  ".$empresa." / ".$id_producro." / ".$descripcion.": ".mysqli_stmt_error($stmt)."</p>";
            $errors++;
            
          }
        }
      }
    }
  }
  mysqli_close($mysqli);
  return $new;
}
function updateCirugias () {
  // Comercial_filtro_fechasPV+Recibo2
  $mysqli = mysqli_conn();
  $txt_file = file_get_contents('../update-source/Comercial_filtro_fechasPV+Recibo2.csv');
  $rows = explode("\n", $txt_file);
  array_shift($rows); // Quita el primer valor del array (evita fila de nombres)
  $errors = 0;
  $new = 0;
  foreach($rows as $row => $data) {
    if ($row > 0) { // Evita la segunda línea (+-----+-----+)
      //get row data
      $row_data = explode('|', $data);
      if (count($row_data) > 1) {
        $recno = trim ($row_data[0]);
        $filial = trim ($row_data[1]);
        $nro_presupuesto = trim ($row_data[2]);
        $orden_compra = trim ($row_data[3]);
        $fecha_pedido_venta = trim ($row_data[4]);
        $nro_pedido_de_venta = trim ($row_data[5]);
        $tipo_de_venta = trim ($row_data[6]);
        $fecha_cx = trim ($row_data[7]);
        $nro_cirugia = trim ($row_data[8]);
        $cod_medico = trim ($row_data[9]);
        $nombre_paciente = trim ($row_data[10]);
        $fecha_emision = trim ($row_data[11]);
        $comprobante = trim ($row_data[12]);
        $serie = trim ($row_data[13]);
        $cod_cliente = trim ($row_data[14]);
        $cod_institucion = trim ($row_data[15]);
        $cod_vendedor = trim ($row_data[16]);
        $nombre_vendedor = trim ($row_data[17]);
        $producto = trim ($row_data[18]);
        $descripcion = trim ($row_data[19]);
        $item = trim ($row_data[20]);
        $cantidad = trim ($row_data[21]);
        $precio_venta = trim ($row_data[22]);
        $valor_total1 = trim ($row_data[23]);
        $valor_total2 = trim ($row_data[24]);
        $serierecibo = trim ($row_data[25]);
        $recibo = trim ($row_data[26]);

        $sql = "INSERT INTO cirugias (recno, filial, nro_presupuesto, orden_compra, fecha_pedido_venta, nro_pedido_de_venta, tipo_de_venta, fecha_cx, nro_cirugia, cod_medico, nombre_paciente, fecha_emision, comprobante, serie, cod_cliente, cod_institucion, cod_vendedor, nombre_vendedor, producto, descripcion, item, cantidad, precio_venta, valor_total1, valor_total2, serierecibo, recibo)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init ($mysqli);
        if (!mysqli_stmt_prepare ($stmt, $sql)) {
            // error report:
            echo "<p>";
            print_r (mysqli_stmt_error($stmt));
            echo " Cliente (mysqli_stmt_prepare): ".$cliente."</p>*****";
            $errors++;
        }
        else {
          mysqli_stmt_bind_param ($stmt, "sssssssssssssssssssssssssss", $recno, $filial, $nro_presupuesto, $orden_compra, $fecha_pedido_venta, $nro_pedido_de_venta, $tipo_de_venta, $fecha_cx, $nro_cirugia, $cod_medico, $nombre_paciente, $fecha_emision, $comprobante, $serie, $cod_cliente, $cod_institucion, $cod_vendedor, $nombre_vendedor, $producto, $descripcion, $item, $cantidad, $precio_venta, $valor_total1, $valor_total2, $serierecibo, $recibo);
          if (mysqli_stmt_execute ($stmt)) {
            $new++;
            mysqli_stmt_close($stmt);
          }
          else {
            // error report (fallo por cliente ya registrado previamente):
            // echo "<p>Data:  ".$empresa." / ".$id_producro." / ".$descripcion.": ".mysqli_stmt_error($stmt)."</p>";
            $errors++;
            
          }
        }
      }
    }
  }
  mysqli_close($mysqli);
  return $new;
}
?>
