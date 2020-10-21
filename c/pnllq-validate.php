<?php
session_start();
echo "<p><a href='../v/default.php?page=pnlcx".$_REQUEST['return']."' class='buttons-warning'>VOLVER</a></p>";

/*
SI SE PROCESAN PENDIENTES:
==========================
1. Registrar liquidación en tabla remitos y obtener id_remito.
2. Cambiar estado lógico de cada cx a 2 (1:pendiente, 2:preparada, 3:liquidada).
*/

// Utils:
$descuento = ($_REQUEST['pagocc'] == '') ? '0' : $_REQUEST['pagocc'];

// 1.
$data = explode (' - ', $_REQUEST['medico']);
$id_medico = $data[0];
$q = "INSERT INTO remitos (monto_total, monto_ctacte, id_acreedor) VALUES ('".$_REQUEST['pago']."', '".$descuento."', ".$id_medico.")";
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

/*SI SE PROCESAN PREPARADAS:
============================
1. Cambiar estado lógico de cada cx a 3 (1:pendiente, 2:preparada, 3:liquidada) y registrar a que id_remito pertenece su liquidación.
2. Actualizar saldo en tabla medicos.
3. Si es necesario registrar movimiento en cuenta_medico.
*/

// Utils:
$descuento = ($_REQUEST['pagocc'] == '') ? '0' : $_REQUEST['pagocc'];

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
  $q = "UPDATE cirugias SET estado = 3, id_remito = ".$id_remito." WHERE nro_cirugia = '".$cx."'";
  echo $q."<br>";
}

// 3.
if ($descuento > 0) {
  $q = "UPDATE medicos SET saldo = (saldo - ".$descuento.") WHERE id_medico_sys = ".$id_medico;
  echo "<p>$q</p>";
}
else echo "<p>No se aplican descuentos a cta cte</p>";
?>