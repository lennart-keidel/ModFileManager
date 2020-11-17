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
  private const template_error_message = "<javascript>alert(%s)</javascript>";

  # html template for source path input
  private const input_path_source_template = '
  <div class="container_label_and_input">
    <label for="input_source_path_root">Pfad zum Quellordner</label>
    <input id="input_source_path_root" type="text" name="%1$s[%2$d][path_source_root]">
  </div>
  <div class="container_label_and_input">
    <input id="input_source_path_root_recursive" type="checkbox" name="%1$s[%2$d][path_source_root_options]" value="search_source_dir_recursive">
    <label for="input_source_path_root_recursive">Alle Unterordner und deren Dateien einbinden</label>
  </div>
  ';

  # html template for begin/end of shema input container
  private const template_shema_input_container_begin = '
  <details>
    <summary>%1$s</summary>
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
  private const input_shema_template_path_source = '
  <input type="hidden" name="files[%1$d][path_source]" value="%2$s">
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

  private static $out_input_shema_index = 0;


  # print shema input for one file
  private static function print_filename_shema_input(string $path_source) : void {
    $filename = File_Handler::get_filename_from_path_without_fileextension($path_source);
    printf(self::template_shema_input_container_begin,$filename);
    printf(self::input_shema_template_path_source, self::$out_input_shema_index, $path_source);
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
      var filename_data_list = "%1$s";
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
  public static function print_input_shema_for_filename_data_list_and_fill(array $filename_data_list) : void {
    printf(self::template_shema_input_form_begin, "");
    foreach($filename_data_list[self::ui_data_key_root] as $filename_data_for_one_file){
      $path_source = $filename_data_for_one_file[self::ui_key_path_source];
      self::print_filename_shema_input($path_source);
    }
    printf(self::template_shema_input_submit_button, "");
    printf(self::template_shema_input_form_end, "");
    self::fill_input_shema_with_filename_data_list($filename_data_list);
  }


  # print source path input for the root path of files
  public static function print_source_path_input() : void {
    printf(self::template_source_input_form_begin, "");
    printf(self::input_path_source_template, self::ui_source_input_key_root, self::$out_input_shema_index);
    printf(self::template_source_input_submit_button, "");
    printf(self::template_source_input_form_end, "");
  }


  # print shema search input
  public static function print_filename_shema_search_input() : void {
    printf(self::template_shema_search_input_form_begin,"");
    foreach(Main::shema_order_global as $class_id){
      $class_name = "Filename_Shema_$class_id";
      $class_name::print_filneame_shema_search_input_for_ui(self::$out_input_shema_index);
    }
    printf(self::template_shema_search_submit_button, "");
    printf(self::template_shema_search_input_form_end,"");
    self::$out_input_shema_index++;
  }


  # print error message as js alert
  public static function print_error(string $message) : void {
    if(!empty($message)){
      printf(Ui::template_error_message, $message);
    }
  }

}

?>