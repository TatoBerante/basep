<h2>Detalle de Liquidación
<?php
if (!isset ($_REQUEST['nrocx']) || $_REQUEST['nrocx'] == '') {
  echo "<p class='error-msg'>Falta algo importante</p>";
}
else {
  echo " CX ".$_REQUEST['nrocx']."</h2>";
  $cx = data_cx_detalle ($_REQUEST['nrocx']);
  $headok = false;
  $total = 0;
  foreach ($cx as $producto) {
    if (!$headok) {
      echo "<table class='data-remito'>
              <tr>
                <td>EN REMITO:</td><td>".$producto['id_remito']." <a href='default.php?page=pnlcx&sent=1&remito=".$producto['id_remito']."' class='green-link'>VER REMITO COMPLETO</a></td>
              </tr>
              <tr>
                <td>PREPARADO:</td><td>".$producto['fecha_prep_h']."</td>
              </tr>
              <tr>
                <td>LIQUIDADO:</td><td>".$producto['fecha_liq_h']."</td>
              </tr>
              <tr>
                <td>ACREEDOR:</td><td>".$producto['acreedor']."</td>
              </tr>
              <tr>
                <td>RETIRA:</td><td>".$producto['portador']."</td>
              </tr>
            </table>
            <table class='results cx'>
            <tr>
              <th colspan='6' class='goleft'><p>
                cx ".$producto['nro_cirugia']." (".$producto['fecha_cx_h'].") MEDico: ".$producto['medico']." - PACiente: ".$producto['nombre_paciente']."</p><p>
                financiador: ".$producto['cliente']." (".$producto['aplicable']."%) - vendedor: ".$producto['nombre_vendedor']."</p>
              </th>
            </tr>
            <tr>
              <td class='subh gocenter'>cant</td>
              <td class='subh gocenter'>producto</td>
              <td class='subh gocenter'>valor</td>
              <td class='subh gocenter'>subtotal</td>
              <td class='subh gocenter'>sugerido</td>
              <td class='subh gocenter'>pagado</td>
            </tr>";
      $monto_subtotal = $producto['monto_total'];
      $monto_ctacte = $producto['monto_ctacte'];
      $monto_final = $monto_subtotal - $monto_ctacte;
      $saldo_previo = $producto['saldo_ctacte_previo'];
      $id_remito = $producto['id_remito'];
      $headok = true;
    }
    echo "<tr>
            <td class='gocenter'>".$producto['cantidad']."</td>
            <td>".$producto['producto']."</td>
            <td class='goright'>$ ".number_format ($producto['precio_venta'], 2, ',', '.')."</td>
            <td class='goright'>$ ".number_format ($producto['subtotal'], 2, ',', '.')."</td>
            <td class='goright'>$ ".number_format ($producto['pagable'], 2, ',', '.')."</td>
            <td class='goright'>$ ".number_format ($producto['monto_a_pagar'], 2, ',', '.')."</td>";
    echo "</tr>";
  }
  echo "<tr>
          <td colspan='6' class='subh'>
            <div class='remito-footer'>
              <span>SUBTOTAL:$ ".number_format ($monto_subtotal, 2, ',', '.')."</span>
              <span>SALDO: $ ".number_format ($saldo_previo, 2, ',', '.')."</span>
              <span>DESC: $ ".number_format ($monto_ctacte, 2, ',', '.')."</span>
              <span>TOTAL $ ".number_format ($monto_final, 2, ',', '.')."</span>
            </div>
          </td>
        </tr>
      </table>";
  $cxs = cxs_en_remito ($id_remito);
  if (count ($cxs) > 1) {
    echo "<h3>Otras cx en este remito:</h3>";
    foreach ($cxs as $cx) {
      if ($cx['nro_cirugia'] != $_REQUEST['nrocx']) {
        echo "<a href='default.php?page=pnldetlq&nrocx=".$cx['nro_cirugia']."' class='buttons' style='margin-right:1rem;'>".$cx['nro_cirugia']."</a>";
      }
    }
  }
}
?>