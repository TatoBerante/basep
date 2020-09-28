<?php
require_once ('../c/funcs/common.php');
if (isset ($_REQUEST['sent'])) {
  $clue = sanitizeThis ($_REQUEST['srchcx']);
}
else {
  $clue = "";
}
?>
<h2>Panel de cirugías</h2>
<form action="default.php?page=pnlcx" method="post">
  <div class="">
    Profesional: <input type="text" name="srchcx" id="srchcx" autofocus autocomplete="off" class="input-text" value="<?php echo $clue;?>">
    <span class='left-margin'>Periodo:</span> <select name='mes' id='mes' class='input-text'>
        <option value="01"<?php if ($_REQUEST['mes'] == '1') echo " selected"?>>Enero</option>
        <option value="02"<?php if ($_REQUEST['mes'] == '2') echo " selected"?>>Febrero</option>
        <option value="03"<?php if ($_REQUEST['mes'] == '3') echo " selected"?>>Marzo</option>
        <option value="04"<?php if ($_REQUEST['mes'] == '4') echo " selected"?>>Abril</option>
        <option value="05"<?php if ($_REQUEST['mes'] == '5') echo " selected"?>>Mayo</option>
        <option value="06"<?php if ($_REQUEST['mes'] == '6') echo " selected"?>>Junio</option>
        <option value="07"<?php if ($_REQUEST['mes'] == '7') echo " selected"?>>Julio</option>
        <option value="08"<?php if ($_REQUEST['mes'] == '8') echo " selected"?>>Agosto</option>
        <option value="09"<?php if ($_REQUEST['mes'] == '9') echo " selected"?>>Septiembre</option>
        <option value="10"<?php if ($_REQUEST['mes'] == '10') echo " selected"?>>Octubre</option>
        <option value="11"<?php if ($_REQUEST['mes'] == '11') echo " selected"?>>Noviembre</option>
        <option value="12"<?php if ($_REQUEST['mes'] == '12') echo " selected"?>>Diciembre</option>
    </select>
    <select name='ano' id="ano" class='input-text'>
    <?php
    for ($ap=date('Y'); $ap>(date('Y')-2); $ap--) {
      echo "<option value='".$ap."'";
      if ($_REQUEST['ano'] == $ap) echo " selected";
      echo ">".$ap."</option>";
    }
    ?>
    </select>

    <span class='left-margin'>Mostrar:</span> <select name="estado" id="estado" class='input-text'>
      <option value="0"<?php if ($_REQUEST['estado'] == '0') echo " selected"?>>TODAS</option>
      <option value="1"<?php if ($_REQUEST['estado'] == '1') echo " selected"?>>PENDIENTES</option>
      <option value="2"<?php if ($_REQUEST['estado'] == '2') echo " selected"?>>FINALIZADAS</option>
    </select>
    <input type="hidden" name="sent" value="1">
    <input type="submit" value="BUSCAR" class='buttons-inline pnlcx-btn'>
  </div>
</form>
<?php
if (isset ($_REQUEST['sent'])) {
  require_once ('../c/funcs/utilities.php');
  $resultados = search_cx ($clue, $_REQUEST['mes'], $_REQUEST['ano']);
  if (count ($resultados) < 1) echo "<p class='error-msg'>no se encontraron resultados</p>";
  else {
    ?>
    <div class='simple-line'>Mostrando <?php echo count($resultados);?> resultados:</div>
    <table class='results'>
      <tr>
        <th>profesional</th>
        <th>fecha cx</th>
        <th>paciente</th>
        <th>vendedor</th>
        <th>producto</th>
        <th>acciones</th>
      </tr>
    <?php
    foreach ($resultados as $resultado) {
      ?>
      <tr class='rowguide'>
        <td><?=$resultado['medico'];?></td>
        <td><?=$resultado['fecha_cx_h'];?></td>
        <td><?=$resultado['nombre_paciente'];?></td>
        <td><?=$resultado['nombre_vendedor'];?></td>
        <td><?=$resultado['producto'];?></td>
        <td>
          <div class="acciones">
            <a href='' class='accion'>accion1</a>
            <a href='' class='accion'>accion2</a>
          </div>
        </td>
      </tr>
      <?php
    }
    ?>
    </table>
    <?php
  }
  /*
  if ($clue == '') {
    $siguiente = $start + 15;
    $anterior = $start - 15;
    echo "<div class='gocenter'>";
    if ($start > 0) echo "<a href='default.php?page=pnlcli&sent=1&start=".$anterior."' class='buttons next'>anterior</a>";
    echo "<a href='default.php?page=pnlcli&sent=1&start=".$siguiente."' class='buttons next'>siguiente</a></div>";
  }
  */
}
?>