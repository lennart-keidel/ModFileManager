<?php
require 'vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Mod Dateinamen Manager - Mod-Blacklisting</title>
  <link rel="shortcut icon" type="image/ico" href="icon.ico"/>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' type='text/css' media='screen' href='css/main.css'>
  <script src="js/jquery.js"></script>
  <script src="js/main.js"></script>
</head>
<body>


    <?php
      Blacklist::print_blacklist_input();
      Blacklist::handle_input();
    ?>


</body>
</html>