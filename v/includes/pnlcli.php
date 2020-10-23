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
  require_once '../c/funcs/utilities.php';
  //echo "<p>$clue</p>";
  $start = (isset ($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
  $resultados = search_clientes ($clue, $start);
  if (count ($resultados) < 1) echo "<p class='error-msg'>no se encontraron resultados</p>";
  else {
    ?>
    <div class='simple-line'>Mostrando <?php echo count($resultados);?> resultados:</div>
    <!--<div class="tablagen">-->
    <table class='results cx'>
    <?php
    foreach ($resultados as $resultado) {
      echo "<tr style='height:3.5rem;'>
              <td>".$resultado['cliente']."</td><td class='gocenter' style='width:10rem'>";
      if (isset ($_REQUEST['idc']) && $_REQUEST['idc'] == $resultado['id_cliente_sys']) {
        echo "<form autocompĺete='off' action='../c/pnlcli-validate.php' method='post' style='margin:0;padding:0;' name='aplform' id='aplform'>
            <input type='hidden' name='clue' value='".$clue."'>
            <input type='hidden' name='idc' value='".$resultado['id_cliente_sys']."'>
            <input type='text' name='apl' id='apl' value='".$resultado['aplicable']."' class='input-text gocenter' style='width:3rem;'> %
          </td>
          <td style='width:7rem' class='gocenter'>
            <a href='#' onclick=\"document.getElementById('aplform').submit()\"  class='accion'>GRABAR</a>
            </form>
          </td>";
      }
      else {
        echo $resultado['aplicable']." %</td>
              <td style='width:7rem' class='gocenter'>
                <a href='default.php?page=pnlcli&idc=".$resultado['id_cliente_sys']."&sent=1&srchcli=".$clue."' class='accion'>EDITAR</a>
              </td>";
      }
      echo "</tr>";
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
    echo "<a href='default.php?page=pnlcli&sent=1&start=".$siguiente."' class='buttons next'>siguiente</a></div>";
  }
}
?>