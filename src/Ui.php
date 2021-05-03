<?php

abstract class Ui {


  # ui data root key for filename shema input
  public const ui_data_key_root = "file_data_list";

  # ui data root key for filename shema input
  public const ui_file_list_key_root = "file_name_list";

  # ui data root key for search input
  public const ui_search_data_key_root = "search";

  # ui data root key for source path input
  public const ui_source_input_key_root = "source";

  # ui data key for source path input
  public const ui_path_source_root_key = "path_source_root";

  # ui data key for source path input to search recursive
  public const ui_path_source_root_recursive_key = "path_source_root_options";

  # ui data value for source path input to search recursive
  public const ui_path_source_root_recursive_value = "search_source_dir_recursive";

  # ui data key for mode
  public const ui_path_source_root_option_mode_key = "path_source_root_options_mode";

  # ui data value for mode: rename files by shema
  public const ui_path_source_root_option_mode_value_rename_files_by_shema = "rename_files_by_shema";

  # ui data value for mode: search source dir for shema files by shema data
  public const ui_path_source_root_option_mode_value_search_source_dir_for_shema_files_by_shema_data = "search_source_dir_for_shema_files_by_shema_data";

  # ui data key for filename source path
  public const ui_key_path_source = "path_source";

  # html template for error messages
  private const template_error_message = '<script>console.log(%1$s);alert(%1$s)</script>';

  # html template for source path input
  private const input_path_source_template = '
  <div class="container_label_and_input">
    <label for="input_source_path_root%1$d">Pfad zum Quellordner</label>
    <input id="input_source_path_root%1$d" type="text" name="'.self::ui_source_input_key_root.'['.self::ui_path_source_root_key.']" value="%2$s" required>
  </div>
  <div class="container_label_and_input">
    <input id="input_source_path_root_recursive%1$d" type="checkbox" name="'.self::ui_source_input_key_root.'['.self::ui_path_source_root_recursive_key.']" value="'.self::ui_path_source_root_recursive_value.'">
    <label for="input_source_path_root_recursive%1$d">Alle Unterordner und deren Dateien einbinden</label>
  </div>
  <div class="container_label_and_input">
    <input id="rename_files_by_shema%1$d" type="radio" name="'.self::ui_source_input_key_root.'['.self::ui_path_source_root_option_mode_key.']" value="'.self::ui_path_source_root_option_mode_value_rename_files_by_shema.'" checked>
    <label for="rename_files_by_shema%1$d">Dateien in Shema-Format bringen</label>
  </div>
  <div class="container_label_and_input">
    <input id="search_source_dir_for_shema_files_by_shema_data%1$d" type="radio" name="'.self::ui_source_input_key_root.'['.self::ui_path_source_root_option_mode_key.']" value="'.self::ui_path_source_root_option_mode_value_search_source_dir_for_shema_files_by_shema_data.'">
    <label for="search_source_dir_for_shema_files_by_shema_data%1$d">Nach Dateien suchen anhand von Shema-Daten</label>
  </div>
  ';

  private const search_connector_input_template = '
  <label class="'.Search_Shema::ui_key_search_connector.'" for="'.Search_Shema::ui_key_search_connector.'">Suche verbinden mit: </label>
  <select class="'.Search_Shema::ui_key_search_connector.'" id="'.Search_Shema::ui_key_search_connector.'%1$d" name="%2$s[%1$d]['.Search_Shema::ui_key_search_connector.']" required>
    <option value="" selected disabled>Auswählen</option>
    <option value="or">Oder</option>
    <option value="and">Und</option>
  </select>
  ';

  private const search_disable_input_template = '
  <input type="checkbox" class="enable_search_shema" id="enable_search_shema%1$d" onclick="disable_input_by_class_name_if_source_element_is_not_checked(\'enable_search_shema%1$d\', \'%2$s%3$d\')" checked>
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
  <div class="input_shema_source_path_ui"><b>Ordner:</b> <span id="file_source_path%1$d">%1$s<span></div><button type="button" class="copy_button_source_path_file" onclick="copyToClipboard(\'#file_source_path%1$d\')">kopieren</button>
  ';

  # html template for hidden input for source path
  private const input_shema_template_path_source = '
  <input type="hidden" class="'.self::ui_key_path_source.'" name="%2$s[%1$d]['.self::ui_key_path_source.']" value="%3$s" id="'.self::ui_key_path_source.'%1$d">
  ';

  private const template_source_input_submit_button = '
  <input type="submit" value="Quellordner eintragen">
  ';

  private const template_shema_search_submit_button = '
  <input type="submit" value="Dateien Suchen">
  ';

  private const template_shema_input_submit_button = '
  <input type="submit" value="Diese Datei umbenennen">
  ';

  private const template_delete_session_button = '
  <form class="delete_session" method="post" action=".">
    <hr id="delete_session_button_divider">
    <input type="submit" id="delete_session_button" name="delete_session_button" value="alle offenen eingetragenen Daten löschen und zurück zum Anfang">
  </form>
  ';

  private const template_heading = '
  <h2>%1$s</h2>
  ';

  private const template_error_heading = '
  <h2 class="error_heading">%1$s</h2>
  ';

  private const template_success_heading = '
  <h2 class="success_heading">%1$s</h2>
  ';

  public static $out_input_shema_index = 0;

  public static $out_individual_index = 0;

  private static $dont_print_errors_from_this_exceptions = [];


  # print shema input for one file
  private static function print_filename_shema_input(string $path_source) : void {
    if(empty($path_source) === true){
      return;
    }
    $filename = basename($path_source);
    $dirname = dirname($path_source);
    printf(self::template_shema_input_container_begin, self::$out_input_shema_index, $filename);
    printf(self::template_shema_input_form_begin, "");
    printf(self::input_shema_template_path_source, self::$out_input_shema_index, self::ui_data_key_root, $path_source);
    printf(self::template_shema_template_path_source_for_ui, $dirname);
    foreach(Main::shema_order_global as $class_id){
      $class_name = "Filename_Shema_$class_id";
      $class_name::print_filename_shema_input_for_ui(self::$out_input_shema_index);
    }
    printf(self::template_shema_input_submit_button, "");
    printf(self::template_shema_input_form_end, "");
    printf(self::template_shema_input_container_end,"");
    self::$out_input_shema_index++;
  }


  # print shema input for each filename of a filename list
  public static function print_filename_shema_input_for_filename_list(array $filename_list) : void {
    foreach($filename_list as $path => $filename_array){
      foreach($filename_array as $filename){
        $source_path = (empty($path) === false ? $path.File_Handler::path_seperator : "")."$filename";
        self::print_filename_shema_input($source_path);
      }
    }
  }


  # print js code to fill shema input with received data from filename after page load
  public static function fill_input_shema_with_filename_data_list(array $filename_data_list) : void {

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
    foreach($filename_data_list[self::ui_data_key_root] as $index => $filename_data_for_one_file){
      $path_source = $filename_data_for_one_file[self::ui_key_path_source];
      self::print_filename_shema_input($path_source);
    }
  }


  # print input shema by filename data list and print js code to fill it with the data
  public static function print_input_shema_for_filename_data_list_and_fill(array $filename_data_list) : void {
    $filename_data_list[self::ui_data_key_root] = array_values($filename_data_list[self::ui_data_key_root]); # remove bug where id for frontend is starts not at 0
    self::print_input_shema_for_filename_data_list($filename_data_list);
    self::fill_input_shema_with_filename_data_list($filename_data_list);
  }


  # print source path input for the root path of files
  public static function print_source_path_input() : void {
    printf(self::template_source_input_form_begin, "");
    $source_path_value = (isset($_COOKIE[self::ui_path_source_root_key]) === true ? str_replace("+"," ",$_COOKIE[self::ui_path_source_root_key]) : "");
    printf(self::input_path_source_template, self::$out_input_shema_index, $source_path_value);
    printf(self::template_source_input_submit_button, "");
    printf(self::template_source_input_form_end, "");
  }


  # print shema search input
  public static function print_filename_shema_search_input() : void {
    $index = 1000000;
    printf(self::template_shema_search_input_form_begin,"");
    printf(self::search_connector_input_template, $index, self::ui_search_data_key_root);
    foreach(Main::shema_order_global as $class_id){
      echo "<div class='container_search_disable'>";
      $class_name = "Filename_Shema_$class_id";
      printf(self::search_disable_input_template, self::$out_individual_index++, $class_name, $index);
      $class_name::print_filneame_shema_search_input_for_ui($index);
      echo "</div>";
    }
    printf(self::template_shema_search_submit_button, "");
    printf(self::template_shema_search_input_form_end,"");
  }


  # print delete session button
  public static function print_delete_session_button() : void {
    printf(self::template_delete_session_button, "");
  }


  # print heading
  public static function print_heading(string $content) : void {
    printf(self::template_heading, $content);
  }


  # print heading for error message
  public static function print_error_heading(string $content) : void {
    printf(self::template_error_heading, $content);
  }


  # print heading for success message
  public static function print_success_heading(string $content) : void {
    printf(self::template_success_heading, $content);
  }


  # add class name to exception array
  public static function dont_print_errors_from_this_exceptions(string $class_name) : void {
    self::$dont_print_errors_from_this_exceptions[] = $class_name;
  }


  # reset exception array
  public static function reset_dont_print_errors_from_this_exceptions() : void {
    self::$dont_print_errors_from_this_exceptions = [];
  }


  # print error message as js alert
  public static function print_error(string $message, string $class_name) : void {
    if(!empty($message) && in_array($class_name, self::$dont_print_errors_from_this_exceptions) === false){
      printf(self::template_error_message, $message);
    }
  }

}

?>