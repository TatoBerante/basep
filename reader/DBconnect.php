<?php
$dbServerName = "localhost";
$dbUserName = "root"; // nf85a45_tato en inmotion (primero agregar usuario a db)
$dbPassword = "Hijo09"; // Dell2020
$dbName = "hm2";
// ftp://200.110.219.83/

$conn = mysqli_connect ($dbServerName, $dbUserName, $dbPassword, $dbName);
if (mysqli_connect_errno($conn)) {
    echo "Fallo al conectar a MySQL: " . mysqli_connect_error();
}
$conn->set_charset('utf8');
$conn->query("SET collation_connection = utf8mb4_unicode_ci");
?>
