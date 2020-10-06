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
  echo "<div class='simple-line'>Puede cancelar esta liquidación haciendo click en el botón CANCELAR para retornar al Panel de Cirugías (no se perderán los filtros previamente utilizados).</div><br><div class='simple-line'><a href='default.php?page=pnlcx".$returnstring."' class='buttons'>CANCELAR</a></div>";
  echo "<table class='results cx'>";
  $total = 0;
  foreach ($cxs as $cx=>$value) {
    $info = data_cx ($value);
    $total += $info['monto'];
    echo "<tr>
            <td>CX ".$value."</td>
            <td>Fecha: ".$info['fecha_cx']."</td>
            <td>Paciente: ".$info['paciente']."</td>
            <td>Médico: ".$info['medico']."</td>
            <td class='goright'>$ ".number_format ($info['monto'], 2, ',', '.')."</td>
          </tr>";
  }
  echo "<tr>
          <td colspan='4' class='goright'>TOTAL:</td>
          <td class='goright'>$ ".number_format ($total, 2, ',', '.')."</td>
        </tr>
      </table>";
}
?>
