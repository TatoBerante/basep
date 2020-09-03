<h2>Nuevo usuario</h2>
<?php
/*
Estilos de mensajes: error=formerror / sugg=formsugg
Ej:
if (noerror) <div class="formsugg">ERROR</div>
else <div class="formerror">ERROR</div>
*/
?>
<form action="../c/newusr-validate.php" method="post">
  <div class="formcontainer">

    <div class="formcell"><label for="nombreusr">Nombre:</label></div>
    <div class="formcell"><input type="text" name="nombreusr" id="nombreusr" autofocus></div>
    <div class="formsugg">sólo letras. espacios iniciales y finales serán ignorados.</div>

    <div class="formcell"><label for="apellidousr">Apellido:</label></div>
    <div class="formcell"><input type="text" name="apellidousr" id="apellidousr"></div>
    <div class="formsugg">sólo letras. espacios iniciales y finales serán ignorados.</div>

    <div class="formcell"><label for="nickusr">Nick:</label></div>
    <div class="formcell"><input type="text" name="nickusr" id="nickusr"></div>
    <div class="formsugg">mínimo 8 caracteres sin espacios. sólo letras y números.</div>

    <div class="formcell"><label for="keyusr">Clave:</label></div>
    <div class="formcell"><input type="text" name="keyusr" id="keyusr"></div>
    <div class="formsugg">mínimo 8 caracteres sin espacios. comillas y punto-y-coma no permitidos.</div>

  </div>
  <div class="submitbutton">
    <input type="submit" value="REGISTRAR" class='buttons'>
  </div>
</form>
<?php
  if (isset ($_REQUEST['errform'])) {
    if ($_REQUEST['errform'] == 1) $msgerror = "datos incorrectos";
    if ($_REQUEST['errform'] == 2) $msgerror = "no se pudo conectar a la base de datos";
    echo "<div class='error-msg'>".$msgerror."</div>";
  }
?>