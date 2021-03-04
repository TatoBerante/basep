<?php
require_once ('../c/funcs/utilities.php');
$filtros = explode ('!?', $_REQUEST['filters']);

$returnstring = "&sent=1&srchcx=".$filtros[0]."&vendcx=".$filtros[1]."&instcx=".$filtros[2]."&acr=".$filtros[3]."&fin=".$filtros[4]."&estado=".$filtros[5]."&mescxd=".$filtros[6]."&anocxd=".$filtros[7]."&mescxh=".$filtros[8]."&anocxh=".$filtros[9]."&meslqd=".$filtros[10]."&anolqd=".$filtros[11]."&meslqh=".$filtros[12]."&anolqh=".$filtros[13];

//showall ($_REQUEST);

?>
<?php
$cantcx = 0;
$cantrm = 0;
$cxs = array();
$rems = array();
$preparadas = 0;
$pendientes = 0;
$liquidadas = 0;
$aprobadas = 0;
$valstring = '';
foreach ($_REQUEST as $key=>$dato) {
  $dato = explode ('_', $key);
  if ($dato[0] == 'chkb') {
    $valstring .= "&".$key."=1";
    $cxs[] = $dato[1];
    $info = data_cx ($dato[1]);
    if ($info['estado'] == 1) $pendientes++;
    else if ($info['estado'] == 2) $preparadas++;
    else if ($info['estado'] == 3) $liquidadas++;
    else if ($info['estado'] == 4) $aprobadas++;
    $cantcx++;
  }
  if ($dato[0] == 'chkr') {
    $info = data_remito($dato[1]);
        
    if ($info['estado'] == 4) {
      $aprobadas++;
    }
    $cantrm++;
    $rems[] = $dato[1];
    //$liquidadas++;
    $cantrm++;
  }
}
//showall($cxs);
if ($cantcx < 1 && $cantrm < 1) {
  echo "<div class='error-msg'>No se indicaron cirugías para procesar. Haga click en el botón VOLVER para retornar al Panel de Cirugías (no se perderán los filtros previamente utilizados).</div><div class='gocenter'><a href='default.php?page=pnlcx".$returnstring."' class='buttons-standalone'>VOLVER</a></div>";
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
  else if ($liquidadas > 0) {
    $estado = 'liquidada';
    $proceso = "imprimir";
  }
  else if ($aprobadas > 0) {
    $estado = 'aprobada';
    $proceso = "entregar";
  }
  else {
    $estado = 'preparada';
    $proceso = "liquidar";
  }
  echo "<h2>".$proceso."</h2>";
  if ($aprobadas > 0) {
    echo "<div class='simple-line gocenter warning'>Revise la información presentada antes de proceder, este paso no tiene rectificación. Ante cualquier duda presione cancelar.<br><a href='default.php?page=pnlcx".$returnstring."' class='buttons-warning'>CANCELAR</a></div>";
  }
  else {
    echo "<div class='simple-line gocenter warning'>Puede detener este proceso haciendo click en el botón CANCELAR y retornar al Panel de Cirugías (no se perderán los filtros previamente utilizados)<br><a href='default.php?page=pnlcx".$returnstring."' class='buttons-warning'>CANCELAR</a></div>";
  }

  if (isset ($_REQUEST['error'])) {
    if ($_REQUEST['error'] == '1') $msg = "algo salió mal";
    else if ($_REQUEST['error'] == '2') $msg = "no se marcó ninguna cx para preparar";
    else if ($_REQUEST['error'] == '3') $msg = "no se seleccionó un médico acreedor";
    else if ($_REQUEST['error'] == '4') $msg = "el descuento de cta. cte. no es un valor aceptable";
    else if ($_REQUEST['error'] == '5') $msg = "existen valores a pagar incorrectos";
    echo "<div class='error-msg'>$msg</div>";
  }
  
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
    <form method='post' action='../c/pnllqprep-validate.php' autocompĺete='off' name='formprep' id='formprep'>
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
      $cod_vendedor =  $info['cod_vendedor'];
      echo "<!--<form method='post' action='../c/pnllqprep-validate.php' autocompĺete='off' name='formprep' id='formprep'>-->
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
              <td class='subh gocenter' style='width:3rem;'>cant</td>
              <td class='subh gocenter'>producto</td>
              <td class='subh gocenter' style='width:8rem;'>valor</td>
              <td class='subh gocenter' style='width:8rem;'>subtotal</td>
              <td class='subh gocenter' style='width:8rem;'>sugerido</td>
              <td class='subh gocenter' style='width:12rem;'>pagar</td>
            </tr>";
      $total = 0;
      foreach ($cxx as $cxy) {
        echo "<tr>
                <td class='gocenter'>".$cxy['cantidad']."</td>
                <td>".$cxy['producto']."</td>
                <td class='goright'>$ ".number_format ($cxy['precio_venta'], 2, ',', '.')."</td>
                <td class='goright'>$ ".number_format ($cxy['subtotal'], 2, ',', '.')."</td>
                <td class='goright'>$ ".number_format ($cxy['pagable'], 2, ',', '.')."</td>";
                ?>
                <td class="gocenter">$ <input type="text" name="pagopr_<?=$cir."_".$cxy['id_cirugia_sys'];?>" id="pagopr_<?=$cir."_".$cxy['id_cirugia_sys'];?>" value="0" class="input-text goright" autocomplete="off" style="width:7rem;" onblur="addValue(this, 'pagocx_<?=$cir;?>')" onfocus="subValue(this, 'pagocx_<?=$cir;?>', 'pagopr_<?=$cir."_".$cxy['id_cirugia_sys'];?>')"></td>
                <?php
        echo "</tr>";
        $total += $cxy['pagable'];
      }
      echo "<tr>
              <td colspan='4' class='subh gocenter'>
                <!--
                Acreedor: <input type='text' autocompĺete='off' list='medicos' id='medico_".$cir."' name='medico_".$cir."' class='input-text' style='width:30rem'>
                <span class='left-margin'>
                Importe cta/cte:</span>";
                ?>
                <input type="text" autocompĺete="off" name="pagocc_<?=$cir;?>" id="pagocc_<?=$cir;?>" autocomplete="off" class="input-text goright" value="<?=$pagocc;?>" style="width:7rem" onblur="resValue(this, 'pagocx_<?=$cir;?>')" onfocus="subValue(this, 'pagocx_<?=$cir;?>', 'pagocc_<?=$cir."_".$cxy['id_cirugia_sys'];?>')">
                -->
      <?php
      echo "</td>
              <td class='subh goright'>$ ".number_format ($total, 2, ',', '.')."</td>
              <td class='subh goright'> <!--
                $ <input type='text' name='pagocx_".$cir."' id='pagocx_".$cir."' value='' class='input-text goright' autocomplete='off' style='width:7rem;'> -->
                $ <span id='pagocx_".$cir."' style='margin-right:2rem;'>0</span>
              </td>
            </tr>
          </table>";
    }
  }
  else if ($proceso == 'liquidar') { // caso de que sean preparadas y haya que liquidar

    $total = 0;
    $remitos = array();

    ?>
    <form autocompĺete='off' action="../c/pnllq-validate.php" method="post" id="checkform">
    <input type="hidden" name="estado" id="estado" value="<?=$estado;?>">
    <input type="hidden" name="valstring" id="valstring" value="<?=$valstring;?>">
    <?php
    echo "<table class='results cx'>
            <tr>
              <th>REMITO</th>
              <th>cirugías</th>
              <th>acreedor</th>
              <th>retira</th>
              <th>monto</th>
              <th>cta/cte</th>
              <th>subtotal</th>
            </tr>";
    $total = 0;
    foreach ($cxs as $key=>$value) {
      $remito = data_remito ($value);
      $subtotal = $remito['monto_total'] - $remito['monto_ctacte'];
      $retira = $remito['retira'];
      echo "<tr>
              <td class='goleft'>
                <input type='hidden' name='rem_".$remito['id_remito']."' value='".$remito['id_remito']."'>
                N° ".$remito['id_remito']."<br>PREP: ".$remito['fecha_prep_h']."
              </td>
              <td>";
      $cxsr = cxs_en_remito ($remito['id_remito']);
      foreach ($cxsr as $cr) {
        echo $cr['nro_cirugia']." (".$cr['fecha_cx_h']." pac. ".$cr['nombre_paciente'].")<br>";
      }
              /*
                ".$remito['nro_cirugia']." (".$remito['fecha_cx_h'].")<br>
                Dr. ".$remito['medico']."<br>
                pac. ".$remito['paciente']."<br>
              
              */
      echo "</td>
            <td>".$remito['medico']."</td>
              <td>".$remito['retira']."</td>
              <td class='goright'>$ ".number_format ($remito['monto_total'], 2, ',', '.')."</td>
              <td class='goright'>$ ".number_format ($remito['monto_ctacte'], 2, ',', '.')."</td>
              <td class='goright'>$ ".number_format ($subtotal, 2, ',', '.')."</td>
            </tr>";
      $total += $subtotal;
    }
    echo "<tr>
            <td colspan='6' class='goright'>TOTAL:</td>
            <td class='goright'>$ ".number_format ($total, 2, ',', '.')."</td>
          </tr>
        </table>";
    
  }
  else if ($proceso == 'entregar') { // Entrega de pagos (aprobadas)
    $total = 0;
    $remitos = array();
    //showall ($_REQUEST);
    ?>
    <form autocompĺete='off' action="../c/pnllq-deliver-validate.php" method="post" id="checkform">
    <input type="hidden" name="estado" id="estado" value="<?=$estado;?>">
    <input type="hidden" name="valstring" id="valstring" value="<?=$valstring;?>">
    <?php
    echo "<table class='results cx'>
            <tr>
              <th>REMITO</th>
              <th>cirugías</th>
              <th>acreedor</th>
              <th>retira</th>
              <th>monto</th>
              <th>cta/cte</th>
              <th>subtotal</th>
            </tr>";
    $total = 0;
    foreach ($rems as $key=>$value) {
      $remito = data_remito ($value);
      $subtotal = $remito['monto_total'] - $remito['monto_ctacte'];
      $retira = $remito['retira'];
      echo "<tr>
              <td class='goleft'>
                <input type='hidden' name='rem_".$remito['id_remito']."' value='".$remito['id_remito']."'>
                N° ".$remito['id_remito']."<br>PREP: ".$remito['fecha_prep_h']."
              </td>
              <td>";
      $cxsr = cxs_en_remito ($remito['id_remito']);
      foreach ($cxsr as $cr) {
        echo $cr['nro_cirugia']." (".$cr['fecha_cx_h']." pac. ".$cr['nombre_paciente'].")<br>";
      }
              /*
                ".$remito['nro_cirugia']." (".$remito['fecha_cx_h'].")<br>
                Dr. ".$remito['medico']."<br>
                pac. ".$remito['paciente']."<br>
              
              */
      echo "</td>
            <td>".$remito['medico']."</td>
              <td>".$remito['retira']."</td>
              <td class='goright'>$ ".number_format ($remito['monto_total'], 2, ',', '.')."</td>
              <td class='goright'>$ ".number_format ($remito['monto_ctacte'], 2, ',', '.')."</td>
              <td class='goright'>$ ".number_format ($subtotal, 2, ',', '.')."</td>
            </tr>";
      $total += $subtotal;
    }
    echo "<tr>
            <td colspan='6' class='goright'>TOTAL:</td>
            <td class='goright'>$ ".number_format ($total, 2, ',', '.')."</td>
          </tr>
        </table>";
  }
  else { // Impresión de remitos (liquidadas)
    $total = 0;
    $remitos = array();
    //showall ($_REQUEST);
    ?>
    <form autocompĺete='off' action="../v/appprint.php" method="post" id="checkform">
    <input type="hidden" name="estado" id="estado" value="<?=$estado;?>">
    <input type="hidden" name="valstring" id="valstring" value="<?=$valstring;?>">
    <?php
    echo "<table class='results cx'>
            <tr>
              <th>REMITO</th>
              <th>cirugías</th>
              <th>acreedor</th>
              <th>retira</th>
              <th>monto</th>
              <th>cta/cte</th>
              <th>subtotal</th>
            </tr>";
    $total = 0;
    foreach ($rems as $key=>$value) {
      $remito = data_remito ($value);
      $subtotal = $remito['monto_total'] - $remito['monto_ctacte'];
      $retira = $remito['retira'];
      echo "<tr>
              <td class='goleft'>
                <input type='hidden' name='rem_".$remito['id_remito']."' value='".$remito['id_remito']."'>
                N° ".$remito['id_remito']."<br>PREP: ".$remito['fecha_prep_h']."
              </td>
              <td>";
      $cxsr = cxs_en_remito ($remito['id_remito']);
      foreach ($cxsr as $cr) {
        echo $cr['nro_cirugia']." (".$cr['fecha_cx_h']." pac. ".$cr['nombre_paciente'].")<br>";
      }
              /*
                ".$remito['nro_cirugia']." (".$remito['fecha_cx_h'].")<br>
                Dr. ".$remito['medico']."<br>
                pac. ".$remito['paciente']."<br>
              
              */
      echo "</td>
            <td>".$remito['medico']."</td>
              <td>".$remito['retira']."</td>
              <td class='goright'>$ ".number_format ($remito['monto_total'], 2, ',', '.')."</td>
              <td class='goright'>$ ".number_format ($remito['monto_ctacte'], 2, ',', '.')."</td>
              <td class='goright'>$ ".number_format ($subtotal, 2, ',', '.')."</td>
            </tr>";
      $total += $subtotal;
    }
    echo "<tr>
            <td colspan='6' class='goright'>TOTAL:</td>
            <td class='goright'>$ ".number_format ($total, 2, ',', '.')."</td>
          </tr>
        </table>";
  }
  if ($proceso == 'preparar') {
    $vendedores = lista_vendedores();
    //print_r ($vendedores);
    echo "<!-- Versión sin portador
          <div class='supertotal'>
            <div>
              Acreedor: <input type='text' autocompĺete='off' list='medicos' id='medico' name='medico' class='input-text' style='width:30rem'>
            </div>
            <div>
              Importe cta/cte:</span>";
              ?>
              <input type="text" autocompĺete="off" name="pagocc" id="pagocc" autocomplete="off" class="input-text goright" value="0" style="width:7rem" onblur="resValue(this, 'pagocx_<?=$cir;?>')" onfocus="subValue(this, 'pagocx_<?=$cir;?>', 'pagocc_<?=$cir."_".$cxy['id_cirugia_sys'];?>')">
            </div>
            <div>
              <select name="portador" id="portador">
                <option value="x">portador</option>
                <?php
                foreach ($vendedores as $vendedor) {
                  echo "<option value='".$vendedor['id_vendedor_sys']."'";
                  if ($vendedor['id_vendedor'] == $cod_vendedor) echo " selected";
                  echo ">".$vendedor['vendedor']."</option>";
                }
                ?>
              </select>
            </div>
            <div>
              $ <span id='supertotal'>0</span>
            </div>
          Fin versión sin portador -->
          <table class='supertotabla'>
            <tr>
              <td style='width:50%'>
                Acreedor: <input type='text' autocompĺete='off' list='medicos' id='medico' name='medico' class='input-text' style='width:30rem'>
              </td>
              <td rowspan='2' style='width:25%'>
                Importe cta/cte:
                <input type="text" autocompĺete="off" name="pagocc" id="pagocc" autocomplete="off" class="input-text goright" value="0" style="width:7rem" onblur="resValue(this, 'pagocx_<?=$cir;?>')" onfocus="subValue(this, 'pagocx_<?=$cir;?>', 'pagocc_<?=$cir."_".$cxy['id_cirugia_sys'];?>')">
              </td>
              <td rowspan='2' class='total-preparar'>$ <span id='supertotal'>0</span></td>
            </tr>
            <tr>
              <td>
                RETIRA: <select name="portador" id="portador" class="input-text">
                  <option value="x">N/A</option>
                  <?php
                  foreach ($vendedores as $vendedor) {
                    echo "<option value='".$vendedor['id_vendedor_sys']."'";
                    if ($vendedor['id_vendedor'] == $cod_vendedor) echo " selected";
                    echo ">".$vendedor['vendedor']."</option>";
                  }
                  ?>
                </select>
              </td>
            </tr>
          </table>
          <?php
  }
  ?>
    <input type="hidden" name="valstring" id="valstring" value="<?=$valstring;?>">
    <input type="hidden" name="filters" id="filters" value="<?=$_REQUEST['filters'];?>">
    <input type="hidden" name="return" value="<?=$returnstring;?>">
  <div class='gocenter'>
    <!--<a href='#' onclick="document.getElementById('formprep').submit()" class='buttons-standalone'><?=$proceso;?> marcadas</a>-->
<?php
if ($proceso == 'preparar') {?><input type="submit" value="REGISTRAR" class='buttons-standalone'><?php }
else if ($proceso == 'imprimir') {?><input type="submit" value="<?=$proceso;?>" class='buttons-standalone'><?php }
else { ?><a href='#' onclick="document.getElementById('checkform').submit()" class='buttons-standalone'><?=$proceso;?> </a><?php  }
?>
  </div>
  
  </form>
  <span id='testob' style='visibility: hidden;'>0</span>
  <script>
    function addValue(sender, cx) {
      let buff = parseFloat(document.getElementById('testob').innerHTML);
      if ((isNaN(parseFloat(buff)) && isNaN(buff - 0)) || buff < 0) buff = 0;
      let valor = parseFloat(sender.value.toString());
      if ((isNaN(parseFloat(valor)) && isNaN(valor - 0)) || valor < 0) valor = 0;
      let dat1 = parseFloat(document.getElementById(cx).innerHTML);
      let dat = parseFloat(document.getElementById('supertotal').innerHTML);
      let imprime = (dat - buff) + valor;
      let imprime1 = (dat1 - buff) + valor;
      document.getElementById('testob').innerHTML = imprime; 
      document.getElementById('supertotal').innerHTML = imprime;
      document.getElementById(cx).innerHTML = imprime1;
    }
    function resValue(sender, cx) {
      let buff = parseFloat(document.getElementById('testob').innerHTML);
      if ((isNaN(parseFloat(buff)) && isNaN(buff - 0)) || buff < 0) buff = 0;
      let valor = parseFloat(sender.value.toString());
      if ((isNaN(parseFloat(valor)) && isNaN(valor - 0)) || valor < 0) valor = 0;
      //let dat = parseFloat(document.getElementById(cx).innerHTML);
      let dat = parseFloat(document.getElementById('supertotal').innerHTML);
      let imprime = (dat - buff) - valor;
      document.getElementById('testob').innerHTML = imprime; 
      document.getElementById('supertotal').innerHTML = imprime;
    }
    function subValue(sender, cx, monto) {
      let valor = parseFloat(sender.value.toString());
      if ((isNaN(parseFloat(valor)) && isNaN(valor - 0)) || valor < 0) valor = 0;
      document.getElementById('testob').innerHTML = valor; 
    }
  </script>
  <?php
  if (isset ($_REQUEST['errform'])) {
    if ($_REQUEST['errform'] == 1) $msgerror = "una cirugía marcada requiere un acrredor";
    if ($_REQUEST['errform'] == 2) $msgerror = "no se pudo conectar a la base de datos";
    if ($_REQUEST['errform'] == 3) $msgerror = "falta un dato importante";
    echo "<div class='error-msg'>".$msgerror."</div>";
  }
}
?>