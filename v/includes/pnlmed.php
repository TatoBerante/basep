<?php
require_once ('../c/funcs/common.php');
if (isset ($_REQUEST['sent'])) {
  $clue = sanitizeThis ($_REQUEST['srchmed']);
}
else {
  $clue = "";
}
?>
<h2>Panel de médicos</h2>
<form action="default.php?page=pnlmed" method="post">
  <div class="formcontainer">
    <div class="formcell"><input type="text" name="srchmed" id="srchmed" autofocus autocomplete="off" class="input-text" value="<?php echo $clue;?>"></div>
    <div class="formcell"><input type="hidden" name="sent" value="1"><input type="submit" value="BUSCAR" class='buttons-inline'></div>
  </div>
</form>
<?php
if (isset ($_REQUEST['sent'])) {
  require_once '../c/funcs/utilities.php';
  //echo "<p>$clue</p>";
  $start = (isset ($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
  $resultados = search_medicos ($clue, $start);
  if (count ($resultados) < 1) echo "<p class='error-msg'>no se encontraron resultados</p>";
  else {
    ?>
    <div class='simple-line'>Mostrando <?php echo count($resultados);?> resultados:</div>
    <!--<div class="tablagen">-->
    <table class='results cx'>
    <?php
    foreach ($resultados as $resultado) {
      echo "<tr style='height:3.5rem;'>
              <td>".$resultado['medico']."</td>
              <td class='goright'>
                <a href='default.php?page=appmed&idm=".$resultado['id_medico_sys']."' class='accion'>VER</a>
              </td>
            </tr>";
    }
    ?>
    </table>
    <?php
  }
  if ($clue == '') {
    $siguiente = $start + 15;
    $anterior = $start - 15;
    echo "<div class='gocenter'>";
    if ($start > 0) echo "<a href='default.php?page=pnlcli&sent=1&start=".$anterior."' class='buttons next'>anterior</a>";
    echo "<a href='default.php?page=pnlmed&sent=1&start=".$siguiente."' class='buttons next'>siguiente</a></div>";
  }
}
?>