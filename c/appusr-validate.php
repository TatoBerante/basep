<?php
session_start();

date_default_timezone_set('Etc/GMT+3');

$ns_nom = trim ($_REQUEST['nombreusr']);
$ns_ape = trim ($_REQUEST['apellidousr']);
$ns_nck = trim ($_REQUEST['nickusr']);
$ns_key = trim ($_REQUEST['keyusr']);

$errores = 0;
$errret = "";
if (!ctype_alpha ($ns_nom) || strlen ($ns_nom) < 1) {
  $errores++;
  $errret .= "&errnom=1";
}
if (!ctype_alpha ($ns_ape) || strlen ($ns_ape) < 1) {
  $errores++;
  $errret .= "&errape=1";
}
if (!ctype_alnum ($ns_nck) || strlen ($ns_nck) < 8) {
  $errores++;
  $errret .= "&errnck=1";
}
if (!ctype_alnum ($ns_key) || strlen ($ns_key) < 8) {
  $errores++;
  $errret .= "&errkey=1";
}

if ($errores > 0) {
  if ($_REQUEST['flag'] == 'n') header ('location:../v/default.php?page=appusr&actflag=new&nombreusr='.$ns_nom.'&apellidousr='.$ns_ape.'&nickusr='.$ns_nck.'&keyusr='.$ns_key.'&errform=1'.$errret);
  else header ('location:../v/default.php?page=appusr&actflag=mod&idusr='.$_REQUEST['flag'].'&errform=1'.$errret);
}
else {
  require_once ('funcs/conn.php');
  $mysqli = mysqli_conn();
  if (!$mysqli) {
    header ('location:../v/default.php?page=appusr&actflag=new&nombreusr='.$ns_nom.'&apellidousr='.$ns_ape.'&nickusr='.$ns_nck.'&keyusr='.$ns_key.'&errform=2');
  }
  else {
    $flag = $_REQUEST['flag'];
    if (ctype_digit ($flag)) { // id_usuario: es mod
      // Verificar si el nick seleccionado no existe en otro usuario
      $qc = "SELECT usuario_id FROM usuarios WHERE usuario_nick = '".$ns_nck."' AND usuario_id != ".$flag;
      $rc = mysqli_query($mysqli, $qc);
      //$rc = mysqli_stmt_get_result($qc);
      //echo $qc;
      if (mysqli_num_rows ($rc) > 0) { // El nick enviado ya existe en BD
        header ('location:../v/default.php?page=appusr&actflag=mod&idusr='.$_REQUEST['flag'].'&errform=3');
      }
      else {
        $sql = "UPDATE usuarios SET
                usuario_nombre = ?,
                usuario_apellido = ?,
                usuario_nick = ?,
                usuario_key = ?
                WHERE usuario_id = ?";
        $stmt = mysqli_stmt_init ($mysqli);
        if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
        else {
          mysqli_stmt_bind_param ($stmt, "ssssi", $ns_nom, $ns_ape, $ns_nck, $ns_key, $flag);
          mysqli_stmt_execute ($stmt);
          mysqli_stmt_close($stmt);
          mysqli_close($mysqli);
          header ('location:../v/default.php?page=sccss&org=appusr&actflag=mod&nickusr='.$ns_nck);
        }
      }
    }
    else if ($_REQUEST['flag'] == 'n') { // n: nuevo
      $qry = "SELECT usuario_id, usuario_nombre, usuario_apellido, usuario_hry FROM usuarios WHERE usuario_nick = '".$ns_nck."'";
      $res = mysqli_query($mysqli, $qry);
      if (mysqli_num_rows ($res) > 0) header ('location:../v/default.php?page=appusr&actflag=new&nombreusr='.$ns_nom.'&apellidousr='.$ns_ape.'&nickusr='.$ns_nck.'&keyusr='.$ns_key.'&errform=3');
      else {
        $sql = "INSERT INTO usuarios (usuario_nombre, usuario_apellido, usuario_nick, usuario_key)
                VALUES (?, ?, ?, ?)";
        $stmt = mysqli_stmt_init ($mysqli);
        if (!mysqli_stmt_prepare ($stmt, $sql)) {
          header ('location:../v/default.php?page=appusr&actflag=new&nombreusr='.$ns_nom.'&apellidousr='.$ns_ape.'&nickusr='.$ns_nck.'&keyusr='.$ns_key.'&errform=2');
        }
        else {
            mysqli_stmt_bind_param ($stmt, "ssss", $ns_nom, $ns_ape, $ns_nck, $ns_key);
            mysqli_stmt_execute ($stmt);
            // Solo para obtener resultados de un select y recorrerlo:
            /*
            $result = mysqli_stmt_get_result ($stmt);
            while ($row = mysqli_fetch_assoc ($result)) {
                echo $row['field']."<br>";
            }
            */
            $last_id = mysqli_insert_id ($mysqli);
            mysqli_stmt_close($stmt);
            mysqli_close($mysqli);
            header ('location:../v/default.php?page=sccss&org=appusr&actflag=new&nickusr='.$ns_nck);
        }
      }
    }
    else { // error flag
      header ('location:../v/default.php?page=appusr&actflag=new&nombreusr='.$ns_nom.'&apellidousr='.$ns_ape.'&nickusr='.$ns_nck.'&keyusr='.$ns_key.'&errform=1'.$errret.'&test=x');
    }
  }
}
?>