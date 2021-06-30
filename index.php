<?php
require 'vendor/autoload.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Mod Dateinamen Manager</title>
  <link rel="shortcut icon" type="image/ico" href="icon.ico"/>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' type='text/css' media='screen' href='css/main.css'>
  <script src="js/jquery.js"></script>
  <script src="js/main.js"></script>
</head>
<body>


    <?php
      # $!'\"%&{}[]§²³,.;:-_#+~*´`áà
      $original1 = "";
      $original = strtr($original1, [
        " " => "%20",
        "`" => "%60",
        "+" => "%2B",
        "{" => "%7B",
        "}" => "%7D",
        "^" => "%5E",
        "<" => "%3C",
        ">" => "%3E",
        "\"" => "%22",
        "\n" => "%0A",
        "\r" => "",
        "\\" => "%5C",
      ]);
      if(!empty($original1)){
        $encode = rawurlencode($original);
        $short = Url_Shortener_API_Handler::short_url($original);
        $expand = Url_Shortener_API_Handler::expand_url($short);
        $decode = rawurldecode($expand);
        var_dump($short, str_replace("\r", "", $original1), $decode, $decode === str_replace("\r", "", $original1));
      }
      @Main::handle_ui_data($_POST);
    ?>


</body>
</html>