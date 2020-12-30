<?php

abstract class Ui {


  # ui data root key for filename shema input
  public const ui_data_key_root = "files";

  # ui data root key for search input
  public const ui_search_data_key_root = "search";

  # ui data root key for source path input
  public const ui_source_input_key_root = "source";

  # ui data key for source path input
  public const ui_path_source_root_key = "path_source_root";

  # ui data key for source path input to search recursive
  public const ui_path_source_root_recursive_key = "path_source_root_options";

  # ui data key for filename source path
  public const ui_key_path_source = "path_source";

  # html template for error messages
  private const template_error_message = '<script>alert(%1$s)</script>';

  # html template for source path input
  private const input_path_source_template = '
  <div class="container_label_and_input">
    <label for="input_source_path_root%1$d">Pfad zum Quellordner</label>
    <input id="input_source_path_root%1$d" type="text" name="%2$s[path_source_root]" required>
  </div>
  <div class="container_label_and_input">
    <input id="input_source_path_root_recursive%1$d" type="checkbox" name="%2$s[path_source_root_options]" value="search_source_dir_recursive">
    <label for="input_source_path_root_recursive%1$d">Alle Unterordner und deren Dateien einbinden</label>
  </div>
  ';

  private const search_connector_input_template = '
  <label for="search_shema_connector">Suche verbinden mit: </label>
  <select id="search_shema_connector" name="%2$s[%1$d][search_shema_connector]" required>
    <option value="" selected disabled>Auswählen</option>
    <option value="or">Oder</option>
    <option value="and">Und</option>
  </select>
  ';

  private const search_disable_input_template = '
  <input type="checkbox" class="disable_search_shema" id="disable_search_shema_%3$s" name="%2$s[%1$d][disable_search_shema]" checked>
  ';

  # html template for begin/end of shema input container
  private const template_shema_input_container_begin = '
  <details id="file_details%1$d">
    <summary>%2$s</summary>
  ';
  private const template_shema_input_container_end = '
  </details>
  ';

  # html template for begin/end of shema input form
  private const template_source_input_form_begin = '
  <form class="source_input" method="post" action=".">
  ';
  private const template_source_input_form_end = '
  </form>
  ';

  # html template for begin/end of shema input form
  private const template_shema_input_form_begin = '
  <form class="shema_input" method="post" action=".">
  ';
  private const template_shema_input_form_end = '
  </form>
  ';

  # html template for begin/end of shema search form
  private const template_shema_search_input_form_begin = '
  <form class="shema_search" method="post" action=".">
  ';
  private const template_shema_search_input_form_end = '
  </form>
  ';

  # html template for hidden input for source path
  private const template_shema_template_path_source_for_ui = '
  <div><b>Pfad:</b> %1$s</div>
  ';

  # html template for hidden input for source path
  private const input_shema_template_path_source = '
  <input type="hidden" name="%2$s[%1$d][path_source]" value="%3$s" id="path_source%1$d">
  ';

  private const template_source_input_submit_button = '
  <input type="submit" value="Quell-Ordner eintragen">
  ';

  private const template_shema_search_submit_button = '
  <input type="submit" value="Dateien Suchen">
  ';

  private const template_shema_input_submit_button = '
  <input type="submit" value="Dateien umbenennen">
  ';

  private const template_delete_session_button = '
  <form class="delete_session" method="post" action=".">
    <hr>
    <input type="submit" name="delete_session_button" value="Session löschen, alle eingetragenen Daten löschen">
  </form>
  ';

  private static $out_input_shema_index = 0;


  # print shema input for one file
  private static function print_filename_shema_input(string $path_source) : void {
    $filename = basename($path_source);
    printf(self::template_shema_input_container_begin, self::$out_input_shema_index, $filename);
    printf(self::input_shema_template_path_source, self::$out_input_shema_index, self::ui_data_key_root, $path_source);
    printf(self::template_shema_template_path_source_for_ui, $path_source);
    foreach(Main::shema_order_global as $class_id){
      $class_name = "Filename_Shema_$class_id";
      $class_name::print_filename_shema_input_for_ui(self::$out_input_shema_index);
    }
    printf(self::template_shema_input_container_end,"");
    self::$out_input_shema_index++;
  }


  # print shema input for each filename of a filename list
  public static function print_filename_shema_input_for_filename_list(array $filename_list) : void {
    printf(self::template_shema_input_form_begin, "");
    foreach($filename_list as $path => $filename_array){
      foreach($filename_array as $filename){
        $source_path = "$path/$filename";
        self::print_filename_shema_input($source_path);
      }
    }
    printf(self::template_shema_input_submit_button, "");
    printf(self::template_shema_input_form_end, "");
  }


  # print js code to fill shema input with received data from filename after page load
  private static function fill_input_shema_with_filename_data_list(array $filename_data_list) : void {

    $js_template_code = '
    <script>
    document.addEventListener("DOMContentLoaded", function(){
      var filename_data_list = %1$s;
      fill_input_shema_with_filename_data_list(filename_data_list);
    });
    </script>
    ';

    try {
      $filename_data_list_as_json = json_encode($filename_data_list);
    }
    catch(Exception $e){
      throw new Ui_Exception("Fehler beim Verarbeiten der ausgelesenen Daten. Die ausgelesenen Daten konnten nicht nach JSON konvertiert werden.\\nHier die PHP-Fehlermeldung: ".$e->getMessage(), false);
      return;
    }

    printf($js_template_code, $filename_data_list_as_json);
  }


  # print input shema by filename data list and print js code to fill it with the data
  protected static function print_input_shema_for_filename_data_list(array $filename_data_list) : void {
    printf(self::template_shema_input_form_begin, "");
    foreach($filename_data_list[self::ui_data_key_root] as $filename_data_for_one_file){
      $path_source = $filename_data_for_one_file[self::ui_key_path_source];
      self::print_filename_shema_input($path_source);
    }
    printf(self::template_shema_input_submit_button, "");
    printf(self::template_shema_input_form_end, "");
  }


  # print input shema by filename data list and print js code to fill it with the data
  public static function print_input_shema_for_filename_data_list_and_fill(array $filename_data_list) : void {
    self::print_input_shema_for_filename_data_list($filename_data_list);
    self::fill_input_shema_with_filename_data_list($filename_data_list);
  }


  # print source path input for the root path of files
  public static function print_source_path_input() : void {
    printf(self::template_source_input_form_begin, "");
    printf(self::input_path_source_template, self::$out_input_shema_index, self::ui_source_input_key_root);
    printf(self::template_source_input_submit_button, "");
    printf(self::template_source_input_form_end, "");
  }


  # print shema search input
  public static function print_filename_shema_search_input() : void {
    printf(self::template_shema_search_input_form_begin,"");
    printf(self::search_connector_input_template, self::$out_input_shema_index, self::ui_search_data_key_root);
    foreach(Main::shema_order_global as $class_id){
      echo "<div class='container_search_disable'>";
      printf(self::search_disable_input_template, self::$out_input_shema_index, self::ui_search_data_key_root, $class_id);
      $class_name = "Filename_Shema_$class_id";
      $class_name::print_filneame_shema_search_input_for_ui(self::$out_input_shema_index);
      echo "</div>";
    }
    printf(self::template_shema_search_submit_button, "");
    printf(self::template_shema_search_input_form_end,"");
    self::$out_input_shema_index++;
  }


  # print delete session button
  public static function print_delete_session_button() : void {
    printf(Ui::template_delete_session_button, "");
  }


  # print error message as js alert
  public static function print_error(string $message) : void {
    if(!empty($message)){
      printf(Ui::template_error_message, $message);
    }
  }

}

?>