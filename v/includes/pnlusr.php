<?php
require_once ('../c/funcs/common.php');
if (isset ($_REQUEST['sent'])) {
  $clue = sanitizeThis ($_REQUEST['srchusr']);
}
else {
  $clue = "";
}
?>
<h2>Panel de usuarios</h2>
<form action="default.php?page=pnlusr" method="post">
  <div class="formcontainer">
    <div class="formcell"><input type="text" name="srchusr" id="srchusr" autofocus autocomplete="off" class="input-text" value="<?php echo $clue;?>"></div>
    <div class="formcell"><input type="hidden" name="sent" value="1"><input type="submit" value="BUSCAR" class='buttons-inline'></div>
  </div>
</form>
<?php
// ../c/pnlusr-srch.php
if (isset ($_REQUEST['sent'])) {
  //El formulario fue enviado
  /*
  echo "<pre>";
  print_r($_REQUEST);
  echo "</pre>";
  */
  require_once ('../c/funcs/utilities.php');
  //echo "<p>$clue</p>";
  $resultados = searchUsuarios ($clue);
  if (count ($resultados) < 1) echo "<p>SIn resultados</p>";
  else {
    foreach ($resultados as $resultado) {
      echo "<p>".$resultado['usuario_apellido']." ".$resultado['usuario_nombre']." (".$resultado['usuario_nick'].")</p>";
    }
  }
}
?>