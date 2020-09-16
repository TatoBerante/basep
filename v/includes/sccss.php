<h2>Operación exitosa</h2>
<?php
if ($_REQUEST['org'] == 'appusr' && $_REQUEST['actflag'] == 'new') {
  echo "<p class='sccss-msg'>Usuario ".$_REQUEST['nickusr']." creado correctamente.</p>";
}
if ($_REQUEST['org'] == 'appusr' && $_REQUEST['actflag'] == 'mod') {
  echo "<p class='sccss-msg'>Usuario ".$_REQUEST['nickusr']." modificado correctamente.</p>";
}
?>