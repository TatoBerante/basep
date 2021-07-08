<?php
require_once '../c/funcs/utilities.php';
$medico = medico_by_id ($_REQUEST['idm']);

if (isset ($_REQUEST['blked'])) {
    ?>
    <h2 class='gocenter confirm-block'>La liquidación de <?=$medico['medico'];?> ha sido bloqueada</h2>
    <?php 
}
else if (isset ($_REQUEST['ublked'])) {
    ?>
    <h2 class='gocenter confirm-block'>La liquidación de <?=$medico['medico'];?> ha sido desbloqueada</h2>
    <?php 
}
else {
    $estado_txt = ($medico['estado'] == '1') ? "bloquear" : "desbloquear";
    ?>
    <h2 class='gocenter confirm-block'>Está seguro que desea <?=$estado_txt;?> la liquidación de <?=$medico['medico'];?>?</h2>
    <div><a href='../c/bloqmed-validate.php?idm=<?=$_REQUEST['idm'];?>' class='buttons-standalone'>confirmar</a></div>
    <div><a href='default.php?page=pnlcx' class='buttons-warning'>cancelar</a></div>
    <?php
}
?>