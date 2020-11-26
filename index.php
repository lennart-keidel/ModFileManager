<?php
require 'vendor/autoload.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Mod Files Renamer</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
  <style>

    details {
      padding-top: 0.5em;
    }

    details > *:not(summary){
      padding-left: 2em;
    }

    summary {
      padding-bottom: 0.5em;
      font-weight: bold;
    }

    summary:focus {
      outline: none;
    }

    .container_label_and_input {
      padding-bottom: 0.5em;
    }


    .container_label_and_input.sub_input {
      padding-left: 2em;
    }

    /* add line break in form element */
    .container_label_and_input > label + input,
    .container_label_and_input > label + select,
    .container_label_and_input > label + textarea {
      display: block;
    }


    /* === SEARCH === */
    .disable_search_shema {
      display: inline-block;
    }

    .disable_search_shema::before {
      content: '';
    }

    .disable_search_shema + .container_label_and_input {
      display: inline-block;
    }

    .container_search_disable > .container_label_and_input {
      margin-left: 1em;
    }

    .toggle_rowbreak {
      display: none;
    }

    .container_search_disable .toggle_rowbreak {
      display: block;
    }

    /* no selection color in labels */
    label::selection {
      background-color: transparent;
    }
  </style>
  <script>
    document.addEventListener("DOMContentLoaded", function(){ console.log("a"); });
    document.addEventListener("DOMContentLoaded", function(){ console.log("b"); });
  </script>
</head>
<body>


    <?php
      @Main::handle_ui_data($_POST);
    ?>

</body>
</html>