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
              <table style='width:100%;' class='remito'>
                <tr class='header'>
                  <td>
                    Comprobante de cirugías <a href='".$gohref."'>(".$remito.")</a> para ".$data['medico']."
                  </td>
                  <td rowspan='2' class='fecha'>
                    ".$data['fecha_lq_h']."
                  </td>
                </tr>
                <tr class='header'>
                  <td>
                    Retira: ".$data['retira']."
                  </td>
                </tr>
                <tr>
                  <td colspan='2' class='subheader'>Detalle:</td>
                </tr>";
      $cxs = cxs_en_remito ($remito);
      foreach ($cxs as $cx) {
        $tcx = total_cx ($cx['nro_cirugia']);
        echo "<tr>
                <td>
                  Cirujano: ".$cx['cirujano']." (".$cx['nro_cirugia'].") FCX ".$cx['fecha_cx_h']."<br>Paciente: ".$cx['nombre_paciente']." (".$cx['institucion'].")
                </td>
                <td style='text-align:right;' class='vcp'>
                  $ ".number_format($tcx, 2, ',', '.')."
                </td>
              </tr>";
      }
      echo "<tr class='subheader'>
              <td colspan='2'>
                <div class='totalcx'>
                  <span>Subtotal: $ ".number_format($data['monto_total'], 2, ',', '.')."</span>
                  <span>Saldo: $ ".number_format($data['saldo_ctacte_previo'], 2, ',', '.')."</span>
                  <span>Descuento: $ ".number_format($data['monto_ctacte'], 2, ',', '.')."</span>
                  <span>Total: $ ".number_format($total_cx, 2, ',', '.')."</span>
                </div>
              </td>
            </tr>
          </table>
        </div>";
      // End bloque
    }
    ?>
  </body>
  </html>
  <?php
}