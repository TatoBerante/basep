<?php
session_start();
if (!isset ($_SESSION['basep'])) {
  header ('location: ../');
}
else {
  ?>
  <!DOCTYPE html>
  <html lang="es">
  <head>
    <?php
    // App data for logo, favicon and title.
    include "../core/config.php";
    require_once ('../c/funcs/common.php');
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
          <a href='default.php?page=home'><li>home</li></a>
          <a href='default.php?page=404.php'><li>test 404</li></a>
          <a href='../c/logout.php'><li>logout</li></a>
        </ul>
      </div>
      <?php
      if (isset ($_REQUEST['page'])) {
        if (file_exists ('includes/'.$_REQUEST['page'].'.php')) include ('includes/'.$_REQUEST['page'].'.php');
        else include ('includes/404.php');
      }
      else {
        include ('includes/home.php');
      }
      ?>
      <script>
        function popMenu() {
          var divmenu = document.getElementById("popmenu");
          var burgericon = document.getElementById("burgericon");
          var mainheader = document.getElementById("mainheader");
          var headerdevider = document.getElementById("headerdevider");
          if(divmenu.style.display == "block") {
            divmenu.style.display = "none";
            burgericon.src = 'img/burger-icon.png';
            headerdevider.style.display = "block";
          }
          else {
            divmenu .style.display = "block";
            burgericon.src = 'img/burger-x.png';
            headerdevider.style.display = "none";
          }
        }
      </script>
    </div>
  </body>
<?php
}
?>