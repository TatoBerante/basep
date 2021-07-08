<?php
require_once '../c/funcs/utilities.php';
$medico = medico_by_id ($_REQUEST['idm']);
$block_txt = ($medico['estado'] == '1') ? "bloquear" : "desbloquear";
?>
<h2>
  <div class='header-medico'>
    <?=$medico['medico'];?>
    <span class='blocked'><a href='default.php?page=bloqmedconfirm&idm=<?=$_REQUEST['idm'];?>'><?=$block_txt;?> LIQUIDACIÓN</a></span>
  </div>
</h2>
<h3>Saldo actual: $ <?=number_format($medico['saldo'], 2, ',', '.');?></h3>
<h3>Pendiente: $ <?=number_format($medico['total_pendientes'], 2, ',', '.');?></h3>
<h3>Preparado: $ <?=number_format($medico['total_preparados'], 2, ',', '.');?></h3><br>
<h3>Registrar nueva regalía</h3>
<div class="simple-line">
  <form action="../c/appmed-validate.php" method="post" id="regform" name="regform">
    <input type="hidden" name="idm" value="<?=$_REQUEST['idm'];?>">
    <label for="monto">Monto: $ </label><input type="text" name="monto" id="monto" autocomplete="off" class="input-text goright" style="width:6rem;" value="<?=$_REQUEST['monto']?>"> <label for="desc" class="left-margin">Descripción:</label> <input type="text" name="desc" id="desc" autocompĺete="off" class="input-text" style="width:30rem;" value="<?=$_REQUEST['desc']?>"><a href='#' onclick="document.getElementById('regform').submit()" class='buttons left-margin'>REGISTRAR</a>
    <?php
    if (isset ($_REQUEST['error'])) {
      if ($_REQUEST['error'] == '1') echo "<span class='error-inline'>ambos campos obligatorios</span>";
      else if ($_REQUEST['error'] == '2') echo "<span class='error-inline'>error al conectarse a la base de datos</span>";
      else echo "<span class='error-inline'>error desconocido</span>";
    }
    ?>
  </form>
</div><br>

<h3>Últimos registros</h3>
<?php
$last_10_regalias = search_10_regalias ($_REQUEST['idm']);
if (count ($last_10_regalias) < 1) echo "SIN REGISTROS";
else {
  echo "<table class='results cx'>
          <tr>
            <th style='width:10rem;'>FECHA</th>
            <th>DESCRIPCION</th>
            <th style='width:10rem;'>VALOR</th>
          </tr>";
  foreach ($last_10_regalias as $regalia) {
    echo "<tr";
    if (isset ($_REQUEST['idr']) && $_REQUEST['idr'] == $regalia['id_regalia']) echo " class='trok'";
    echo ">
            <td class='gocenter'>".$regalia['fecha_h']."</td>
            <td>".$regalia['descripcion']."</td>
            <td class='goright'>$ ".number_format ($regalia['valor'], 2, ',', '.')."</td>
          </tr>";
  }
  echo "</table>";
}
?>