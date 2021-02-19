<?php
require_once ('../c/funcs/common.php');
if (isset ($_REQUEST['sent'])) {
  $clue = sanitizeThis ($_REQUEST['srchcx']);
  $vendcx = sanitizeThis ($_REQUEST['vendcx']);
  $instcx = sanitizeThis ($_REQUEST['instcx']);
  $cliencx = sanitizeThis ($_REQUEST['cliencx']);
  $acr = sanitizeThis ($_REQUEST['acr']);
  $fin = sanitizeThis ($_REQUEST['fin']);
  $remito = sanitizeThis ($_REQUEST['remito']);
}
else {
  $clue = "";
  $vendcx = "";
  $instcx = "";
  $acr = "";
  $fin = "";
}
?>
<h2>Panel de cirugías</h2>
<form action="default.php?page=pnlcx" method="post">
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
    <span class='left-margin'>Remito N° (anula demás filtros):</span> <input type="text" name="remito" id="remito" autocomplete="off" class="input-text gocenter" style='width:5rem;' value="<?php echo $remito;?>"></span>
  </div>
  <div class="form-line">
    Acreedor: <input type="text" name="acr" id="acr" autocomplete="off" class="input-text" value="<?php echo $acr;?>"  list='medicos'>
    <span class='left-margin'>Cliente:</span> <input type="text" name="fin" id="fin" autocomplete="off" class="input-text" value="<?php echo $fin;?>" list='clientes'>
    <span class='left-margin'>Mostrar:</span> <select name="estado" id="estado" class='input-text'>
      <!--<option value="0"<?php if ($_REQUEST['estado'] == '0') echo " selected"?>>TODAS</option>-->
      <option value="1"<?php if ($_REQUEST['estado'] == '1') echo " selected"?>>PENDIENTES</option>
      <option value="2"<?php if ($_REQUEST['estado'] == '2') echo " selected"?>>PREPARADAS</option>
      <option value="3"<?php if ($_REQUEST['estado'] == '3') echo " selected"?>>FINALIZADAS</option>
      <option value="4"<?php if ($_REQUEST['estado'] == '4') echo " selected"?>>APROBADAS</option>
    </select>
    <input type="hidden" name="sent" value="1">
    <input type="submit" value="BUSCAR" class='buttons-inline pnlcx-btn'>
  </div>
</form>
<?php
if (isset ($_REQUEST['sent']) && $remito == '') {
  $resultados = search_cx (
    $clue,
    $vendcx,
    $instcx,
    $acr,
    $fin,
    $_REQUEST['estado'],
    $_REQUEST['mescxd'],
    $_REQUEST['anocxd'],
    $_REQUEST['mescxh'],
    $_REQUEST['anocxh'],
    $_REQUEST['meslqd'],
    $_REQUEST['anolqd'],
    $_REQUEST['meslqh'],
    $_REQUEST['anolqh'],
  );
  if (count ($resultados) < 1) echo "<p class='error-msg'>no se encontraron resultados</p>";
  else {
    $filterstring = $clue."!?".$vendcx."!?".$instcx."!?".$acr."!?".$fin."!?".$_REQUEST['estado']."!?".$_REQUEST['mescxd']."!?".$_REQUEST['anocxd']."!?".$_REQUEST['mescxh']."!?".$_REQUEST['anocxh']."!?".$_REQUEST['meslqd']."!?".$_REQUEST['anolqd']."!?".$_REQUEST['meslqh']."!?".$_REQUEST['anolqh'];
    $elegibles= 0;
    if ($_REQUEST['estado'] == '1') { // Mostrar solo pendientes
      $cantcx = 0;
      ?>
      <form action='default.php?page=pnllq' method='post' id='checkform'>
      <br>
      <div class='mostrandores'>
        <span>Mostrando <span id='cantcx'></span> resultados:</span>
          <?php
          if (isset ($_REQUEST['errchk'])) echo "<span class='error-text'>No se indicaron cirugías para liquidar</span>";
          ?>
      </div>
      <?php
      $idcxold = 'x';
      $first_record = true;
      $total = 0;
      
      foreach ($resultados as $resultado) {
        if ($resultado['estado'] == '1') {
          // Pendiente
          $procesar = "preparar";
        }
        else if ($resultado['estado'] == '2') {
          // Preparada
          $procesar = "liquidar";
        }
        else {
          // Liquidada
          $procesar = "imprimir";
        }
        if ($resultado['nro_cirugia'] != $idcxold) {
          if (!$first_record) {
            echo "<tr>
                    <td class='subh goright' colspan='4'>Total $<span class='total'>".number_format($total, 2, ',', '.')."</span></td>
                  </tr>
                </table>";
            $total = 0;
          }
          //Print new header
          $cantcx++;
          echo "<table class='results cx'>
                  <tr>
                    <th colspan='2'class='goleft'>CX ".$resultado['nro_cirugia']." (".$resultado['fecha_cx_h']."), Dr. ".$resultado['medico']."</th>
                    <th rowspan='4' colspan='2' class='goright'>";
          /* v1
          if ($resultado['estado'] == '3') echo "<a href='default.php?page=pnlcx&sent=1&remito=".$resultado['id_remito']."' class='buttons'>REMITO ".$resultado['id_remito']."</a>";
          else {
            echo "<input type='checkbox' id='chkb_".$resultado['nro_cirugia']."' name='chkb_".$resultado['nro_cirugia']."'>
                      <label for='chkb_".$resultado['nro_cirugia']."'>
                        <span></span>
                        ".$procesar."
                      </label> ";
            $elegibles++;
          }
          */
          //echo $resultado['estado'];
          if ($resultado['estado'] == '3') echo "<a href='default.php?page=pnlcx&sent=1&remito=".$resultado['id_remito']."' class='purple-link'>REMITO ".$resultado['id_remito']."</a><br><br>";
          if ($resultado['estado'] == '1') {
            echo "<input type='checkbox' id='chkb_".$resultado['nro_cirugia']."' name='chkb_".$resultado['nro_cirugia']."'>
                      <label for='chkb_".$resultado['nro_cirugia']."'>
                        <span></span>
                        ".$procesar."
                      </label> ";
            
          }
          else if ($resultado['estado'] == '3') {
            echo "<input type='checkbox' id='chkr_".$resultado['id_remito']."' name='chkr_".$resultado['id_remito']."'>
                      <label for='chkr_".$resultado['id_remito']."'>
                        <span></span>
                        ".$procesar."
                      </label> ";
          }
          $elegibles++;
          echo "</th>
                  </tr>
                  <tr>
                    <th colspan='3'class='goleft'>Institución: ".$resultado['institucion']."</th>
                  </tr>
                  <tr>
                    <th colspan='3'class='goleft'>Vendedor: ".$resultado['nombre_vendedor']." / Paciente: ".$resultado['nombre_paciente']."</th>
                  </tr>
                  <tr>
                    <th colspan='3'class='goleft'>Cliente: ".$resultado['cliente']."</th>
                  </tr>
                  <tr>
                    <td class='subh'>PRODUCTOS</td>
                    <td class='subh gocenter' style='width:7rem;'>CANTIDAD</td>
                    <td class='subh gocenter cx_column_mid'>VALOR</td>
                    <td class='subh gocenter cx_column_mid' style='width:fit-content;'>SUBTOTAL</td>
                  </tr>
                  <tr>
                    <td>".$resultado['producto']."</td>
                    <td class='cell-cantidad'>".$resultado['cantidad']."</td>
                    <td class='cell-cash'>".number_format($resultado['precio_venta'], 2, ',', '.')."</td>
                    <td class='cell-cash'>".number_format($resultado['subtotal'], 2, ',', '.')."</td>
                  </tr>";
          $idcxold = $resultado['nro_cirugia'];
          $total += $resultado['subtotal'];
        }
        else {
          echo "<tr>
                  <td>".$resultado['producto']."</td>
                  <td class='cell-cantidad'>".$resultado['cantidad']."</td>
                  <td class='cell-cash'>".number_format($resultado['precio_venta'], 2, ',', '.')."</td>
                  <td class='cell-cash'>".number_format($resultado['subtotal'], 2, ',', '.')."</td>
                </tr>";
          $idcxold = $resultado['nro_cirugia'];
          $total += $resultado['subtotal'];
        }
        $first_record = false;
      }
      echo "<tr>
              <td class='subh goright' colspan='4'>Total $<span class='total'>".number_format($total, 2, ',', '.')."</span></td>
            </tr>
          </table>";
    }
    else if ($_REQUEST['estado'] == '3') { // Ver solo finalizadas
      ?>
        <!--<form action='appprint.php' method='post' id='checkform'>-->
      <div class="pagadoreal">
        <div class='block-resumen'>total facturado: $ <span class='monto-resumen' id='tfacturado'>0</span></div>
        <div class='block-resumen'>total pagado: $ <span class='monto-resumen' id='tpagado'>0</span></div>
        <div class='block-resumen'>real pagado: <span class='monto-resumen' id='treal'>0</span> %</div>
      </div>
      <form action='default.php?page=pnllq' method='post' id='checkform'>
      <?php
      $remitos = search_remitos ($clue,
                                  $vendcx,
                                  $instcx,
                                  $acr,
                                  $fin,
                                  $_REQUEST['estado'],
                                  $_REQUEST['mescxd'],
                                  $_REQUEST['anocxd'],
                                  $_REQUEST['mescxh'],
                                  $_REQUEST['anocxh'],
                                  $_REQUEST['meslqd'],
                                  $_REQUEST['anolqd'],
                                  $_REQUEST['meslqh'],
                                  $_REQUEST['anolqh']);
      $procesar = 'imprimir';
      $remitox = array();
      $total_facturado = 0;
      foreach ($resultados as $cx) {
        $total_facturado += $cx['precio_venta'];
        if (!in_array ($cx['id_remito'], $remitox)) {
          $remitox[] = $cx['id_remito'];
        }
      }
      $total_pagado = 0;
      foreach ($remitox as $remi) {
        $elegibles++;
        $data = detalle_remito ($remi);
        
        echo "<table class='results cx'>
                <tr>
                  <th class='goleft' colspan='4'>Remito N° ".$data[0]['id_remito']." (Prep: ".$data[0]['fecha_preparado_h']." - Liq: ".$data[0]['fecha_liquidado_h'].")</th>
                  <th class='goright' rowspan='3'>
                    <a href='default.php?page=pnlcx&sent=1&remito=".$data[0]['id_remito']."' class='purple-link'>VER REMITO</a><br><br>
                    <input type='checkbox' id='chkr_".$data[0]['id_remito']."' name='chkr_".$data[0]['id_remito']."'>
                    <label for='chkr_".$data[0]['id_remito']."'>
                    <span></span>".$procesar."</label>
                  </th>
                </tr>
                <tr>
                  <th class='goleft' colspan='4'>
                    Acreedor: ".$data[0]['acreedor']."
                  </th>
                </tr>
                <tr>
                  <th class='goleft' colspan='4'>
                    Retira: ".$data[0]['retira']."
                  </th>
                </tr>";
        foreach ($data as $resultado) {
          echo "<tr>
                  <td style='width:12%;'>CX ".$resultado['nro_cirugia']."<br>(".$resultado['fecha_cx_h'].")</td>
                  <td style='width:30%;'>CIR: ".$resultado['medico']."<br>PAC: ".$resultado['paciente']."</td>
                  <td style='width:46%;' colspan='2'>INST: ".$resultado['institucion']."<br>CLI: ".$resultado['cliente']."</td>
                  <td class='goright' style='width:12%;'>$ ".number_format(total_cx($resultado['nro_cirugia']), 2, ',', '.')."</td>
                </tr>";
        }
        $apagar = $data[0]['total_remito'] - $data[0]['descuento'];
        echo "<tr>
                <td colspan='5' class='subh'>
                  <div class='fsb'>
                    <span>SUBTOTAL: $ ".number_format($data[0]['total_remito'], 2, ',', '.')."</span>
                    <span>SALDO: $ ".number_format($data[0]['saldo_previo'], 2, ',', '.')."</span>
                    <span>DESCUENTO: $ ".number_format($data[0]['descuento'], 2, ',', '.')."</span>
                    <span>TOTAL: $ ".number_format($apagar, 2, ',', '.')."</span>
                  </div>
                </td>
              </tr>
            </table>";
        $total_pagado += $apagar;
      }
      $total_facturado = number_format($total_facturado, '2', ',', '.');
      $total_pagado = number_format($total_pagado, '2', ',', '.');
      $real = number_format((($total_pagado * 100) / $total_facturado), 2, ',', '.');
      ?>
      <script>
      document.getElementById("tfacturado").innerHTML = '<?=$total_facturado?>';
      document.getElementById("tpagado").innerHTML = '<?=$total_pagado?>';
      document.getElementById("treal").innerHTML = '<?=$real?>';
      </script>
      <?php
    }
    else if ($_REQUEST['estado'] == '2') { // Ver solo preparadas
      $cantcx = 0;
      ?>
      <form action='default.php?page=pnllq' method='post' id='checkform'>
      <br>
      <div class='mostrandores'>
        <span>Mostrando <span id='cantcx'></span> resultados:</span>
          <?php
          if (isset ($_REQUEST['errchk'])) echo "<span class='error-text'>No se indicaron cirugías para liquidar</span>";
          ?>
      </div>
      <?php
      // $instcx
      $remitos = search_remitos (
        $clue,
        $vendcx,
        $instcx,
        $acr,
        $fin,
        $_REQUEST['estado'],
        $_REQUEST['mescxd'],
        $_REQUEST['anocxd'],
        $_REQUEST['mescxh'],
        $_REQUEST['anocxh'],
        $_REQUEST['meslqd'],
        $_REQUEST['anolqd'],
        $_REQUEST['meslqh'],
        $_REQUEST['anolqh']
      );
      /*
      echo "<p><pre>";
      print_r ($remitos);
      echo "</pre></p>";
      */
      $old_remito = 'x';
      foreach ($remitos as $remito) {
        if ($remito['id_remito'] != $old_remito) {
          if ($old_remito != 'x') {
            
            echo "<tr>
                    <td class='subh goright'>
                      SUBTOTAL: $ ".number_format($old_subt, 2, ',', '.')."
                    </td>
                    <td class='subh goright'>
                      SALDO: $ ".number_format($old_saldo, 2, ',', '.')."
                    </td>
                    <td class='subh goright'>
                      DESC: $ ".number_format($old_ctacte, 2, ',', '.')."
                    </td>
                    <td class='subh goright'>
                      PAGO: $ ".number_format($old_pago, 2, ',', '.')."
                    </td>
                  </tr></table>";
                  
          }
          $retira = ($remito['retira'] == '') ? 'N/A' : $remito['retira'];
          echo "<table class='results cx'>
                  <tr>
                    <th class='goleft' colspan='3'>
                      REMITO ".$remito['id_remito']." (".$remito['fecha_preparado_h'].") ACREEDOR: ".$remito['acreedor']." - RETIRA: ".$retira."
                    </th>
                    <th style='width:10rem;'>";
                    echo "<input type='checkbox' id='chkb_".$remito['id_remito']."' name='chkb_".$remito['id_remito']."'>
                    <label for='chkb_".$remito['id_remito']."'>
                      <span></span>
                      LIQUIDAR
                    </label> ";
                    $elegibles++;
                  echo "</th>
                  </tr>
                  <!--
                  <tr>
                    <td class='subh goright'>
                      SUBTOTAL: $ ".number_format($remito['monto_total'], 2, ',', '.')."
                    </td>
                    <td class='subh goright'>
                      SALDO: $ ".number_format($remito['saldo_pre'], 2, ',', '.')."
                    </td>
                    <td class='subh goright'>
                      DESC: $ ".number_format($remito['monto_ctacte'], 2, ',', '.')."
                    </td>
                    <td class='subh goright'>
                      PAGO: $ ".number_format($remito['total'], 2, ',', '.')."
                    </td>
                  </tr>-->";
          $cantcx++;
          $cxs = cxs_en_remito ($remito['id_remito']);
          foreach ($cxs as $cx) {
            $cx_subtotal = cx_subtotal ($cx['nro_cirugia']);
            echo "<tr><td colspan='3'>";
            echo "CX ".$cx['nro_cirugia']." (".$cx['fecha_cx_h'].") - Dr. ".$cx['cirujano']." - Pac. ".$cx['nombre_paciente']."<br>Institución: ".$cx['institucion'];
            echo "</td><td class='goright'>$ ".number_format($cx_subtotal, 2, ',', '.')."</td></tr>";
          }
          /*
                  <tr>
                    <td>";
                    $cxs = cxs_en_remito ($remito['id_remito']);
                    echo "<pre>";
                    print_r ($cxs);
                    echo "</pre>";
                  echo "</td>
                  </tr>";
          */
          $old_remito = $remito['id_remito'];
          $old_subt = $remito['monto_total'];
          $old_saldo = $remito['saldo_pre'];
          $old_ctacte = $remito['monto_ctacte'];
          $old_pago = $remito['total'];
        }
      }
      echo "<tr>
              <td class='subh goright'>
                SUBTOTAL: $ ".number_format($remito['monto_total'], 2, ',', '.')."
              </td>
              <td class='subh goright'>
                SALDO: $ ".number_format($remito['saldo_pre'], 2, ',', '.')."
              </td>
              <td class='subh goright'>
                DESC: $ ".number_format($remito['monto_ctacte'], 2, ',', '.')."
              </td>
              <td class='subh goright'>
                PAGO: $ ".number_format($remito['total'], 2, ',', '.')."
              </td>
            </tr></table>";
    }
    if ($elegibles > 0) {
      echo "<input type='hidden' name='filters' value='".$filterstring."'>
      <div class='goright'><a href='#' onclick=\"document.getElementById('checkform').submit()\" class='buttons'>CONTINUAR</a></div></form>";
    }
  }
}
else if (isset ($_REQUEST['sent']) && $remito != '') {
  $cxs = cxs_en_remito ($remito);
  if (count ($cxs) < 1) echo "<div class='error-msg'>No se encontraron resultados</div>";
  else {
    echo "<br><div class='mostrandores'>Mostrando detalle de remito n° ".$remito.":</div>";
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
        echo "<br><table class='data-remito'>
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
              </table>";
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
              <td class='subh gocenter' style='width:8rem;'>pagado</td>
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
    }
  }
}
?>
<script>
  document.getElementById("cantcx").innerHTML = <?=$cantcx;?>
</script>