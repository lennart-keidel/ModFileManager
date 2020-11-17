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

    /* add line break in form element */
    .shema_input label + input,
    .shema_input label + select,
    .shema_input input[type=checkbox] + label {
      display: block;
    }


    /* no selection color in labels */
    label::selection {
      background-color: transparent;
    }
  </style>
</head>
<body>

  <form class="shema_search" method="post" action=".">
  <?php
    foreach(Main::shema_order_global as $class_id){
      echo "<div>";
      echo '<input type="checkbox" name="enable_shema_search_'.$class_id.'" checked>';
      $full_class_name = "Filename_Shema_$class_id";
      $full_class_name::print_filneame_shema_search_input_for_ui();
      echo "</div>";
    }
  ?>
  <input type="submit" value="suchen">
  </form>

  <hr>

  <form class="shema_input" method="post" action=".">


    <?php
      Filename_Shema_Categorie::print_filename_shema_input_for_ui(0);
      Filename_Shema_Description::print_filename_shema_input_for_ui(0);
      Filename_Shema_Patch_Level::print_filename_shema_input_for_ui(0);
      Filename_Shema_Flag::print_filename_shema_input_for_ui(0);
    ?>

    <input type="submit" value="absenden">

    <?php
      if(isset($_POST) && !empty($_POST)){
        var_dump($_POST);
      }
    ?>
  </form>

</body>
</html>