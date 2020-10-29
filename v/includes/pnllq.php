<?php
require_once ('../c/funcs/utilities.php');
$filtros = explode ('!?', $_REQUEST['filters']);

$returnstring = "&sent=1&srchcx=".$filtros[0]."&vendcx=".$filtros[1]."&instcx=".$filtros[2]."&acr=".$filtros[3]."&fin=".$filtros[4]."&estado=".$filtros[5]."&mescxd=".$filtros[6]."&anocxd=".$filtros[7]."&mescxh=".$filtros[8]."&anocxh=".$filtros[9]."&meslqd=".$filtros[10]."&anolqd=".$filtros[11]."&meslqh=".$filtros[12]."&anolqh=".$filtros[13];

?>
<?php
$cantcx = 0;
$cxs = array();
$preparadas = 0;
$pendientes = 0;
$valstring = '';
foreach ($_REQUEST as $key=>$dato) {
  $dato = explode ('_', $key);
  if ($dato[0] == 'chkb') {
    $valstring .= "&".$key."=1";
    $cxs[] = $dato[1];
    $info = data_cx ($dato[1]);
    if ($info['estado'] == 1) $pendientes++;
    else if ($info['estado'] == 2) $preparadas++;
    $cantcx++;
  }
}
if ($cantcx < 1) {
  echo "<div class='simple-line'>No se indicaron cirugías para procesar. Haga click en el botón VOLVER para retornar al Panel de Cirugías (no se perderán los filtros previamente utilizados).</div><br><div class='simple-line'><a href='default.php?page=pnlcx".$returnstring."' class='buttons'>VOLVER</a></div>";
}
else if ($preparadas > 0 && $pendientes > 0) {
  echo "<div class='simple-line'>Se seleccionaron cirugías con diferentes estados (pendientes y preparadas). Haga click en el botón VOLVER para retornar al Panel de Cirugías (no se perderán los filtros previamente utilizados).</div><br><div class='simple-line'><a href='default.php?page=pnlcx".$returnstring."' class='buttons'>VOLVER</a></div>";
}
else {
  $medicos = lista_medicos();

  if ($pendientes > 0) {
    $estado = 'pendiente';
    $proceso = "preparar";
  }
  else {
    $estado = 'preparada';
    $proceso = "liquidar";
  }
  echo "<h2>".$proceso."</h2>";
  /*
  <div class='simple-line gocenter warning'>Puede detener este proceso haciendo click en el botón CANCELAR y retornar al Panel de Cirugías (no se perderán los filtros previamente utilizados)<br><a href='default.php?page=pnlcx".$returnstring."' class='buttons-warning'>CANCELAR</a></div>";
  */
  // Display cx seleccionadas (solo para preparar):
  if ($proceso == 'preparar') {
    ?>
    <datalist id='medicos'>
    <?php
    foreach ($medicos as $medico) {
      echo "<option value='".$medico['id_medico_sys']." - ".$medico['medico']." (SALDO: $ ".$medico['saldo'].")'>";
    }
    ?>
    </datalist>
    <!--<form autocompĺete='off' action="../c/pnllq-validate.php" method="post" id="checkform">-->
    <input type="hidden" name="estado" id="estado" value="<?=$estado;?>">
    <input type="hidden" name="valstring" id="valstring" value="<?=$valstring;?>">
    <?php
    //echo "<table class='results cx'>";
    foreach ($cxs as $cir) {
      $cxx = data_cx_detalle ($cir);
      //print_r ($cxx);
      //echo "<hr>";
      $info = data_cx ($cir);
      $pagable = ($info['monto'] * $info['aplicable']) / 100;
      $total += $pagable;
      $medico = ($info['medico'] != '') ? $info['medico'] : 'N/A';
      echo "<form method='post' action='../c/pnllqprep-validate.php' autocompĺete='off' name='formprep' id='formprep'>
            <table class='results cx'>";
      echo "<tr>
              <th colspan='5' class='goleft'><p>
                cx ".$cir." (".$info['fecha_cx'].") MEDico: ".$medico." - PACiente: ".$info['paciente']."</p><p>
                financiador: ".$info['cliente']." (".$info['aplicable']."%) - vendedor: ".$info['vendedor']."</p>
              </th>
              <th class='goright'>
                <input type='checkbox' id='chkb_".$cir."' name='chkb_".$cir."'>
                <label for='chkb_".$cir."'>
                <span></span>
                ".$proceso."
              </label>
              </th>
            </tr>
            <tr>
              <td class='subh gocenter'>cant</td>
              <td class='subh gocenter'>producto</td>
              <td class='subh gocenter'>valor</td>
              <td class='subh gocenter'>subtotal</td>
              <td class='subh gocenter'>sugerido</td>
              <td class='subh gocenter'>pagar</td>
            </tr>";
      $total = 0;
      foreach ($cxx as $cxy) {
        echo "<tr>
                <td class='gocenter'>".$cxy['cantidad']."</td>
                <td>".$cxy['producto']."</td>
                <td class='goright'>$ ".number_format ($cxy['precio_venta'], 2, ',', '.')."</td>
                <td class='goright'>$ ".number_format ($cxy['subtotal'], 2, ',', '.')."</td>
                <td class='goright'>$ ".number_format ($cxy['pagable'], 2, ',', '.')."</td>
                <td class='gocenter'>$ <input type='text' name='pagopr_".$cir."_".$cxy['id_cirugia_sys']."' value='' class='input-text goright' autocomplete='off' style='width:7rem;'></td>
              </tr>";
        $total += $cxy['pagable'];
      }
      echo "<tr>
              <td colspan='4' class='subh gocenter'>
                Acreedor: <input type='text' autocompĺete='off' list='medicos' id='medico_".$cir."' name='medico_".$cir."' class='input-text' style='width:30rem'>
                <span class='left-margin'>
                Importe cta/cte:</span> <input type='text' autocompĺete='off' name='pagocc_".$cir."' id='pagocc_".$cir."' autocomplete='off' class='input-text goright' value='".$pagocc."' style='width:7rem'>
              </td>
              <td class='subh goright'>$ ".number_format ($total, 2, ',', '.')."</td>
              <td class='subh gocenter'>$ <input type='text' name='pagocx_".$cir."' id='pagocx_".$cir."' value='' class='input-text goright' autocomplete='off' style='width:7rem;'></td>
            </tr>
          </table>"; 
    }
    
    //echo "</table>";
    /*
    echo "<table class='results cx'>";
    $total = 0;
    foreach ($cxs as $cx=>$value) {
      $info = data_cx ($value);
      $pagable = ($info['monto'] * $info['aplicable']) / 100;
      $total += $pagable;
      $medico = ($info['medico'] != '') ? $info['medico'] : 'N/A';
      echo "<tr>
              <td><input type='hidden' name='cx_".$value."' value='".$value."'>CX ".$value."<br>Fecha: ".$info['fecha_cx']."</td>
              <td>Médico: ".$medico."<br>Paciente: ".$info['paciente']."</td>
              <td>Financiador: ".$info['aplicable']."%<br>".$info['cliente']."</td>
              <td class='goright'>$ ".number_format ($info['monto'], 2, ',', '.')."</td>
              <td class='goright'>$ ".number_format ($pagable, 2, ',', '.')."</td>
            </tr>";
    }
    echo "<tr>
            <td colspan='4' class='goright'>TOTAL:</td>
            <td class='goright'>$ ".number_format ($total, 2, ',', '.')."</td>
          </tr>
        </table>";
    */
    // Fin de display cx seleccionadas
    /*
    ?>
    <datalist id='medicos'>
    <?php
    foreach ($medicos as $medico) {
      echo "<option value='".$medico['id_medico_sys']." - ".$medico['medico']." (SALDO: $ ".$medico['saldo'].")'>";
    }
    ?>
    </datalist>
    <div class="simple-line gocenter">
      Acreedor: <input type='text' autocompĺete='off' list='medicos' id='medico' name='medico' class='input-text' style='width:30rem'>
      <span class='left-margin'>Importe cta/cte:</span> <input type="text" autocompĺete='off' name="pagocc" id="pagocc" autocomplete="off" class="input-text goright" value="<?php echo $pagocc;?>" style='width:7rem'>
      <span class='left-margin'>Importe remito:</span> <input type="text" autocompĺete='off' name="pago" id="pago" autocomplete="off" class="input-text goright" value="<?php echo $pago;?>" style='width:7rem'>
    </div>
    <?php
    */
  }
  else { // caso de que sean preparadas y haya que liquidar
    
    $total = 0;
    $remitos = array();
    foreach ($cxs as $cx=>$value) {
      $info = data_cx ($value);
      if (!in_array($info['id_remito'], $remitos)) {
        $remitos[] = $info['id_remito']; 
      }
    }
    ?>
    <form autocompĺete='off' action="../c/pnllq-validate.php" method="post" id="checkform">
    <input type="hidden" name="estado" id="estado" value="<?=$estado;?>">
    <input type="hidden" name="valstring" id="valstring" value="<?=$valstring;?>">
    <?php
    echo "<table class='results cx'>
            <tr>
              <th>REMITO</th>
              <th>preparado</th>
              <th>acreedor</th>
              <th>monto</th>
              <th>cta/cte</th>
              <th>subtotal</th>
            </tr>";
    $total = 0;
    foreach ($remitos as $key=>$value) {
      $remito = data_remito ($value);
      $subtotal = $remito['monto_total'] - $remito['monto_ctacte'];
      echo "<tr>
              <td class='gocenter'>
                <input type='hidden' name='rem_".$remito['id_remito']."' value='".$remito['id_remito']."'>
                ".$remito['id_remito']."
              </td>
              <td class='gocenter'>".$remito['fecha_prep_h']."</td>
              <td>".$remito['medico']."</td>
              <td class='goright'>$ ".number_format ($remito['monto_total'], 2, ',', '.')."</td>
              <td class='goright'>$ ".number_format ($remito['monto_ctacte'], 2, ',', '.')."</td>
              <td class='goright'>$ ".number_format ($subtotal, 2, ',', '.')."</td>
            </tr>";
      $total += $subtotal;
    }
    echo "<tr>
            <td colspan='5' class='goright'>TOTAL:</td>
            <td class='goright'>$ ".number_format ($total, 2, ',', '.')."</td>
          </tr>
        </table>";
        
  }
  ?>
  <div class='gocenter'><a href='#' onclick="document.getElementById('formprep').submit()" class='buttons-standalone'><?=$proceso;?> marcadas</a></div>
  <input type="hidden" name="return" value="<?=$returnstring;?>">
  </form>
  <?php
  if (isset ($_REQUEST['errform'])) {
    if ($_REQUEST['errform'] == 1) $msgerror = "una cirugía marcada requiere un acrredor";
    if ($_REQUEST['errform'] == 2) $msgerror = "no se pudo conectar a la base de datos";
    if ($_REQUEST['errform'] == 3) $msgerror = "falta un dato importante";
    echo "<div class='error-msg'>".$msgerror."</div>";
  }
}
?>