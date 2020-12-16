<?php
function mysqli_conn () {
  include "../core/config.php";
  $mysqli = mysqli_connect("localhost", $dbusr, $dbkey, $db);
  if (mysqli_connect_errno($mysqli)) {
    return false;
  }
  else {
    $mysqli->set_charset('utf8');
    $mysqli->query("SET collation_connection = utf8mb4_unicode_ci");
    return $mysqli;
  }
}
?>