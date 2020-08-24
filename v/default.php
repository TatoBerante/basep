<!DOCTYPE html>
<html lang="es">
<head>
  <?php
  // App data for logo, favicon and title.
  include "includes/_system-data.php";
  ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="styles/normalize.css">
  <link rel="stylesheet" type="text/css" href="styles/style.css">
  <link rel="icon" type="image/png" href="img/logo.png">
  <title><?php echo $appname;?></title>
</head>
<body class='default-body'>
  <h1 class='default-line'><img src='img/logo.png' class='default-logo'> <?php echo $appname;?></h1>
  <?php
  if (isset ($_REQUEST['page'])) {
    if (file_exists ('includes/'.$_REQUEST['page'].'.php')) include ('includes/'.$_REQUEST['page'].'.php');
    else include ('includes/404.php');
  }
  else {
    include ('includes/home.php');
  }
  ?>
</body>