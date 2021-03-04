<h2>Operación exitosa</h2>
<?php
if ($_REQUEST['org'] == 'appusr' && $_REQUEST['actflag'] == 'new') {
  echo "<p class='sccss-msg'>Usuario ".$_REQUEST['nickusr']." creado correctamente.</p>";
}
if ($_REQUEST['org'] == 'appusr' && $_REQUEST['actflag'] == 'mod') {
  echo "<p class='sccss-msg'>Usuario ".$_REQUEST['nickusr']." modificado correctamente.</p>";
}
if ($_REQUEST['org'] == 'prep') {
  echo "<p class='sccss-msg'>Liquidación preparada correctamente.</p>";
}
if ($_REQUEST['org'] == 'liq') {
  echo "<p class='sccss-msg'>Liquidación finalizada correctamente.</p>";
}
if ($_REQUEST['org'] == 'deliv') {
  echo "<p class='sccss-msg'>Entrega de pagos finalizada correctamente.</p>";
}
?>