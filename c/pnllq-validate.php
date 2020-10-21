<?php
session_start();
date_default_timezone_set('Etc/GMT+3');

// Validaciones
// href='../v/default.php?page=pnlcx".$_REQUEST['return']."'
$data = explode (' - ', $_REQUEST['medico']);
if ($_REQUEST['medico'] == '' || $_REQUEST['pago'] == '' || !is_numeric($_REQUEST['pago']) || count ($data) < 2) {
  header ('location:../v/default.php?page=pnllq'.$_REQUEST['valstring'].'&errform=1&estado='.$_REQUEST['estado']);
}
else {
  if ($_REQUEST['estado'] == 'pendiente') {
    echo "<h3>Preparar</h3>";
    /*
    SI SE PROCESAN PENDIENTES:
    ==========================
    1. Registrar liquidación en tabla remitos y obtener id_remito.
    2. Cambiar estado lógico de cada cx a 2 (1:pendiente, 2:preparada, 3:liquidada).
    */

    // Utils:
    $descuento = ($_REQUEST['pagocc'] == '') ? '0' : $_REQUEST['pagocc'];

    // 1.
    $id_medico = $data[0];
    $q = "INSERT INTO remitos (monto_total, monto_ctacte, id_acreedor, fecha_preparado) VALUES ('".$_REQUEST['pago']."', '".$descuento."', ".$id_medico.", CURDATE())";
    /**************************************
    OBTENER EL ÚLTIMO ID:
    $id_remito =  mysqli_insert_id($conn);
    **************************************/
    $id_remito = '9999999';
    echo "<p>$q</p>";

    // 2.
    $cxs = array();
    foreach ($_REQUEST as $key=>$value) {
      // echo "<p>$key: $value</p>";
      $data = explode ('_', $key);
      if ($data[0] == 'cx') {
        $cxs[] = $data[1];
      }
    }
    foreach ($cxs as $cx) {
      $q = "UPDATE cirugias SET estado = 2, id_remito = ".$id_remito." WHERE nro_cirugia = '".$cx."'";
      echo $q."<br>";
    }
  }
  else if ($_REQUEST['estado'] == 'preparada') {
    echo "<h3>Liquidar</h3>";
    /*SI SE PROCESAN PREPARADAS:
    ============================
    1. Cambiar estado lógico de cada cx a 3 (1:pendiente, 2:preparada, 3:liquidada).
    2. Actualizar saldo en tabla medicos.
    3. Si es necesario registrar movimiento en cuenta_medico.
    */

    // 1.
    $cxs = array();
    foreach ($_REQUEST as $key=>$value) {
      // echo "<p>$key: $value</p>";
      $data = explode ('_', $key);
      if ($data[0] == 'cx') {
        $cxs[] = $data[1];
      }
    }
    foreach ($cxs as $cx) {
      $q = "UPDATE cirugias SET estado = 3 WHERE nro_cirugia = '".$cx."'";
      echo $q."<br>";
    }

    // 3.
    if ($descuento > 0) {
      $q = "UPDATE medicos SET saldo = (saldo - ".$descuento.") WHERE id_medico_sys = ".$id_medico;
      echo "<p>$q</p>";
    }
    else echo "<p>No se aplican descuentos a cta cte</p>";
  }
  else {
    echo "ERROR";
  }
  echo "<p><a href='../v/default.php?page=pnlcx".$_REQUEST['return']."' class='buttons-warning'>VOLVER</a></p>";
}
?>