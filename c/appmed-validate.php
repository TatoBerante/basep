<?php
session_start();
date_default_timezone_set('Etc/GMT+3');
// Validaciones
$today = date('Y-m-d', time());
$monto = trim ($_REQUEST['monto']);
$desc = trim ($_REQUEST['desc']);

if ($monto == '' || !is_numeric ($monto) || $desc == '') {
  header ('location:../v/default.php?page=appmed&idm='.$_REQUEST['idm'].'&monto='.$monto.'&desc='.$desc.'&error=1');
}
else {
  require_once "funcs/conn.php";
  $mysqli = mysqli_conn();
  if (!$mysqli) {
    header ('location:../v/default.php?page=appmed&idm='.$_REQUEST['idm'].'&monto='.$monto.'&desc='.$desc.'&error=2');
  }
  else {
    $sql = "INSERT INTO regalias (id_medico_sys, fecha, descripcion, valor) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init ($mysqli);
    if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
    else {
      mysqli_stmt_bind_param ($stmt, "issd", $_REQUEST['idm'], $today, $desc, $monto);
      if (!mysqli_stmt_execute ($stmt)) echo mysqli_error($mysqli);
      mysqli_stmt_close($stmt);

      $id_regalia =  mysqli_insert_id($mysqli);

      // Actualizar saldo en tabla médicos:
      $sql = "UPDATE medicos SET saldo = (saldo + ?) WHERE id_medico_sys = ?";
      $stmt = mysqli_stmt_init ($mysqli);
      if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
      else {
        mysqli_stmt_bind_param ($stmt, "di", $monto, $_REQUEST['idm']);
        if (!mysqli_stmt_execute ($stmt)) echo mysqli_error($mysqli);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        header ('location:../v/default.php?page=appmed&idm='.$_REQUEST['idm'].'&idr='.$id_regalia);
      }
    }
  }
}
?>