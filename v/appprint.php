<?php
// https://www.smashingmagazine.com/2015/01/designing-for-print-with-css/
session_start();
if (false) {
  echo "error";
}
else {
  require_once "../c/funcs/utilities.php";
  $extrastr = "";
  $remitos = array();
  foreach ($_REQUEST as $key=>$value) {
    $data = explode ('_', $key);
    if ($data[0] == 'rem') {
      $extrastr .= "&chkr_".$data[1]."=1";
      $remitos[] = $data[1];
    }
  }
  $gohref = "default.php?page=pnllq".$extrastr."&filters=".$_REQUEST['filters'].$_REQUEST['return'];
  //echo "<p><a href='".$gohref."'>GO!</a></p>";
  
  /*
  showall ($_REQUEST);
  showall ($remitos);
  */

  ?>
  <!DOCTYPE html>
  <html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/normalize.css">
    <link rel="stylesheet" type="text/css" href="styles/printable.css">
    <title>HM2</title>
  </head>
  <body>
    <?php
    foreach ($remitos as $remito) {
      $data = data_remito ($remito);
      $total_cx = $data['monto_total'] - $data['monto_ctacte'];
      // Start bloque
      echo "<div class='bloque'>
              <div>Comprobante de cirugías <a href='".$gohref."'>(".$remito.")</a> para ".$data['medico']."</div>
              <div>Retira: ".$data['retira']."</div>
              <div>Subtotal: $ ".$data['monto_total']." | Saldo: $ ".$data['saldo_ctacte_previo']." | Descuento: $ ".$data['monto_ctacte']." | Pago: $ ".$total_cx."</div>";
      $cxs = cxs_en_remito ($remito);
      echo "<div>";
      foreach ($cxs as $cx) {
        echo "<div>CIR: ".$cx['cirujano']." (".$cx['nro_cirugia'].") PAC: ".$cx['nombre_paciente']." - FCX: ".$cx['fecha_cx_h']." - PAG: ".$cx['monto_total']."</div>";
      }
      echo "</div>";
      echo "</div>";
      // End bloque
    }
    ?>
    <!--
    <div class="bloque">
    <?php
    for ($i=0; $i<15; $i++) {
      echo "<p>Esta es la línea N° $i del bloque 1 (ñ y ó son españoles)</p>";
    }
    echo "</div><div class='bloque'>";
    for ($i=0; $i<15; $i++) {
      echo "<p>Esta es la línea N° $i del bloque 2 (ñ y ó son españoles)</p>";
    }
    echo "</div>";
    ?>
    </div>
    -->
  </body>
  </html>
  <?php
}