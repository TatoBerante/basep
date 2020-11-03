<?php
session_start();
date_default_timezone_set('Etc/GMT+3');

$error = 0;

$cxs = $_REQUEST;
$string = '';
foreach ($_REQUEST as $key => $value) {
  $data = explode ('_', $key);
  if ($data[0] == 'chkb') {
    $aceptar = $data[1];
    $string .= "&chkb_".$aceptar;
  }
  if ($data[0] != 'chkb' && $data[1] == $aceptar) {
    if ($data[0] == 'medico' && $value == '') {
      $error++;
    }
  }
}

if ($error > 0) {
  header ('location:../v/default.php?page=pnllq&return='.$_REQUEST['return'].'&errform=1&estado=1'.$string);
}
else {
  
  require_once "funcs/conn.php";
  require_once "funcs/utilities.php";

  $today = date('Y-m-d', time());

  $mysqli = mysqli_conn();
  if (!$mysqli) {
    header ('location:../v/default.php?page=pnllq&return='.$_REQUEST['return'].'&errform=2&estado=1');
  }

  foreach ($cxs as $key => $value) {
    $data = explode ('_', $key);
    if ($data[0] == 'chkb') {
      $aceptar = $data[1];
      //echo "<p>+------------ START SELECTED CX $aceptar ------------+</p>";
    }
    if ($data[0] != 'chkb' && $data[1] == $aceptar) {
      //echo "<p>";
      if ($data[0] == 'pagopr') {
        /*
        echo "ESTO ES UN PRODUCTO ($data[2]) ---> ";
        echo "Pagar producto $data[2] el valor de $value";
        */
        $sql = "UPDATE cirugias SET monto_a_pagar = ?, estado = ? WHERE id_cirugia_sys = ?";
        $estado = 2;
        $stmt = mysqli_stmt_init ($mysqli);
        if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
        mysqli_stmt_bind_param ($stmt, "dii", $value, $estado, $data[2]);
        if (!mysqli_stmt_execute ($stmt)) echo mysqli_error($mysqli);
        mysqli_stmt_close($stmt);
        $id_cx = $data[2];
      }
      else if ($data[0] == 'medico') {
        $sub = explode (' - ', $value);
        //echo "MEDICO ACREEDOR ID $sub[0]: $value";
        $id_medico = $sub[0];
      }
      else if ($data[0] == 'pagocc') {
        //echo "DESCUENTO A CC MEDICO: $value";
        if ($value > 0) {
          $sql = "UPDATE medicos SET saldo = (saldo - ?) WHERE id_medico_sys = ?";
          $stmt = mysqli_stmt_init ($mysqli);
          if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
          mysqli_stmt_bind_param ($stmt, "di", $value, $id_medico);
          if (!mysqli_stmt_execute ($stmt)) echo mysqli_error($mysqli);
          mysqli_stmt_close($stmt);
        }
        $ctacte = $value;
      }
      else if ($data[0] == 'pagocx') {
        //echo "REGISTRO PAGO TOTAL CX: $value";
        $sql = "INSERT INTO remitos (monto_total, monto_ctacte, id_acreedor, fecha_preparado) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_stmt_init ($mysqli);
        if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
        mysqli_stmt_bind_param ($stmt, "ddis", $value, $ctacte, $id_medico, $today);
        if (!mysqli_stmt_execute ($stmt)) echo mysqli_error($mysqli);
        mysqli_stmt_close($stmt);

        $id_remito =  mysqli_insert_id($mysqli);

        $sql = "UPDATE cirugias SET id_remito = ? WHERE nro_cirugia = ?";
        $stmt = mysqli_stmt_init ($mysqli);
        if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
        mysqli_stmt_bind_param ($stmt, "ii", $id_remito, $aceptar);
        if (!mysqli_stmt_execute ($stmt)) echo mysqli_error($mysqli);
        mysqli_stmt_close($stmt);
      }
    }
  }
  mysqli_close($mysqli);
  /*
  SELECT `id_cirugia_sys`, `fecha_cx`, `nro_cirugia`, CONCAT (`producto`, ': ', `descripcion`) AS producto, `monto_a_pagar`, `estado` FROM `cirugias` WHERE `nro_cirugia` IN ('00000013471', '00000013700') 
  */
  header ('location:../v/default.php?page=sccss&org=prep');
}
?>