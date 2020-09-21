<?php
require_once ('../c/funcs/common.php');
if (isset ($_REQUEST['sent'])) {
  $clue = sanitizeThis ($_REQUEST['srchcli']);
}
else {
  $clue = "";
}
?>
<h2>Panel de clientes</h2>
<form action="default.php?page=pnlcli" method="post">
  <div class="formcontainer">
    <div class="formcell"><input type="text" name="srchcli" id="srchcli" autofocus autocomplete="off" class="input-text" value="<?php echo $clue;?>"></div>
    <div class="formcell"><input type="hidden" name="sent" value="1"><input type="submit" value="BUSCAR" class='buttons-inline'></div>
  </div>
</form>
<?php
if (isset ($_REQUEST['sent'])) {
  require_once ('../c/funcs/utilities.php');
  //echo "<p>$clue</p>";
  $start = (isset ($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
  $resultados = search_clientes ($clue, $start);
  if (count ($resultados) < 1) echo "<p class='error-msg'>no se encontraron resultados</p>";
  else {
    ?>
    <div class='simple-line'>Mostrando <?php echo count($resultados);?> resultados:</div>
    <div class="tablagen">
    <?php
    foreach ($resultados as $resultado) {
      echo "<div class='fila'>
              <div class='col'>".
              $resultado['cliente']."
              </div>
              <div class='col'>".
              $resultado['id_cliente']."/".$resultado['empresa']."
              </div>
              <div class='col goright'>
              <a href='' class='accion'>ACTIVIDAD</a>
              </div>
            </div>";
    }
    ?>
    </div>
    <?php
  }
  if ($clue == '') {
    $siguiente = $start + 15;
    $anterior = $start - 15;
    echo "<div class='gocenter'>";
    if ($start > 0) echo "<a href='default.php?page=pnlcli&sent=1&start=".$anterior."' class='buttons next'>anterior</a>";
    echo "<a href='default.php?page=pnlcli&sent=1&start=".$siguiente."' class='buttons next'>siguiente</a></div>";
  }
}
?>