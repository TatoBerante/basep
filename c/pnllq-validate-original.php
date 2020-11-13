<?php
session_start();
date_default_timezone_set('Etc/GMT+3');
// Validaciones

$data = explode (' - ', $_REQUEST['medico']);
$id_medico = $data[0];
$pago = trim ($_REQUEST['pago']);
$descuento = ($_REQUEST['pagocc'] == '') ? '0' : trim($_REQUEST['pagocc']);
$today = date('Y-m-d', time());

if ($_REQUEST['estado'] == 'pendiente' && ($_REQUEST['medico'] == '' || $pago == '' || !is_numeric($pago) || count ($data) < 2)) {
  header ('location:../v/default.php?page=pnllq'.$_REQUEST['valstring'].'&errform=1&estado='.$_REQUEST['estado']);
}
else {
  require_once "funcs/conn.php";
  require_once "funcs/utilities.php";

  if ($_REQUEST['estado'] == 'pendiente') {

    /*
    SI SE PROCESAN PENDIENTES:
    ==========================
    1. Registrar liquidación en tabla remitos y obtener id_remito.
    2. Cambiar estado lógico de cada cx a 2 (1:pendiente, 2:preparada, 3:liquidada).
    */
    
    
    $mysqli = mysqli_conn();
    
    if (!$mysqli) {
      header ('location:../v/default.php?page=pnllq'.$_REQUEST['valstring'].'&errform=2&estado='.$_REQUEST['estado']);
    }
    else {
      // 1.
      $sql = "INSERT INTO remitos (monto_total, monto_ctacte, id_acreedor, fecha_preparado) VALUES (?, ?, ?, ?)";
      $stmt = mysqli_stmt_init ($mysqli);
      
      if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
      else {
        mysqli_stmt_bind_param ($stmt, "ddis", $pago, $descuento, $id_medico, $today);
        if (!mysqli_stmt_execute ($stmt)) echo mysqli_error($mysqli);
        mysqli_stmt_close($stmt);
        
        $id_remito =  mysqli_insert_id($mysqli);
        
        // 2.
        $cxs = array();
        foreach ($_REQUEST as $key=>$value) {
          $data = explode ('_', $key);
          if ($data[0] == 'cx') {
            $cxs[] = $data[1];
          }
        }
        foreach ($cxs as $cx) {
          $sql = "UPDATE cirugias SET estado = ?, id_remito = ? WHERE nro_cirugia = ?";
          $stmt = mysqli_stmt_init ($mysqli);
          if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
          else {
            echo $cx."<br>";
            $nestado = 2;
            if (!mysqli_stmt_bind_param ($stmt, "iis", $nestado, $id_remito, $cx)) echo "ERROR";
            if (!mysqli_stmt_execute ($stmt)) echo mysqli_error($mysqli);
            mysqli_stmt_close($stmt);
          }
        }
        mysqli_close($mysqli);
        header ('location:../v/default.php?page=sccss&org=prep');
      }
    }
  }
  else if ($_REQUEST['estado'] == 'preparada') {
    /*SI SE PROCESAN PREPARADAS:
    ============================
    1. Cambiar estado lógico de cada cx a 3 (1:pendiente, 2:preparada, 3:liquidada).
    NO (el descuento se efectúa al momento de preparar) 2. Actualizar saldo en tabla medicos.
    */

    // 1.
    $rems = array();
    foreach ($_REQUEST as $key=>$value) {
      $data = explode ('_', $key);
      if ($data[0] == 'rem') {
        $rems[] = $data[1];
      }
    }
    foreach ($rems as $rem) {
      $mysqli = mysqli_conn();
      if (!$mysqli) {
        header ('location:../v/default.php?page=pnllq'.$_REQUEST['valstring'].'&errform=2&estado='.$_REQUEST['estado']);
      }
      else {
        $nestado = 3;
        $sql = "UPDATE cirugias cx, remitos rem
                SET cx.estado = ?, rem.fecha_liquidado = ?
                WHERE cx.id_remito = ? AND rem.id_remito = ?";
        $stmt = mysqli_stmt_init ($mysqli);
        if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
        else {
          mysqli_stmt_bind_param ($stmt, "isii", $nestado, $today, $rem, $rem);
          if (!mysqli_stmt_execute ($stmt)) echo mysqli_error($mysqli);
          mysqli_stmt_close($stmt);
          // 2.
          /*
          $remito = data_remito ($rem);
          if ($remito['monto_ctacte'] > 0) {
            $sql = "UPDATE medicos SET saldo = (saldo - ?) WHERE id_medico_sys = ?";
            $stmt = mysqli_stmt_init ($mysqli);
            if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
            else {
              mysqli_stmt_bind_param ($stmt, "di", $remito['monto_ctacte'], $remito['id_medico_sys']);
              if (!mysqli_stmt_execute ($stmt)) echo mysqli_error($mysqli);
              mysqli_stmt_close($stmt);
            }
          }
          */
        }
      }
    }
    mysqli_close($mysqli);
    header ('location:../v/default.php?page=sccss&org=liq');
  }
  else {
    header ('location:../v/default.php?page=pnllq'.$_REQUEST['valstring'].'&errform=3&estado='.$_REQUEST['estado']);
  }
  //echo "<p><a href='../v/default.php?page=pnlcx".$_REQUEST['return']."' class='buttons-warning'>VOLVER</a></p>";
}
?>