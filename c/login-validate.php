<?php
require_once ('funcs/conn.php');
$mysqli = mysqli_conn();
if (!$mysqli) {
  header ('location: ../login.php?error-login=2');
}
else {
  require_once ('funcs/common.php');
  $usr = sanitizeThis ($_REQUEST['user']);
  $key = sanitizeThis ($_REQUEST['key']);
  
  $qry = "SELECT usuario_id, usuario_nombre, usuario_apellido, usuario_hry FROM usuarios WHERE usuario_nick = '".$usr."' AND usuario_key = '".$key."'";
  $res = mysqli_query($mysqli, $qry);
  echo $qry;
  if (mysqli_num_rows ($res) > 0) {

    $row = mysqli_fetch_assoc ($res);

    session_start();
    $_SESSION['basep']['uid'] = $row['usuario_id'];
    $_SESSION['basep']['usr'] = $row['usuario_nombre'].' '.$row['usuario_apellido'];
    $_SESSION['basep']['hry'] = $row['usuario_hry'];
    header ('location: ../v/default.php');
  }
  else {
    header ('location: ../login.php?error-login=1');
  }
}
?>