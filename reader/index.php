<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<?php
//$txt_file = file_get_contents('ftp://181.30.106.114/Clientes.csv');
$txt_file = file_get_contents('dummy.csv');
$rows     = explode("\n", $txt_file);
array_shift($rows);

include "DBconnect.php";
/*
mysqli_set_charset($conn, "utf8");
mysqli_query($conn, "SET NAMES 'utf8'");
*/
$conn->set_charset('utf8');
$conn->query("SET collation_connection = utf8_general_ci");
date_default_timezone_set('Etc/GMT+3');
$errors = 0;
foreach($rows as $row => $data)
{
  if ($row > 0) {
    //get row data
    $row_data = explode('|', $data);
    if (count($row_data) > 1) {
      /*
      $info[$row]['empresa']        = $row_data[0];
      $info[$row]['id_cliente']     = $row_data[1];
      $info[$row]['cliente']        = $row_data[2];
      $info[$row]['tipo_cliente']   = $row_data[3];
      $info[$row]['condicion_pago'] = $row_data[4];
      $info[$row]['condicion']      = $row_data[5];
      */
      $empresa = trim ($row_data[0]);
      $id_cliente = trim ($row_data[1]);
      $cliente = htmlentities(trim ($row_data[2]), ENT_QUOTES, "ISO-8859-1");
      $cliente = html_entity_decode ($cliente);
      $tipo_cliente = trim ($row_data[3]);
      $condicion_pago = trim ($row_data[4]);
      $condicion = trim ($row_data[5]);

      if ($id_cliente == '002665') {
        echo "<p>".$cliente."</p>";
      }
      //handle data
      /*
      echo 'EMPRESA: '.$info[$row]['empresa'].'<br />';
      echo 'ID_CLIENTE: '.$info[$row]['id_cliente'].'<br />';
      echo 'CLIENTE: '.$info[$row]['cliente'].'<br />';
      echo 'TIPO_CLIENTE: '.$info[$row]['tipo_cliente'].'<br />';
      echo 'CONDICION_PAGO: '.$info[$row]['condicion_pago'].'<br />';
      echo 'CONDICION: '.$info[$row]['condicion'].'<br />';
      

      $qexists = "SELECT id_cliente FROM clientes WHERE id_cliente = '".$info[$row]['id_cliente']."' OR
                  cliente = '".$info[$row]['cliente']."'";
      $rexists = mysql_query ($qexists);
      if (mysql_num_rows ($rexists) < 1) { // does not exists
        */
        $sql = "INSERT INTO clientes (id_cliente, empresa, cliente, tipo_cliente, condicion_pago, condicion)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init ($conn);
        if (!mysqli_stmt_prepare ($stmt, $sql)) {
            //header ('location:../default.php?p=newuser&nom='.$nom.'&ape='.$ape.'&nck='.$nck.'&psw='.$psw.'&jer='.$jer.'&msg=error-bd');
            // Para saber el motivo de fallo:
            print_r (mysqli_stmt_error($stmt));
            echo "<p>".$sql."</p>";
            /*
            echo 'EMPRESA: '.$info[$row]['empresa'].'<br />';
            echo 'ID_CLIENTE: '.$info[$row]['id_cliente'].'<br />';
            echo 'CLIENTE: '.$info[$row]['cliente'].'<br />';
            echo 'TIPO_CLIENTE: '.$info[$row]['tipo_cliente'].'<br />';
            echo 'CONDICION_PAGO: '.$info[$row]['condicion_pago'].'<br />';
            echo 'CONDICION: '.$info[$row]['condicion'].'<br />';
            echo "<span style='color:red;'>INSERT ERROR: ".mysql_error()."</span><br />".$qinserts."<br />";
            echo '***<br />';
            $errors++;
            */
        }
        else {
            mysqli_stmt_bind_param ($stmt, "ssssss", $id_cliente, $empresa, $cliente, $tipo_cliente, $condicion_pago, $condicion);
            mysqli_stmt_execute ($stmt);
            mysqli_stmt_close($stmt);
            // Solo para obtener resultados de un select y recorrerlo:
            /*
            $result = mysqli_stmt_get_result ($stmt);
            while ($row = mysqli_fetch_assoc ($result)) {
                echo $row['field']."<br>";
            }
            */
            /*
            $last_id = mysqli_insert_id ($conn);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header ('location:../default.php?p=pageuser&msg=cok&idu='.$last_id);
            */
        }
        /*
        $qinserts = "INSERT INTO clientes (id_cliente, empresa, cliente, tipo_cliente, condicion_pago, condicion)
                      VALUES (
                        '".$info[$row]['id_cliente']."',
                        '".$info[$row]['empresa']."',
                        '".$info[$row]['cliente']."',
                        '".$info[$row]['tipo_cliente']."',
                        '".$info[$row]['condicion_pago']."',
                        '".$info[$row]['condicion']."'
                      )";
        $rinserts = mysql_query ($qinserts);
        if (!$rinserts) {
          echo 'EMPRESA: '.$info[$row]['empresa'].'<br />';
          echo 'ID_CLIENTE: '.$info[$row]['id_cliente'].'<br />';
          echo 'CLIENTE: '.$info[$row]['cliente'].'<br />';
          echo 'TIPO_CLIENTE: '.$info[$row]['tipo_cliente'].'<br />';
          echo 'CONDICION_PAGO: '.$info[$row]['condicion_pago'].'<br />';
          echo 'CONDICION: '.$info[$row]['condicion'].'<br />';
          echo "<span style='color:red;'>INSERT ERROR: ".mysql_error()."</span><br />".$qinserts."<br />";
          echo '***<br />';
          $errors++;
        }
        else {
          //echo "<span style='color:green;'>INSERT SUCCESS</span><br />";
        }
        */
      /*}
      else { // exists
        echo "<span style='color:orange;'>EXISTS</span><br />";
        echo "<span style='color:orange;'>INSERT ERROR: ".mysql_error()."</span><br />".$qinserts."<br />";
        echo '***<br />';
      }
      */
      //echo '***<br />';
    }
  }
}
echo "ERRORES: ".$errors;
//mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
</body>
</html>