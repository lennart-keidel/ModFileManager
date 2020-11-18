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

    Ui::print_source_path_input();

  ?>

  <hr>

  <?php

    Ui::print_filename_shema_search_input();
  ?>

  <hr>

    <?php
      $filename_list = [
        "mods" => [
          "abc_def.package"
        ],
        "modsa" => [
          "abc_def2.package"
        ]
      ];

      Ui_Failed_Files::add_failed_filename_list($filename_list);
      Ui_Failed_Files::print_input_shema_for_failed_filename_list();
      Ui::print_filename_shema_input_for_filename_list($filename_list);
    ?>

    <hr>

    <?php

      $filename_data_list = [
        "files" => [
          [
            "path_source" => "mods/ghi_jkl.package",
            "select_shema_categorie" => "Tuning",
            "text_shema_description" => "somtehing to do with this",
            "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
            "date_shema_installation_date" => "2020-10-29",
            "select_flag_data_depends_on_expansion" => "ep01",
            "checkbox_shema_flag" => [
              "option_depends_on_content",
              "option_depends_on_expansion"
            ],
            "url_flag_data_depends_on_content" => "https://modthesims.info/d/638203/broadcaster-a-custom-stereo-music-utility-updated-27-march-2020.html"
          ]
        ]
      ];

      Ui::print_input_shema_for_filename_data_list_and_fill($filename_data_list);
      Ui_Failed_Files::add_failed_filename_data($filename_data_list["files"][0]);
      Ui_Failed_Files::print_input_shema_for_failed_filename_data();
    ?>

    <?php
      if(isset($_POST) && !empty($_POST)){
        var_dump($_POST);
      }
    ?>
  </form>

</body>
</html>