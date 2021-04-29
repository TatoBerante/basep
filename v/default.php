<?php
session_start();
if (!isset ($_SESSION['basep'])) {
  header ('location: ../');
}
else {
  include "../core/config.php";
  require_once ('../c/funcs/common.php');
  require_once ('../c/funcs/utilities.php');
  if (isset ($_REQUEST['page']) && $_REQUEST['page'] == 'pnllq') {
    // evaluar si es print para hacer header directo a impresión
    $liquidadas = 0;
    $rems = array();
    foreach ($_REQUEST as $key=>$dato) {
      $dato = explode ('_', $key);

      if ($dato[0] == 'chkr') {
        $info = data_remito($dato[1]);
        
        if ($info['estado'] == 3) {
          $liquidadas++;
          $rems[] = $dato[1];
        }
        $cantrm++;
      }
    }
    if ($liquidadas > 0) {
      $estado = 'liquidada';
      $proceso = "imprimir";
      $stringpr = "location:../v/appprint.php?sent=1";
      foreach ($rems as $key=>$value) {
        $remito = data_remito ($value);
        $stringpr .= "&rem_".$remito['id_remito']."=".$remito['id_remito'];
      }
      header ($stringpr);
    }
    // fin evaluación print
  }
  ?>
  <!DOCTYPE html>
  <html lang="es">
  <head>
    <?php
    // App data for logo, favicon and title.
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/normalize.css">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="icon" type="image/png" href="img/logo.png">
    <title><?php echo $appname;?></title>
  </head>
  <body class='default-body'>
    <div class='main-container' id='mainheader'>
      <div class='main-header'>
        <h1 class='default-line default-header'>
          <a href='default.php?page=home'>
            <img src='img/logo.png' class='default-logo'>
          </a>
          <span class='app-default-title'><?php echo $appname;?></span>
        </h1>
        <span class="menu-bottom">
          <a href='javascript:void(0);' onclick="popMenu()">
            <img src='img/burger-icon.png' class='burger-icon' id="burgericon">
          </a>
        </span>
      </div>
      <div class='header-devider' id='headerdevider'></div>
      <div class="popmenu" id="popmenu">
        <div class='insession'>
          en sesión: <?php echo $_SESSION['basep']['usr'];?>
        </div>
        <ul class='main-menu'>
          <?php
          include "includes/menu.php";
          ?>
        </ul>
      </div>
      <?php

      if (isset ($_REQUEST['page'])) {
        
        if (file_exists ("includes/".$_REQUEST['page'].".php")) {
          include ("includes/".$_REQUEST['page'].".php");
        }
        else {
          include ('includes/404.php');
        }
        
      }
      else {
        include ('includes/home.php');
      }
      ?>
      <script>
      <?php
      include "../c/js/popmenu.js";
      ?>
      </script>
    </div>
  </body>
<?php
}
?>