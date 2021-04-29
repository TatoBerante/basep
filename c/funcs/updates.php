<?php
require_once "conn.php";

function updateClientes () {
  $mysqli = mysqli_conn();
  $txt_file = file_get_contents('../update-source/Clientes.csv');
  $rows = explode("\n", $txt_file);
  array_shift($rows); // Quita el primer valor del array (evita fila de nombres)
  $errors = 0;
  $new = 0;
  $mod = 0;
  foreach($rows as $row => $data) {
    if ($row > 0) { // Evita la segunda línea (+-----+-----+)
      //get row data
      $row_data = explode('|', $data);
      if (count($row_data) > 1) {
        $id_csv = trim ($row_data[0]);
        $empresa = trim ($row_data[1]);
        $id_cliente = trim ($row_data[2]);
        $cliente = trim ($row_data[3]);
        $tipo_cliente = trim ($row_data[4]);
        $condicion_pago = trim ($row_data[5]);
        $condicion = trim ($row_data[6]);

        // Verificar si existe el cliente:
        $q = "SELECT id_cliente_sys, cliente FROM clientes WHERE id_csv = '".$id_csv."'";
        //echo "<p>$q</p>";
        $r = mysqli_query($mysqli, $q);
        if (mysqli_num_rows ($r) < 1) { // El medico no existe en BD
          $sql = "INSERT INTO clientes (id_csv, id_cliente, empresa, cliente, tipo_cliente, condicion_pago, condicion)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
          $stmt = mysqli_stmt_init ($mysqli);
          if (!mysqli_stmt_prepare ($stmt, $sql)) {
              // error report:
              echo "<p>";
              print_r (mysqli_stmt_error($stmt));
              echo " Cliente (mysqli_stmt_prepare): ".$cliente."</p>*****";
              $errors++;
          }
          else {
            mysqli_stmt_bind_param ($stmt, "sssssss", $id_csv, $id_cliente, $empresa, $cliente, $tipo_cliente, $condicion_pago, $condicion);
            if (mysqli_stmt_execute ($stmt)) {
              $new++;
              mysqli_stmt_close($stmt);
            }
            else {
              $errors++;
            }
          }
        }
        else { // El cliente existe, revisar si se debe actualizar por edición en Totvs
          $w = mysqli_fetch_assoc($r);
          if ($w['cliente'] != $cliente) { // El cliente fue editado, actualizar
            $qup = "UPDATE clientes SET cliente = ? WHERE id_cliente_sys = ?";
            $stmt2 = mysqli_stmt_init ($mysqli);
            if (!mysqli_stmt_prepare ($stmt2, $qup)) {
              echo "<p>No se pudo preparar stmt (".$w['cliente']." por ".$cliente.")</p>";
              print_r (mysqli_stmt_error($stmt2));
              $errors++;
            }
            else {
              if (!mysqli_stmt_bind_param ($stmt2, "si", $cliente, $w['id_cliente_sys'])) echo "ERROR bind_param";
              if (!mysqli_stmt_execute ($stmt2)) echo "ERROR execute";
              $mod++;
              mysqli_stmt_close($stmt2);
            }
          }
          else {
            $errors++;
          }
        }
      }
    }
  }
  echo "<p>🔒 ".$errors." clientes omitidos.</p><p>✍🏼 ".$mod." clientes actualizados.</p>";
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
  $mod = 0;
  foreach($rows as $row => $data) {
    if ($row > 0) { // Evita la segunda línea (+-----+-----+)
      //get row data
      $row_data = explode('|', $data);
      if (count($row_data) > 1) {
        $id_medico = trim ($row_data[0]); // id del csv (unique en hm2, pero no primary [primary se autogenera])
        $medico = trim ($row_data[1]); // datos médico, pueden haber siodo editados en Totvs

        // Verificar si el médico ya existe en hm2:
        $q = "SELECT id_medico_sys, medico FROM medicos WHERE id_medico = '".$id_medico."'";
        //echo "<p>$q</p>";
        $r = mysqli_query($mysqli, $q);
        if (mysqli_num_rows ($r) < 1) { // El medico no existe en BD
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
              $errors++;
            }
          }
        }
        else { // El médico existe, revisar si se debe actualizar por edición en Totvs
          $w = mysqli_fetch_assoc($r);
          if ($w['medico'] != $medico) { // El medico fue editado, actualizar
            $qup = "UPDATE medicos SET medico = ? WHERE id_medico_sys = ?";
            $stmt2 = mysqli_stmt_init ($mysqli);
            if (!mysqli_stmt_prepare ($stmt2, $qup)) {
              echo "<p>No se pudo preparar stmt (".$w['medico']." por ".$medico.")</p>";
              print_r (mysqli_stmt_error($stmt2));
              $errors++;
            }
            else {
              if (!mysqli_stmt_bind_param ($stmt2, "si", $medico, $w['id_medico_sys'])) echo "ERROR bind_param";
              if (!mysqli_stmt_execute ($stmt2)) echo "ERROR execute";
              $mod++;
              mysqli_stmt_close($stmt2);
            }
          }
          else {
            $errors++;
          }
        }
      }
    }
  }
  echo "<p>🔒 ".$errors." médicos omitidos.</p><p>✍🏼 ".$mod." médicos actualizados.</p>";
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
  $mod = 0;
  foreach($rows as $row => $data) {
    if ($row > 0) { // Evita la segunda línea (+-----+-----+)
      //get row data
      $row_data = explode('|', $data);
      if (count($row_data) > 1) {
        $id_vendedor = trim ($row_data[0]);
        $vendedor = trim ($row_data[1]);

        // Verificar si el vendedor ya existe en hm2:
        $q = "SELECT id_vendedor_sys, vendedor FROM vendedores WHERE id_vendedor = '".$id_vendedor."'";
        //echo "<p>$q</p>";
        $r = mysqli_query($mysqli, $q);
        if (mysqli_num_rows ($r) < 1) { // El vendedor no existe en BD
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
              $errors++;
            }
          }
        }
        else { // El vendedor existe, revisar si se debe actualizar por edición en Totvs
          $w = mysqli_fetch_assoc($r);
          if ($w['vendedor'] != $vendedor) { // El vendedor fue editado, actualizar
            $qup = "UPDATE vendedores SET vendedor = ? WHERE id_vendedor_sys = ?";
            $stmt2 = mysqli_stmt_init ($mysqli);
            if (!mysqli_stmt_prepare ($stmt2, $qup)) {
              echo "<p>No se pudo preparar stmt (".$w['vendedor']." por ".$vendedor.")</p>";
              print_r (mysqli_stmt_error($stmt2));
              $errors++;
            }
            else {
              if (!mysqli_stmt_bind_param ($stmt2, "si", $vendedor, $w['id_vendedor_sys'])) echo "ERROR bind_param";
              if (!mysqli_stmt_execute ($stmt2)) echo "ERROR execute";
              $mod++;
              mysqli_stmt_close($stmt2);
            }
          }
          else {
            $errors++;
          }
        }
      }
    }
  }
  echo "<p>🔒 ".$errors." vendedores omitidos.</p><p>✍🏼 ".$mod." vendedores actualizados.</p>";
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
  echo "<p>🔒 ".$errors." productos omitidos.</p>";
  mysqli_close($mysqli);
  return $new;
}
function updateCirugias () {
  // Comercial_filtro_fechasPV+Recibo2
  $mysqli = mysqli_conn();
  $txt_file = file_get_contents('../update-source/Comercial_filtro_fechasPV+Recibo.csv');
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
        $id_cliente = trim ($row_data[14]);
        $cod_cliente = trim ($row_data[15]);
        $cod_institucion = trim ($row_data[16]);
        $cod_vendedor = trim ($row_data[17]);
        $nombre_vendedor = trim ($row_data[18]);
        $producto = trim ($row_data[19]);
        $descripcion = trim ($row_data[20]);
        $item = trim ($row_data[21]);
        $cantidad = trim ($row_data[22]);
        $precio_venta = trim ($row_data[23]);
        $valor_total = trim ($row_data[24]);
        $institucion = trim ($row_data[25]);

        /*
        0 R_E_C_N_O_
        1 filial
        2 nro_presupuesto
        3 orden_compra
        4 fecha_pedido_venta
        5 nro_pedido_de_Venta
        6 tipo_de_venta
        7 fecha_CIR
        8 nro_cirugia
        9 cod_medico
        10 nomnre_paciente
        11 fecha_emision
        12 comprobante
        13 serie
        14 id_cliente
        15 cod_cliente
        16 cod_institucion
        17 cod_vendedor
        18 nombre_vendedor
        19 producto
        20 descripcion
        21 item
        22 cantidad
        23 precio_venta
        24 valor_total
        25 institucion          
        */

        $sql = "INSERT INTO cirugias (recno, filial, nro_presupuesto, orden_compra, fecha_pedido_venta, nro_pedido_de_venta, tipo_de_venta, fecha_cx, nro_cirugia, cod_medico, nombre_paciente, fecha_emision, comprobante, serie, id_cliente, cod_cliente, cod_institucion, cod_vendedor, nombre_vendedor, producto, descripcion, item, cantidad, precio_venta, valor_total, institucion)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init ($mysqli);
        if (!mysqli_stmt_prepare ($stmt, $sql)) {
            // error report:
            echo "<p>";
            print_r (mysqli_stmt_error($stmt));
            echo " Cliente (mysqli_stmt_prepare): ".$cliente."</p>*****";
            $errors++;
        }
        else {
          mysqli_stmt_bind_param ($stmt, "ssssssssssssssssssssssssss", $recno, $filial, $nro_presupuesto, $orden_compra, $fecha_pedido_venta, $nro_pedido_de_venta, $tipo_de_venta, $fecha_cx, $nro_cirugia, $cod_medico, $nombre_paciente, $fecha_emision, $comprobante, $serie, $id_cliente, $cod_cliente, $cod_institucion, $cod_vendedor, $nombre_vendedor, $producto, $descripcion, $item, $cantidad, $precio_venta, $valor_total, $institucion);
          if (mysqli_stmt_execute ($stmt)) {
            $new++;
            mysqli_stmt_close($stmt);
          }
          else {
            // error report (fallo por cliente ya registrado previamente):
            /*
            echo "<p>Data:  [ recno ".$recno." ] ".$empresa." / ".$id_producro." / ".$descripcion.": ".mysqli_stmt_error($stmt).":<br>
            fecha_emision: ".$fecha_emision." /  ".trim ($row_data[11])."
            paciente: ".$nombre_paciente." /  ".trim ($row_data[10])."
            <hr></p>";
            */
            $errors++;
          }
        }
      }
    }
  }
  echo "<p>🔒 ".$errors." cirigías omitidas.</p>";
  mysqli_close($mysqli);
  return $new;
}
?>
