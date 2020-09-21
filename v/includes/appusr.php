<?php
if (isset ($_REQUEST['actflag'])) {
  // Detecta nuevo o mod existente
  if ($_REQUEST['actflag'] == 'new') {
    // nuevo
    $goahead = true;
    $h2 = "Nuevo";
    $flag = "n";
    $submit_value = "REGISTRAR";
  }
  else if ($_REQUEST['actflag'] == 'mod') {
    // mod
    $goahead = true;
    $h2 = "Editar";
    $flag = $_REQUEST['idusr'];
    $submit_value = "EDITAR";
  }
  else {
    // falta flag
    $goahead = false;
    echo "<h2>Error</h2><p class='error-msg'>Dato de seguridad faltante</p>";
  }
  ?>
  
  <?php
  /*
  Estilos de mensajes: error=formerror / sugg=formsugg
  Ej:
  if (noerror) <div class="formsugg">ERROR</div>
  else <div class="formerror">ERROR</div>
  */
  if ($goahead) {
    if ($h2 == "Editar") {
      $usuario = user_by_id ($_REQUEST['idusr']);
      $nombre = $usuario['usuario_nombre'];
      $apellido = $usuario['usuario_apellido'];
      $nick = $usuario['usuario_nick'];
      $clave = $usuario['usuario_key'];
    }
    else {
      $nombre = $_REQUEST['nombreusr'];
      $apellido = $_REQUEST['apellidousr'];
      $nick = $_REQUEST['nickusr'];
      $clave = $_REQUEST['keyusr'];
    }

  ?>

    <h2><?php echo $h2;?> usuario</h2>
    <form action="../c/appusr-validate.php" method="post" id="form">
      <input type="hidden" name="flag" id="flag" value="<?php echo $flag;?>">
      <div class="formcontainer">
        <div class="formcell"><label for="nombreusr">Nombre:</label></div>
        <div class="formcell"><input type="text" name="nombreusr" id="nombreusr" value="<?php echo $nombre;?>" autofocus autocomplete="off" class="input-text"></div>
        <div class="<?php echo (isset ($_REQUEST['errnom'])) ? 'formerror' : 'formsugg';?>" id="nom-div">sólo letras. espacios iniciales y finales serán ignorados.</div>

        <div class="formcell"><label for="apellidousr">Apellido:</label></div>
        <div class="formcell"><input type="text" name="apellidousr" id="apellidousr" value="<?php echo $apellido;?>" autocomplete="off" class="input-text"></div>
        <div class="<?php echo (isset ($_REQUEST['errape'])) ? 'formerror' : 'formsugg';?>" id="ape-div">sólo letras. espacios iniciales y finales serán ignorados.</div>

        <div class="formcell"><label for="nickusr">Nick:</label></div>
        <div class="formcell"><input type="text" name="nickusr" id="nickusr" value="<?php echo $nick;?>" autocomplete="off" class="input-text"></div>
        <div class="<?php echo (isset ($_REQUEST['errnck'])) ? 'formerror' : 'formsugg';?>" id="nick-div">mínimo 8 caracteres, sólo letras y números.</div>

        <div class="formcell"><label for="keyusr">Clave:</label></div>
        <div class="formcell"><input type="text" name="keyusr" id="keyusr" value="<?php echo $clave;?>" autocomplete="off" class="input-text"></div>
        <div class="<?php echo (isset ($_REQUEST['errkey'])) ? 'formerror' : 'formsugg';?>" id="key-div">mínimo 8 caracteres, sólo letras y números.</div>

      </div>
      <div class="submitbutton">
        <input type="submit" value="<?=$submit_value;?>" class='buttons'>
      </div>
    </form>
    <?php
    if (isset ($_REQUEST['errform'])) {
      if ($_REQUEST['errform'] == 1) $msgerror = "datos incorrectos";
      if ($_REQUEST['errform'] == 2) $msgerror = "no se pudo conectar a la base de datos";
      if ($_REQUEST['errform'] == 3) $msgerror = "nick de usuario existente";
      echo "<div class='error-msg'>".$msgerror."</div>";
    }
  }
  else echo "<h2>Error</h2><p class='error-msg'>Dato de seguridad faltante</p>";
}
else echo "<h2>Error</h2><p class='error-msg'>Dato de seguridad faltante</p>";
?>