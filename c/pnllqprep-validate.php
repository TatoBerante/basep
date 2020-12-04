<?php
session_start();
date_default_timezone_set('Etc/GMT+3');

$req = $_REQUEST;

// Recorrido de validaciones:
$cxsent = 0;
$haymedico = true;
$pagoccok = true;
foreach ($_REQUEST as $key => $value) {
  $data = explode ('_', $key);
  if ($data[0] == 'chkb') {
    $aceptar = $data[1];
    $string .= "&chkb_".$aceptar;
    //echo "<p>CX: $aceptar</p>";
    $return_string .= "&chkb_".$aceptar."=1";
    $cxsent++;
  }
  if ($data[0] != 'chkb' && $data[1] == $aceptar) {
    if ($data[0] == 'pagopr' && ($value == '' || !is_numeric($value))) {
      $error++;
    }
    //echo "PROD: $data[2] / Valor: $value<br>";
  }
  if ($data[0] == 'medico') {
    $datam = explode (' - ', $value);
    if (!is_numeric($datam[0])) $haymedico = false;
    else {
      $idmedico = $datam[0];
      //echo "MEDICO: $value (se usará ID $idmedico)<br>";
    }
  }
  else if ($data[0] == 'portador') {
    $id_portador = $value;
  }
  if ($data[0] == 'pagocc') {
    if (!is_numeric($value)) $pagoccok = false;
    else if ($value == '') $pagocc = 0;
    else {
      $pagocc = $value;
      //echo "PAGO CC: $value<br>";
    }
  }
}
// Fin recorrido validaciones

if ($cxsent < 1 || !$haymedico || !$pagoccok || $error > 0) {
  if ($cxsent < 1) $errortype = '2';
  else if (!$haymedico) $errortype = '3';
  else if (!$pagoccok) $errortype = '4';
  else if ($error > 0) $errortype = '5';
  else $errortype = '1';
  header ("location:../v/default.php?page=pnllq&return=".$_REQUEST['return']."&estado=1".$return_string.$_REQUEST['valstring']."&filters=".$_REQUEST['filters']."&error=".$errortype);
}
else {
  //echo "<p><a href='../v/default.php?page=pnllq&return=".$_REQUEST['return']."&estado=1".$return_string.$_REQUEST['valstring']."&filters=".$_REQUEST['filters']."'>VOLVER</a></p>";
  /*
  echo "<p><pre>";
  print_r ($req);
  echo "</pre></p>";
  */
  require_once "funcs/conn.php";
  require_once "funcs/utilities.php";

  $mysqli = mysqli_conn();
  if (!$mysqli) {
    header ('location:../v/default.php?page=pnllq&return='.$_REQUEST['return'].'&errform=2&estado=1');
  }
  else {
    $monto_total = 0;
    $today = date('Y-m-d', time());
    $lista_cxs_marcadas = array();
    foreach ($req as $key => $value) {
      $data = explode ('_', $key);
      if ($data[0] == 'chkb') {
        // Es dato de cx (nro_cirugia en tabla cirugias)
        $nro_cx = $data[1];
        $lista_cxs_marcadas[] = $nro_cx;
      }
      else if ($data[0] == 'pagopr' && $data[1] == $nro_cx) {
        // Es dato de producto (id_cirugia_sys en tabla cirugias) y el nro_cx fue marcado
        $id_cx = $data[2];
        $monto = $value;
        $sql = "UPDATE cirugias SET monto_a_pagar = ?, estado = ? WHERE id_cirugia_sys = ?";
        $estado = 2;
        $stmt = mysqli_stmt_init ($mysqli);
        if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
        mysqli_stmt_bind_param ($stmt, "dii", $monto, $estado, $id_cx);
        if (!mysqli_stmt_execute ($stmt)) echo mysqli_error($mysqli);
        mysqli_stmt_close($stmt);
        $monto_total += $monto;
      }
      else if ($data[0] == 'medico') {
        // Es el id_medico_sys en tabla medicos
        $sub = explode (' - ', $value);
        $id_medico = $sub[0];
      }
      else if ($data[0] == 'pagocc') {
        // Es el monto a descontar del saldo de cc del médico
        $ctacte = $value;
        // Habilitar lo siguiente si el descuento se debe efectivizar el momento de preparar:
        // Conservar saldo existente para remito:
        $qs = "SELECT saldo FROM medicos WHERE id_medico_sys = ".$id_medico;
        $rs = mysqli_query($mysqli , $qs);
        $rs = mysqli_fetch_assoc($rs);
        $saldo_pre = $rs['saldo'];
        if ($ctacte > 0) {
          $sql = "UPDATE medicos SET saldo = (saldo - ?) WHERE id_medico_sys = ?";
          $stmt = mysqli_stmt_init ($mysqli);
          if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
          mysqli_stmt_bind_param ($stmt, "di", $value, $id_medico);
          if (!mysqli_stmt_execute ($stmt)) echo mysqli_error($mysqli);
          mysqli_stmt_close($stmt);
        }
        
      }
    }
    $responsable = $_SESSION['basep']['uid'];
    if ($id_portador == 'N/A') {
      $sql = "INSERT INTO remitos (monto_total, monto_ctacte, id_acreedor, saldo_ctacte_previo, fecha_preparado, preparado_por) VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_stmt_init ($mysqli);
      if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
      mysqli_stmt_bind_param ($stmt, "ddidsi", $monto_total, $ctacte, $id_medico, $saldo_pre, $today, $responsable);
    }
    else {
      $sql = "INSERT INTO remitos (monto_total, monto_ctacte, id_acreedor, saldo_ctacte_previo, id_portador, fecha_preparado, preparado_por) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_stmt_init ($mysqli);
      if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
      mysqli_stmt_bind_param ($stmt, "ddidisi", $monto_total, $ctacte, $id_medico, $saldo_pre, $id_portador, $today, $responsable);
    }
    if (!mysqli_stmt_execute ($stmt)) echo mysqli_error($mysqli);
    mysqli_stmt_close($stmt);

    $id_remito =  mysqli_insert_id($mysqli);
    if ($id_remito == '') echo "error";

    foreach ($lista_cxs_marcadas as $cx) {
      $sql = "UPDATE cirugias SET id_remito = ? WHERE nro_cirugia = ?";
      $stmt = mysqli_stmt_init ($mysqli);
      if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
      mysqli_stmt_bind_param ($stmt, "ii", $id_remito, $cx);
      if (!mysqli_stmt_execute ($stmt)) echo mysqli_error($mysqli);
      mysqli_stmt_close($stmt);
    }
  }
  mysqli_close($mysqli);
  header ('location:../v/default.php?page=sccss&org=prep');
}
?>