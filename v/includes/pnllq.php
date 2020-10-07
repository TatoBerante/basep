<h2>Liquidación</h2>
<?php
require_once ('../c/funcs/utilities.php');
$filtros = explode ('!?', $_REQUEST['filters']);

$returnstring = "&sent=1&srchcx=".$filtros[0]."&vendcx=".$filtros[1]."&instcx=".$filtros[2]."&acr=".$filtros[3]."&fin=".$filtros[4]."&estado=".$filtros[5]."&mescxd=".$filtros[6]."&anocxd=".$filtros[7]."&mescxh=".$filtros[8]."&anocxh=".$filtros[9]."&meslqd=".$filtros[10]."&anolqd=".$filtros[11]."&meslqh=".$filtros[12]."&anolqh=".$filtros[13];

?>
<?php
$cantcx = 0;
$cxs = array();
foreach ($_REQUEST as $key=>$dato) {
  $dato = explode ('_', $key);
  if ($dato[0] == 'chkb') {
    $cxs[] = $dato[1];
    $cantcx++;
  }
}
if ($cantcx < 1) echo "<div class='simple-line'>No se indicaron cirugías para liquidar. Haga click en el botón VOLVER para retornar al Panel de Cirugías (no se perderán los filtros previamente utilizados).</div><br><div class='simple-line'><a href='default.php?page=pnlcx".$returnstring."' class='buttons'>VOLVER</a></div>";
else {
  $medicos = lista_medicos();

  echo "<div class='simple-line gocenter warning'>Puede cancelar esta liquidación haciendo click en el botón CANCELAR para retornar al Panel de Cirugías (no se perderán los filtros previamente utilizados)<br><a href='default.php?page=pnlcx".$returnstring."' class='buttons-warning'>CANCELAR</a></div>";

  // Display cx seleccionadas:
  echo "<table class='results cx'>";
  $total = 0;
  foreach ($cxs as $cx=>$value) {
    $info = data_cx ($value);
    $pagable = ($info['monto'] * $info['aplicable']) / 100;
    $total += $pagable;
    echo "<tr>
            <td>CX ".$value."<br>Fecha: ".$info['fecha_cx']."</td>
            <td>Médico: ".$info['medico']."<br>Paciente: ".$info['paciente']."</td>
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
  // Fin de display cx seleccionadas

  // Seleccionar acreedor:
  /*
  echo "Acreedor: <select name='acr' id='acr' class='input-text'>
          <option value='x'>seleccione un acreedor</option>";
  foreach ($medicos as $medico) {
    echo "<option value='".$medico['id_medico_sys']."'>".$medico['medico']."</option>";
  }
  echo "</select>";
  */
  
  ?>
  <datalist id='medicos'>
  <?php
  foreach ($medicos as $medico) {
    echo "<option value='".$medico['id_medico_sys']." - ".$medico['medico']." (SALDO: $ ".$medico['saldo'].")'>";
  }
  ?>
  </datalist>
  <div class="simple-line gocenter">
    Acreedor: <input type='text' list='medicos' id='medico' class='input-text' style='width:30rem'>
    <span class='left-margin'>Importe cta/cte:</span> <input type="text" name="pagocc" id="pagocc" autocomplete="off" class="input-text goright" value="<?php echo $pagocc;?>" style='width:7rem'>
    <span class='left-margin'>Importe remito:</span> <input type="text" name="pago" id="pago" autocomplete="off" class="input-text goright" value="<?php echo $pago;?>" style='width:7rem'>
  </div>
  <?php
}
?>