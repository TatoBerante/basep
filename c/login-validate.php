<?php
$bduser = "root";
$bdpass = "Nurgle2020";
$bd = "basep";
$mysqli = mysqli_connect("localhost", $bduser, $bdpass, $bd);
if (mysqli_connect_errno($mysqli)) {
  //echo "Fallo al conectar a MySQL: " . mysqli_connect_error();
  header ('location: ../login.php?error-login=2');
}
else {
  require_once ('funcs/common.php');
  $usr = sanitizeThis ($_REQUEST['user']);
  $key = sanitizeThis ($_REQUEST['key']);
  
  $qry = "SELECT usuario_id FROM usuarios WHERE usuario_nick = '".$usr."' AND usuario_key = '".$key."'";
  $res = mysqli_query($mysqli, $qry);
  
  if (mysqli_num_rows ($res) > 0) {
    header ('location: ../v/default.php');
  }
  else {
    header ('location: ../login.php?error-login=1');
  }
}
?>