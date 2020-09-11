<h2>Nuevo usuario</h2>
<?php
/*
Estilos de mensajes: error=formerror / sugg=formsugg
Ej:
if (noerror) <div class="formsugg">ERROR</div>
else <div class="formerror">ERROR</div>
*/
?>
<form action="../c/newusr-validate.php" method="post" id="form">
  <div class="formcontainer">

    <div class="formcell"><label for="nombreusr">Nombre:</label></div>
    <div class="formcell"><input type="text" name="nombreusr" id="nombreusr" value="<?php echo $_REQUEST['nombreusr'];?>" autofocus autocomplete="off" class="input-text"></div>
    <div class="<?php echo (isset ($_REQUEST['errnom'])) ? 'formerror' : 'formsugg';?>" id="nom-div">sólo letras. espacios iniciales y finales serán ignorados.</div>

    <div class="formcell"><label for="apellidousr">Apellido:</label></div>
    <div class="formcell"><input type="text" name="apellidousr" id="apellidousr" value="<?php echo $_REQUEST['apellidousr'];?>" autocomplete="off" class="input-text"></div>
    <div class="<?php echo (isset ($_REQUEST['errape'])) ? 'formerror' : 'formsugg';?>" id="ape-div">sólo letras. espacios iniciales y finales serán ignorados.</div>

    <div class="formcell"><label for="nickusr">Nick:</label></div>
    <div class="formcell"><input type="text" name="nickusr" id="nickusr" value="<?php echo $_REQUEST['nickusr'];?>" autocomplete="off" class="input-text"></div>
    <div class="<?php echo (isset ($_REQUEST['errnck'])) ? 'formerror' : 'formsugg';?>" id="nick-div">mínimo 8 caracteres, sólo letras y números.</div>

    <div class="formcell"><label for="keyusr">Clave:</label></div>
    <div class="formcell"><input type="text" name="keyusr" id="keyusr" value="<?php echo $_REQUEST['keyusr'];?>" autocomplete="off" class="input-text"></div>
    <div class="<?php echo (isset ($_REQUEST['errkey'])) ? 'formerror' : 'formsugg';?>" id="key-div">mínimo 8 caracteres, sólo letras y números.</div>

  </div>
  <div class="submitbutton">
    <input type="submit" value="REGISTRAR" class='buttons'>
  </div>
</form>
<?php
  if (isset ($_REQUEST['errform'])) {
    if ($_REQUEST['errform'] == 1) $msgerror = "datos incorrectos";
    if ($_REQUEST['errform'] == 2) $msgerror = "no se pudo conectar a la base de datos";
    if ($_REQUEST['errform'] == 3) $msgerror = "nick de usuario existente";
    echo "<div class='error-msg'>".$msgerror."</div>";
  }
?>