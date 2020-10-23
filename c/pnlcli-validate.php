<?php
session_start();
date_default_timezone_set('Etc/GMT+3');
$apl = trim ($_REQUEST['apl']);
$clue = $_REQUEST['clue'];
$idc = $_REQUEST['idc'];
$retstring = '../v/default.php?page=pnlcli&srchcli='.$clue.'&idc='.$idc.'&sent=1';
if (!is_numeric ($apl) || $apl == '') {
  header ('location:'.$retstring.'&error=1');
}
else {
  require_once "funcs/conn.php";
  if (!$mysqli = mysqli_conn()) header ('location:'.$retstring.'&error=2');
  $sql = "UPDATE clientes SET aplicable = ? WHERE id_cliente_sys = ?";
  $stmt = mysqli_stmt_init ($mysqli);
  if (!mysqli_stmt_prepare ($stmt, $sql)) header ('location:'.$retstring.'&error=2');
  mysqli_stmt_bind_param ($stmt, "di", $apl, $idc);
  if (!mysqli_stmt_execute ($stmt)) header ('location:'.$retstring.'&error=2');
  else {
    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);
    header ('location:../v/default.php?page=pnlcli&srchcli='.$clue.'&sent=1&error=x');
  }
}
?>