<?php
session_start();
date_default_timezone_set('Etc/GMT+3');
// Validaciones

require_once "funcs/conn.php";
require_once "funcs/utilities.php";

$mysqli = mysqli_conn();
    
if (!$mysqli) {
  header ('location:../v/default.php?page=pnllq'.$_REQUEST['valstring'].'&errform=2&estado='.$_REQUEST['estado']);
}
else {
  $today = date('Y-m-d', time());
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
              SET cx.estado = ?, rem.fecha_liquidado = ?, rem.liquidado_por = ?
              WHERE cx.id_remito = ? AND rem.id_remito = ?";
      $stmt = mysqli_stmt_init ($mysqli);
      if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
      else {
        $responsable = $_SESSION['basep']['uid'];
        mysqli_stmt_bind_param ($stmt, "isiii", $nestado, $today, $responsable, $rem, $rem);
        if (!mysqli_stmt_execute ($stmt)) echo mysqli_error($mysqli);
        mysqli_stmt_close($stmt);
      }
    }
  }
  mysqli_close($mysqli);
  header ('location:../v/default.php?page=sccss&org=liq');
}