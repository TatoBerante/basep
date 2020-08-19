<!DOCTYPE html>
<html lang="es">
<head>
  <?php
  include "v/includes/_system-data.php";
  ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="v/styles/normalize.css">
  <link rel="stylesheet" type="text/css" href="v/styles/style.css">
  <link rel="icon" type="image/png" href="v/img/logo.png">
  <title><?php echo $appname;?></title>
</head>
<body class='login-body'>
  <h1 class='login-header'><img src="v/img/logo.png" alt="logo" class='logo'></h1>
  <form action="c/login-validate.php" method="post">
    <div class='login-line'>
      <input class='login-input' type="text" name="user" id="user" placeholder='USUARIO'>
    </div>
    <div class='login-line'>
      <input class='login-input' type="password" name="key" id="key" placeholder='CLAVE'>
    </div>
    <div class='login-line'>
      <input class='login-input login-submit' type="submit" value="INGRESAR">
    </div>
  </form>
  <?php
  if (isset ($_REQUEST['error-login'])) {
    if ($_REQUEST['error-login'] == 1) $msgerror = "datos incorrectos";
    if ($_REQUEST['error-login'] == 2) $msgerror = "no se pudo conectar a la base de datos";
    echo "<div class='error-msg'>".$msgerror."</div>";
  }
  ?>
</body>
</html>