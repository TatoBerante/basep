<?php
require_once ('../c/funcs/common.php');

if (isset ($_REQUEST['sent'])) {
  $clue = sanitizeThis ($_REQUEST['srchcx']);
  $vendcx = sanitizeThis ($_REQUEST['vendcx']);
  $instcx = sanitizeThis ($_REQUEST['instcx']);
  $cliencx = sanitizeThis ($_REQUEST['cliencx']);
  $acr = sanitizeThis ($_REQUEST['acr']);
  $fin = sanitizeThis ($_REQUEST['fin']);
  $remito_pedido = sanitizeThis ($_REQUEST['remito']);
}
else {
  $clue = "";
  $vendcx = "";
  $instcx = "";
  $acr = "";
  $fin = "";
}

/*
echo "<p><pre>";
print_r ($_REQUEST);
echo "</pre></p>";
*/

?>
<h2>Aprobar Pagos</h2>
<div class="note">
  IMPORTANTE: se mostrarán solamente remitos finalizados en el panel de cirugías.
</div>
<form action="default.php?page=pnlaprpay" method="post">
  <div class="form-line">
    <?php
    $medicos = lista_medicos();
    $vendedores = lista_vendedores();
    $clientes = lista_clientes();
    ?>
    <datalist id='medicos'>
    <?php
    foreach ($medicos as $medico) {
      echo "<option value='".$medico['medico']."'>";
    }
    ?>
    </datalist>
    <datalist id='vendedores'>
    <?php
    foreach ($vendedores as $vendedor) {
      echo "<option value='".$vendedor['vendedor']."'>";
    }
    ?>
    </datalist>
    <datalist id='clientes'>
    <?php
    foreach ($clientes as $cliente) {
      echo "<option value='".$cliente['cliente']." (".$cliente['empresa'].")'>";
    }
    ?>
    </datalist>
    Profesional: <input type="text" name="srchcx" id="srchcx" autofocus autocomplete="off" class="input-text" value="<?php echo $clue;?>" list='medicos'>
    <span class='left-margin'>Institución:</span> <input type="text" name="instcx" id="instcx" autocomplete="off" class="input-text" value="<?php echo $instcx;?>">
    <span class='left-margin'>Vendedor:</span> <input type="text" name="vendcx" id="vendcx" autocomplete="off" class="input-text" value="<?php echo $vendcx;?>" list='vendedores'>
  </div>
  <div class="form-line">
    Periodo CX desde: <select name='mescxd' id='mescxd' class='input-text'>
      <option value="NC"<?php if ($_REQUEST['mescxd'] == 'NC') echo " selected"?>>NC</option>
      <option value="01"<?php if ($_REQUEST['mescxd'] == '1') echo " selected"?>>Enero</option>
      <option value="02"<?php if ($_REQUEST['mescxd'] == '2') echo " selected"?>>Febrero</option>
      <option value="03"<?php if ($_REQUEST['mescxd'] == '3') echo " selected"?>>Marzo</option>
      <option value="04"<?php if ($_REQUEST['mescxd'] == '4') echo " selected"?>>Abril</option>
      <option value="05"<?php if ($_REQUEST['mescxd'] == '5') echo " selected"?>>Mayo</option>
      <option value="06"<?php if ($_REQUEST['mescxd'] == '6') echo " selected"?>>Junio</option>
      <option value="07"<?php if ($_REQUEST['mescxd'] == '7') echo " selected"?>>Julio</option>
      <option value="08"<?php if ($_REQUEST['mescxd'] == '8') echo " selected"?>>Agosto</option>
      <option value="09"<?php if ($_REQUEST['mescxd'] == '9') echo " selected"?>>Septiembre</option>
      <option value="10"<?php if ($_REQUEST['mescxd'] == '10') echo " selected"?>>Octubre</option>
      <option value="11"<?php if ($_REQUEST['mescxd'] == '11') echo " selected"?>>Noviembre</option>
      <option value="12"<?php if ($_REQUEST['mescxd'] == '12') echo " selected"?>>Diciembre</option>
    </select>
    <select name='anocxd' id="anocxd" class='input-text'>
      <option value="NC"<?php if ($_REQUEST['anocxd'] == 'NC') echo " selected"?>>NC</option>
    <?php
    for ($ap=date('Y'); $ap>(date('Y')-2); $ap--) {
      echo "<option value='".$ap."'";
      if ($_REQUEST['anocxd'] == $ap) echo " selected";
      echo ">".$ap."</option>";
    }
    ?>
    </select>
    <span class='left-margin'>hasta: </span><select name='mescxh' id='mescxh' class='input-text'>
      <option value="NC"<?php if ($_REQUEST['mescxh'] == 'NC') echo " selected"?>>NC</option>
      <option value="01"<?php if ($_REQUEST['mescxh'] == '1') echo " selected"?>>Enero</option>
      <option value="02"<?php if ($_REQUEST['mescxh'] == '2') echo " selected"?>>Febrero</option>
      <option value="03"<?php if ($_REQUEST['mescxh'] == '3') echo " selected"?>>Marzo</option>
      <option value="04"<?php if ($_REQUEST['mescxh'] == '4') echo " selected"?>>Abril</option>
      <option value="05"<?php if ($_REQUEST['mescxh'] == '5') echo " selected"?>>Mayo</option>
      <option value="06"<?php if ($_REQUEST['mescxh'] == '6') echo " selected"?>>Junio</option>
      <option value="07"<?php if ($_REQUEST['mescxh'] == '7') echo " selected"?>>Julio</option>
      <option value="08"<?php if ($_REQUEST['mescxh'] == '8') echo " selected"?>>Agosto</option>
      <option value="09"<?php if ($_REQUEST['mescxh'] == '9') echo " selected"?>>Septiembre</option>
      <option value="10"<?php if ($_REQUEST['mescxh'] == '10') echo " selected"?>>Octubre</option>
      <option value="11"<?php if ($_REQUEST['mescxh'] == '11') echo " selected"?>>Noviembre</option>
      <option value="12"<?php if ($_REQUEST['mescxh'] == '12') echo " selected"?>>Diciembre</option>
    </select>
    <select name='anocxh' id="anocxh" class='input-text'>
      <option value="NC"<?php if ($_REQUEST['anocxh'] == 'NC') echo " selected"?>>NC</option>
    <?php
    for ($ap=date('Y'); $ap>(date('Y')-2); $ap--) {
      echo "<option value='".$ap."'";
      if ($_REQUEST['anocxh'] == $ap) echo " selected";
      echo ">".$ap."</option>";
    }
    ?>
    </select>
  </div>
  <div class="form-line">
    Periodo LQ desde: <select name='meslqd' id='meslqd' class='input-text'>
      <option value="NC"<?php if ($_REQUEST['meslqd'] == 'NC') echo " selected"?>>NC</option>
      <option value="01"<?php if ($_REQUEST['meslqd'] == '1') echo " selected"?>>Enero</option>
      <option value="02"<?php if ($_REQUEST['meslqd'] == '2') echo " selected"?>>Febrero</option>
      <option value="03"<?php if ($_REQUEST['meslqd'] == '3') echo " selected"?>>Marzo</option>
      <option value="04"<?php if ($_REQUEST['meslqd'] == '4') echo " selected"?>>Abril</option>
      <option value="05"<?php if ($_REQUEST['meslqd'] == '5') echo " selected"?>>Mayo</option>
      <option value="06"<?php if ($_REQUEST['meslqd'] == '6') echo " selected"?>>Junio</option>
      <option value="07"<?php if ($_REQUEST['meslqd'] == '7') echo " selected"?>>Julio</option>
      <option value="08"<?php if ($_REQUEST['meslqd'] == '8') echo " selected"?>>Agosto</option>
      <option value="09"<?php if ($_REQUEST['meslqd'] == '9') echo " selected"?>>Septiembre</option>
      <option value="10"<?php if ($_REQUEST['meslqd'] == '10') echo " selected"?>>Octubre</option>
      <option value="11"<?php if ($_REQUEST['meslqd'] == '11') echo " selected"?>>Noviembre</option>
      <option value="12"<?php if ($_REQUEST['meslqd'] == '12') echo " selected"?>>Diciembre</option>
    </select>
    <select name='anolqd' id="anolqd" class='input-text'>
      <option value="NC"<?php if ($_REQUEST['anolqd'] == 'NC') echo " selected"?>>NC</option>
    <?php
    for ($ap=date('Y'); $ap>(date('Y')-2); $ap--) {
      echo "<option value='".$ap."'";
      if ($_REQUEST['anolqd'] == $ap) echo " selected";
      echo ">".$ap."</option>";
    }
    ?>
    </select>
    <span class='left-margin'>hasta: </span><select name='meslqh' id='meslqh' class='input-text'>
      <option value="NC"<?php if ($_REQUEST['meslqh'] == 'NC') echo " selected"?>>NC</option>
      <option value="01"<?php if ($_REQUEST['meslqh'] == '1') echo " selected"?>>Enero</option>
      <option value="02"<?php if ($_REQUEST['meslqh'] == '2') echo " selected"?>>Febrero</option>
      <option value="03"<?php if ($_REQUEST['meslqh'] == '3') echo " selected"?>>Marzo</option>
      <option value="04"<?php if ($_REQUEST['meslqh'] == '4') echo " selected"?>>Abril</option>
      <option value="05"<?php if ($_REQUEST['meslqh'] == '5') echo " selected"?>>Mayo</option>
      <option value="06"<?php if ($_REQUEST['meslqh'] == '6') echo " selected"?>>Junio</option>
      <option value="07"<?php if ($_REQUEST['meslqh'] == '7') echo " selected"?>>Julio</option>
      <option value="08"<?php if ($_REQUEST['meslqh'] == '8') echo " selected"?>>Agosto</option>
      <option value="09"<?php if ($_REQUEST['meslqh'] == '9') echo " selected"?>>Septiembre</option>
      <option value="10"<?php if ($_REQUEST['meslqh'] == '10') echo " selected"?>>Octubre</option>
      <option value="11"<?php if ($_REQUEST['meslqh'] == '11') echo " selected"?>>Noviembre</option>
      <option value="12"<?php if ($_REQUEST['meslqh'] == '12') echo " selected"?>>Diciembre</option>
    </select>
    <select name='anolqh' id="anolqh" class='input-text'>
      <option value="NC"<?php if ($_REQUEST['anolqh'] == 'NC') echo " selected"?>>NC</option>
    <?php
    for ($ap=date('Y'); $ap>(date('Y')-2); $ap--) {
      echo "<option value='".$ap."'";
      if ($_REQUEST['anolqh'] == $ap) echo " selected";
      echo ">".$ap."</option>";
    }
    ?>
    </select>
    <span class='left-margin'>Remito N° (anula demás filtros):</span> <input type="text" name="remito" id="remito" autocomplete="off" class="input-text gocenter" style='width:5rem;' value="<?php echo $remito_pedido;?>"></span>
  </div>
  <div class="form-line">
    Acreedor: <input type="text" name="acr" id="acr" autocomplete="off" class="input-text" value="<?php echo $acr;?>"  list='medicos'>
    <span class='left-margin'>Cliente:</span> <input type="text" name="fin" id="fin" autocomplete="off" class="input-text" value="<?php echo $fin;?>" list='clientes'>
    <!--
    <span class='left-margin'>Mostrar:</span> <select name="estado" id="estado" class='input-text'>
      <option value="1"<?php if ($_REQUEST['estado'] == '1') echo " selected"?>>PENDIENTES</option>
      <option value="2"<?php if ($_REQUEST['estado'] == '2') echo " selected"?>>PREPARADAS</option>
      <option value="3"<?php if ($_REQUEST['estado'] == '3') echo " selected"?>>FINALIZADAS</option>
      <option value="4"<?php if ($_REQUEST['estado'] == '4') echo " selected"?>>APROBADAS</option>
    </select>
    -->
    <input type="hidden" name="sent" value="1">
    <input type="submit" value="BUSCAR" class='buttons-inline pnlcx-btn'>
  </div>
</form>

<?php
if (isset ($_REQUEST['sent']) && $remito_pedido == '') {
  $remitos = search_remitos ($clue,
                            $vendcx,
                            $instcx,
                            $acr,
                            $fin,
                            3,
                            $_REQUEST['mescxd'],
                            $_REQUEST['anocxd'],
                            $_REQUEST['mescxh'],
                            $_REQUEST['anocxh'],
                            $_REQUEST['meslqd'],
                            $_REQUEST['anolqd'],
                            $_REQUEST['meslqh'],
                            $_REQUEST['anolqh']);
  
  if (count ($remitos) > 0) { // Se encontraron resultados
    /*
    echo "<p><pre>";
    print_r ($_REQUEST);
    echo "</pre></p>";
    */
    $remito_old = "";
    $cx_old = "";
    $first_record = true;
    foreach ($remitos as $remito) { // Recorrer resultados obtenidos
      if ($remito['id_remito'] != $remito_old && !$first_record) {
        echo "<tr>
                <td colspan=4>
                  <div class='flex-cont'>
                    <span>SUBTOTAL: $ 11111</span>
                    <span>SALDO: $ 999999</span>
                    <span>DESCUENTO: $ 999999</span>
                    <span>TOTAL: $ 999999</span>
                  </div>
                </td>
              </tr></table>";
      }
      if ($remito['id_remito'] != $remito_old) {
        echo "<table class='apr-pagos'>
                <tr>
                  <td colspan='3'>
                    REMITO ".$remito['id_remito']." (PREP: ".$remito['fecha_preparado_h']." / LIQ: ".$remito['fecha_liquidado_h'].")<br>
                    ACREEDOR: ".$remito['acreedor']."<br>
                    RETIRA: ".$remito['retira']."
                  </td>
                  <td class='goright' style='width:8rem;'>ACCIONES</td>
                </tr>";
        if ($remito['nro_cirugia'] != $cx_old) {
          $montos = montos_cx($remito['nro_cirugia']);
          echo "<tr>
                  <td style='width:9rem;'>
                    CX ".$remito['nro_cirugia']."<br>
                    (".$remito['fecha_cx_h'].")
                  </td>
                  <td style='width:25rem;'>
                    CIR: ".$remito['cirujano']."<br>
                    PAC: ".$remito['paciente']."
                  </td>
                  <td>
                    INST: ".$remito['institucion']."<br>
                    CLI: ".$remito['cliente']."<br>
                  </td>
                  <td class='goright'>
                    $ ".number_format($montos['valor_total'], 2, ',', '.')."<br>
                  </td>
                </tr>";
          $cx_old = $remito['nro_cirugia'];
        }
        $remito_old = $remito['id_remito'];
        $first_record = false;
      }
      else {
        if ($remito['nro_cirugia'] != $cx_old) {
          $montos = montos_cx($remito['nro_cirugia']);
          echo "<tr>
                  <td>
                    CX ".$remito['nro_cirugia']."<br>
                    (".$remito['fecha_cx_h'].")
                  </td>
                  <td>
                    CIR: ".$remito['cirujano']."<br>
                    PAC: ".$remito['paciente']."
                  </td>
                  <td>
                    INST: ".$remito['institucion']."<br>
                    CLI: ".$remito['cliente']."<br>
                  </td>
                  <td class='goright'>
                    $ ".number_format($montos['valor_total'], 2, ',', '.')."<br>
                  </td>
                </tr>";
          $cx_old = $remito['nro_cirugia'];
        }
        $remito_old = $remito['id_remito'];
      }
    }
    echo "<tr>
            <td colspan=4>
              <div class='flex-cont'>
                <span>SUBTOTAL: $ 33333</span>
                <span>SALDO: $ 999999</span>
                <span>DESCUENTO: $ 999999</span>
                <span>TOTAL: $ 999999</span>
              </div>
            </td>
          </tr></table>";
  }
  else { // No se encontraron resultados
    echo "<div class='error-msg'>No se encontraron resultados</div>";
  }
}
else if (isset ($_REQUEST['sent']) && $remito_pedido != '') {
  echo "<p>Se pidió el remito ".$remito_pedido."</p>";
}
?>