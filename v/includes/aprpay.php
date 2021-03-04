<?php
if (isset ($_REQUEST['idr']) && $_REQUEST['idr'] != '' && $_REQUEST['idr'] != 0) {
  // Remito recibido

  require_once ('../c/funcs/common.php');
  require_once ('../c/funcs/utilities.php');

  $remito = sanitizeThis ($_REQUEST['idr']);

  $cxs = cxs_en_remito ($remito);
  if (count ($cxs) < 1) {
    echo "<div class='error-msg'>EL REMITO N° ".$remito." NO EXISTE O NO CONTIENE CIRUGÍAS</div>";
  }
  else {
    echo "<h2>Aprobar Pago Remito N° ".$remito."</h2>";
    //echo "<div class='mostrandores'>Mostrando detalle de remito n° ".$remito.":</div>";
    $headok = false;
    foreach ($cxs as $cir) {
      $cxx = data_cx_detalle ($cir['nro_cirugia']);
      /*
      echo "<pre>";
      print_r ($cxx);
      echo "</pre>";
      */
      $info = data_cx ($cir['nro_cirugia']);
      $pagable = ($info['monto'] * $info['aplicable']) / 100;
      $total += $pagable;
      $medico = ($info['medico'] != '') ? $info['medico'] : 'N/A';
      $cod_vendedor =  $info['cod_vendedor'];
      
      if (!$headok) {
        $liquidado = ($cxx[0]['fecha_liq_h'] != '') ? $cxx[0]['fecha_liq_h'] : 'N/A';
        echo "<table class='data-remito'>
                <tr>
                  <td>PREPARADO:</td><td class='goright'>".$cxx[0]['fecha_prep_h']."</td>
                  <td class='separador'>LIQUIDADO:</td><td class='goright'>".$liquidado."</td>
                </tr>
                <tr>
                  <td colspan='4'>ACREEDOR: ".$cxx[0]['acreedor']."</td>
                </tr>
                <tr>
                  <td colspan='4'>RETIRA: ".$cxx[0]['portador']."</td>
                </tr>
                <tr>
                  <td>SALDO:</td><td class='goright'>$ ".number_format($cxx[0]['saldo_ctacte_previo'], 2, ',', '.')."</td>
                  <td class='separador'>SUBTOTAL:</td><td class='goright'>$ ".number_format($cxx[0]['monto_total'], 2, ',', '.')."</td>
                </tr>
                <tr>
                  <td>DESCUENTO:</td><td class='goright'>$ ".number_format($cxx[0]['monto_ctacte'], 2, ',', '.')."</td>
                  <td class='separador'>TOTAL:</td><td class='goright'>$ ".number_format($cxx[0]['pagado'], 2, ',', '.')."</td>
                </tr>
              </table><br><h3>Detalle :</h3>";
        $headok = true;
        $elegibles++;
      }
      echo "<table class='results cx'>
            <tr>
              <th colspan='6' class='goleft'><p>
                cx ".$cxx[0]['nro_cirugia']." (".$info['fecha_cx'].") MEDico: ".$medico." - PACiente: ".$info['paciente']."</p><p>
                cliente: ".$info['cliente']." (".$info['aplicable']."%) - vendedor: ".$info['vendedor']."</p>
              </th>
            </tr>
            <tr>
              <td class='subh gocenter' style='width:2rem;'>cant</td>
              <td class='subh gocenter'>producto</td>
              <td class='subh gocenter' style='width:8rem;'>valor</td>
              <td class='subh gocenter' style='width:8rem;'>subtotal</td>
              <td class='subh gocenter' style='width:8rem;'>sugerido</td>
              <td class='subh gocenter' style='width:8rem;'>indicado</td>
            </tr>";
      $total = 0;
      foreach ($cxx as $cxy) {
        echo "<tr>
                <td class='gocenter'>".$cxy['cantidad']."</td>
                <td>".$cxy['producto']."</td>
                <td class='goright'>$ ".number_format ($cxy['precio_venta'], 2, ',', '.')."</td>
                <td class='goright'>$ ".number_format ($cxy['subtotal'], 2, ',', '.')."</td>
                <td class='goright'>$ ".number_format ($cxy['pagable'], 2, ',', '.')."</td>
                <td class='goright'>$ ".number_format ($cxy['monto_a_pagar'], 2, ',', '.')."</td>
              </tr>";
        $subtotal += $cxy['pagable'];
        $total += $cxy['monto_a_pagar'];
      }
      echo "<tr>
              <td colspan='4' class='subh gocenter'></td>
              <td class='subh goright'>$ ".number_format ($subtotal, 2, ',', '.')."</td>
              <td class='subh goright'>$ ".number_format ($total, 2, ',', '.')."</td>
            </tr>
          </table>";
      $subtotal = 0;
    }
  }
  // ../c/appusr-validate.php
  //echo "<div class='gocenter'><a href='default.php?page=pnlaprpay&remito=".$remito."&sent=1&mescxd=NC&meslqd=NC' class='buttons'>APROBAR PAGO</a></div>";
  echo "<div class='gocenter'><a href='../c/aprpay-validate.php?remito=".$remito."&sent=1&mescxd=NC&meslqd=NC' class='buttons'>APROBAR PAGO</a></div>";
}
else {
  echo "<div class='error-msg'>NO SE RECIBIÓ UN REMITO</div>";
}
?>