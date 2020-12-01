<?php
function mysqli_conn () {
  include "../core/config-hosting.php";
  $mysqli = mysqli_connect("localhost", $dbusr, $dbkey, $db);
  if (mysqli_connect_errno($mysqli)) {
    return false;
  }
  else return $mysqli;
}
?>