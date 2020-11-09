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
    input + label, label + input, label + select {
      display: block;
    }

    /* no selection color in labels */
    label::selection {
      background-color: transparent;
    }
  </style>
</head>
<body>

  <form method="post" action=".">


    <?php
      require 'vendor/autoload.php';
      Ui::out_input_shema("Categorie");
      Ui::out_input_shema("Description");
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