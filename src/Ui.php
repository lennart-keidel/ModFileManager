<?php

abstract class Ui {


  # ui data root key for filename shema input
  public const ui_data_key_root = "file_data_list";

  # ui data root key for filename shema input
  public const ui_file_list_key_root = "file_name_list";

  # ui data root key for search input
  public const ui_search_data_key_root = "search";

  # ui data root key for fast edit input
  public const ui_fast_edit_data_key_root = "fast_edit";

  # ui key blacklist entries
  public const ui_blacklist_entries_session_key = "blacklist_entries";

  public const ui_url_api_cache_data_key_root = "url_api_cache";

  public const ui_search_index = 1000000;

  public const ui_fast_edit_index = 11111111;

  # ui data root key for values to search for
  public const ui_search_data_key_value_root = "value";

  # ui data root key for operands to search with
  public const ui_search_data_key_operand_root = "operand";

  # ui data root key for source path inputf
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

  public const ui_key_error_flag_for_filename_data = "error";

  public const ui_key_enable_search_shema = "enable_search_shema";

  public const ui_key_auto_move_file = "auto_move_file";

  public const ui_key_auto_move_file_into_sub_dir = "auto_move_file_into_sub_dir";

  public const ui_key_disable_auto_move_file = "disbale_auto_move_file";

  public const ui_key_duplicate_file_check_root_key = "duplicate_file_check";

  public const ui_key_duplicate_file_check_file_list_input = "file_list_input";

  public const ui_key_duplicate_file_check_search_recursive = "search_duplicate_file_check_recursive";

  public const ui_key_duplicate_file_check_file_list_for_check = "file_list_for_check";


  # html template for error messages
  private const template_error_message = '<script>console.log("%1$s");alert("%1$s")</script>';

  # html template for source path input
  private const input_path_source_template = '
  <div class="container_label_and_input">
    <label for="input_source_path_root%1$d">Pfad zum Quellordner</label>
    <input id="input_source_path_root%1$d" type="text" name="'.self::ui_source_input_key_root.'['.self::ui_path_source_root_key.']" value="%2$s" size="120" required>
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
  <label class="'.Search_Shema::ui_key_search_connector.'" for="'.Search_Shema::ui_key_search_connector.'%1$d">Suche verbinden mit: </label>
  <select class="'.Search_Shema::ui_key_search_connector.'" id="'.Search_Shema::ui_key_search_connector.'%1$d" name="%2$s[%1$d]['.Search_Shema::ui_key_search_connector.']" required>
    <option value="or" selected>Oder</option>
    <option value="and">Und</option>
  </select>
  ';

  private const search_disable_input_template = '
  <script>window.addEventListener("load", function () {disable_input_by_class_name_if_source_element_is_not_checked("'.self::ui_key_enable_search_shema.'%1$d", "%2$s_root%3$d");});</script>
  <input type="checkbox" name="search['.self::ui_search_index.']['.self::ui_key_enable_search_shema.'][]" value="'.self::ui_key_enable_search_shema.'%1$d" class="'.self::ui_key_enable_search_shema.'" id="'.self::ui_key_enable_search_shema.'%1$d" onclick="disable_input_by_class_name_if_source_element_is_not_checked(\''.self::ui_key_enable_search_shema.'%1$d\', \'%2$s_root%3$d\')">
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
  <form class="source_input" method="post" action="." autocomplete="on">
  ';
  private const template_source_input_form_end = '
  </form>
  <br>
  <hr>
  ';

  # html template for begin/end of shema input form
  private const template_shema_input_form_begin = '
  <form class="shema_input%1$d" id="shema_input%1$d" method="post" action="." autocomplete="on">
  ';
  private const template_shema_input_form_end = '
  </form>
  ';

  # html template for begin/end of shema search form
  private const template_shema_search_input_form_begin = '
  <form class="shema_search" method="post" action="." autocomplete="on">
  ';
  private const template_shema_search_input_form_end = '
  </form>
  ';

  # html template for begin/end of shema fast edit form
  private const template_shema_fast_edit_input_form_begin = '
  <br>
  <br>
  <hr>
  <h3>Zum Kopieren der Daten</h3>
  <form class="shema_fast_edit" id="shema_fast_edit" method="post" action="." autocomplete="on">
  ';
  private const template_shema_fast_edit_input_form_end = '
  <input type="submit" value="speichern">
  <hr>
  <br>
  <br>
  </form>
  ';

  # html template for hidden input for source path
  private const template_shema_template_button_copy_from_fast_edit_form = '
  <br>
  <div class="input_shema_source_path_ui">
    <button type="button" class="copy_button_source_path_file" onclick="copy_data_from_fast_edit_form_into_file_input_form(\'#shema_fast_edit\',\'#shema_input%1$d\', false)">Daten von oben übernehmen</button>
    <br>
    <br>
    <button type="button" class="copy_button_source_path_file" onclick="copy_data_from_fast_edit_form_into_file_input_form(\'#shema_fast_edit\',\'#shema_input%1$d\', true)">Daten von oben übernehmen und überschreiben</button>
  </div>
  <br>
  <br>
  ';

  # html template for hidden input for source path
  private const template_shema_template_path_source_for_ui = '
  <div class="input_shema_source_path_ui"><b>Ordner:</b> <span id="file_source_path%1$d">%2$s<span></div><button type="button" class="copy_button_source_path_file" onclick="copyToClipboard(\'#file_source_path%1$d\')">kopieren</button>
  ';

  # html template for hidden input for source path
  private const input_shema_template_path_source = '
  <input type="hidden" class="'.self::ui_key_path_source.'" name="%2$s[%1$d]['.self::ui_key_path_source.']" value="%3$s" id="'.self::ui_key_path_source.'%1$d">
  ';

  private const template_source_input_submit_button = '
  <input type="submit" value="Fortfahren">
  ';

  private const template_shema_search_submit_button = '
  <input type="submit" value="Dateien Suchen">
  ';

  private const template_shema_input_submit_button = '
  <input type="submit" value="Diese Datei umbenennen">
  ';

  private const template_delete_session_button = '
  <form class="delete_session" method="post" action=".">
    <button type="submit" class="delete_session_button" name="delete_session_button" onclick="return confirm(this.value);" value="alle offenen eingetragenen Daten löschen und zurück zum Anfang">alle offenen eingetragenen Daten löschen und zurück zum Anfang</button>
    <br>
    <br>
  </form>
  ';

  private const template_reread_source_path_button = '
  <form class="reread_source_path" method="post" action=".">
    <button type="submit" class="reread_source_path_button" name="reread_source_path_button" onclick="return confirm(this.value);" value="Quellpfad neu einlesen">Quellpfad neu einlesen</button>
    <br>
    <br>
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

  # templpate for search operand select option input
  private const search_operand_select_option_template = '<option value="%1$s">%2$s</option>'."\n";

  # template for buttons to add additional search input
  private const search_add_additional_input_buttons_template = '<button type="button" class="%2$s%1$d search_plus_button" onclick="add_search_input_with_plus_button($(this))">+</button>'."\n";

  # template for buttons to remove additional search input
  private const search_remove_additional_input_buttons_template = '<button type="button" class="%2$s%1$d search_minus_button" onclick="remove_search_input_with_minus_button($(this))">-</button>'."\n";

  # template for checkbox to auto move file
  private const template_auto_move_file = '
  <br>
  <div class="container_label_and_input">
    <label>Aktion nach erfolgreichem umbenennen</label>
    <select class="%2$s" name="%2$s" id="%2$s%1$d">
      <option value="%3$s">Datei nicht automatisch verschieben</option>
      <option value="%2$s" selected>Datei automatisch zum Installationsort verschieben</option>
      <option value="%4$s">Datei automatisch in einen Sub-Ordner vom Quellordner verschieben</option>
    </select>
  </div>
  ';

  # template for duplicate file check input path list on start page
  private const template_duplicate_file_check_input_source_path_list = '
  <div class="container_label_and_input">
    <br>
    <label for="%3$s">Doppelte Dateien vermeiden: Pfade zu Sims3Pack- und Package-Dateien</label>
    <textarea style="white-space: nowrap" wrap="hard" class="%1$s" name="%1$s[%3$s]" id="%3$s" cols="60" rows="15" placeholder="Füge hier Pfade zu Odnern mit Sims3Pack- und Package-Dateien ein. Diese werden, mit den Dateien die umbenannt werden sollen, auf Duplikate geprüft.">%5$s</textarea>
    <br>
    <input type="checkbox" id="%4$s" name="%1$s[%4$s]" checked>
    <label for="%4$s">Auch Unterordner auf Dupliakte durchsuchen</label>
  </div>
  ';

  # template for copy buttons of the duplicate file error
  private const template_duplicate_file_error_copy_button = '
  <br>
  <h3 class="error_heading">Pfad #%3$s: %1$s</h3>
  <div class="input_shema_source_path_ui">
    <span style="display:none;" id="duplicate_file_error_path_to_file_full_%5$s">%1$s</span>
    <span style="display:none;" id="duplicate_file_error_path_to_file_directory_%5$s">%2$s</span>
    <button type="button" onclick="copyToClipboard(\'#duplicate_file_error_path_to_file_full_%5$s\')">Pfad zur Datei kopieren</button>
    <button type="button" onclick="copyToClipboard(\'#duplicate_file_error_path_to_file_directory_%5$s\')">Pfad zum Ordner kopieren</button>
  </div>
  <br>
  <br>
  %4$s
  ';

  # allways open first file detail-element for file input
  # print js script with function 'open_first_details_slot'
  private const template_open_first_details_slot = '
    <script>
      open_first_details_slot();
    </script>
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
    printf(self::template_shema_template_button_copy_from_fast_edit_form, self::$out_input_shema_index);
    printf(self::template_shema_input_form_begin, self::$out_input_shema_index);
    printf(self::input_shema_template_path_source, self::$out_input_shema_index, self::ui_data_key_root, $path_source);
    printf(self::template_shema_template_path_source_for_ui, self::$out_input_shema_index, $dirname);
    foreach(Main::ui_shema_order_global as $class_id){
      $class_name = "Filename_Shema_$class_id";
      $class_name::print_filename_shema_input_for_ui(self::$out_input_shema_index);
    }
    printf(self::template_shema_input_submit_button, "");
    printf(self::template_auto_move_file, self::$out_input_shema_index, self::ui_key_auto_move_file, self::ui_key_disable_auto_move_file, self::ui_key_auto_move_file_into_sub_dir);
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


  # print js code to fill search shema input with received data from filename after page load
  public static function fill_search_input_shema_with_filename_data_list(array $filename_data_list) : void {

    $js_template_code = '
    <script>
    document.addEventListener("DOMContentLoaded", function(){
      var filename_data_list = %1$s;
      fill_search_input_shema_with_filename_data_list(filename_data_list);
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


  # print js code to fill shema input with received data from filename after page load
  public static function fill_fast_edit_input_shema_with_filename_data_list(array $filename_data_list) : void {

    $js_template_code = '
    <script>
    document.addEventListener("DOMContentLoaded", function(){
      var filename_data_list = %1$s;
      fill_fast_edit_input_shema_with_filename_data_list(filename_data_list);
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



  # print js code to fill search shema input with received data from filename after page load
  public static function print_set_data_in_element_by_class(string $id, mixed $value) : void {

    $js_template_code = '
    <script>
    document.addEventListener("DOMContentLoaded", function(){
      var id = "%1$s";
      var value = "%2$s";
      set_data_in_element_by_class(id, value);
    });
    </script>
    ';

    printf($js_template_code, $id, $value);
  }


  # print input shema by filename data list and print js code to fill it with the data
  protected static function print_input_shema_for_filename_data_list(array $filename_data_list) : void {
    foreach($filename_data_list[self::ui_data_key_root] as $filename_data_for_one_file){
      $path_source = $filename_data_for_one_file[self::ui_key_path_source];
      self::print_filename_shema_input($path_source);
    }
  }


  # print input shema by filename data list and print js code to fill it with the data
  public static function print_input_shema_for_filename_data_list_and_fill(array $filename_data_list) : void {
    $filename_data_list[self::ui_data_key_root] = array_values($filename_data_list[self::ui_data_key_root]);
    self::print_input_shema_for_filename_data_list($filename_data_list);
    self::fill_input_shema_with_filename_data_list($filename_data_list);
  }


  # print input shema by filename data list and print js code to fill it with the data
  public static function print_filename_shema_fast_edit_input_and_fill(array $filename_data_list) : void {
    self::print_filename_shema_fast_edit_input();
    if(isset($filename_data_list[self::ui_fast_edit_data_key_root]) === true){
      // $filename_data_list[self::ui_fast_edit_data_key_root] = array_values($filename_data_list[self::ui_fast_edit_data_key_root]);
      self::fill_fast_edit_input_shema_with_filename_data_list($filename_data_list);
    }
  }


  # print source path input for the root path of files
  public static function print_source_path_input_end() : void {
    printf(self::template_source_input_submit_button, "");
    printf(self::template_source_input_form_end, "");
  }

  public static function print_source_path_input_start() : void {
    printf(self::template_source_input_form_begin, "");
    $source_path_value = (isset($_COOKIE[self::ui_path_source_root_key]) === true ? str_replace("+"," ",$_COOKIE[self::ui_path_source_root_key]) : "");
    printf(self::input_path_source_template, self::$out_input_shema_index, $source_path_value);
    printf(self::template_auto_move_file, "", self::ui_key_auto_move_file, self::ui_key_disable_auto_move_file, self::ui_key_auto_move_file_into_sub_dir);
  }


  # print shema search input
  public static function print_filename_shema_search_input() : void {
    printf(self::template_shema_search_input_form_begin,"");
    printf(self::search_connector_input_template, self::ui_search_index, self::ui_search_data_key_root);
    foreach(Main::ui_shema_order_global as $class_id){
      echo "<div class='container_search_disable'>";
      $class_name = "Filename_Shema_$class_id";
      printf(self::search_disable_input_template, self::$out_individual_index++, $class_name, self::ui_search_index);
      $class_name::print_filename_shema_search_input_for_ui(self::ui_search_index);
      echo "</div>";
    }
    printf(self::template_shema_search_submit_button, "");
    printf(self::template_shema_search_input_form_end,"");
  }


  # print shema for fast edit input
  public static function print_filename_shema_fast_edit_input() : void {
    printf(self::template_shema_fast_edit_input_form_begin,"");
    foreach(Main::ui_shema_order_global as $class_id){
      $class_name = "Filename_Shema_$class_id";
      $class_name::print_filename_shema_input_for_ui(self::ui_fast_edit_index, self::ui_fast_edit_data_key_root, false);
    }
    printf(self::template_shema_fast_edit_input_form_end,"");
  }


  # print duplicate file erros
  private static $duplicate_file_error_index = 1;
  public static function print_duplicate_files_error(string $path1, string $path2) : void {
    printf(self::template_duplicate_file_error_copy_button, $path1, dirname($path1), 1, "", self::$duplicate_file_error_index++);
    printf(self::template_duplicate_file_error_copy_button, $path2, dirname($path2), 2, "<hr>", self::$duplicate_file_error_index++);
  }


  # print delete session button
  public static function print_delete_session_button() : void {
    printf(self::template_delete_session_button, "");
  }


  # print reread source path button
  public static function print_reread_source_path_button() : void {
    printf(self::template_reread_source_path_button, "");
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
  public static function print_error(string $message, string $class_name = "") : void {
    if(empty($message) === false && in_array($class_name, self::$dont_print_errors_from_this_exceptions) === false){
      printf(self::template_error_message, trim($message));
    }
  }

  # generate search operand select option for ui
  # returns the html code
  # does not print the html code
  public static function generate_search_operand_select_options_ui(string $class_reference) : string {
    $result = "";
    foreach($class_reference::get_search_operand() as $key_operand => $fe_operand){
      $result .= sprintf(self::search_operand_select_option_template, $key_operand, $fe_operand["text"]);
    }
    return $result;
  }

  # generate buttons for additional search inputs for ui
  # returns html code
  # does not print the html code
  public static function generate_additional_search_buttons_ui(string $class_reference) : string {
    $result = sprintf(self::search_add_additional_input_buttons_template, self::ui_search_index, $class_reference);
    $result .= sprintf(self::search_remove_additional_input_buttons_template, self::ui_search_index, $class_reference);
    return $result;
  }

  # print open blacklist site button, to open the blacklisting feature site
  public static function print_open_blacklist_site_button() : void {
    echo '<br><br><br><a href="./blacklist.php"><button>Mod-Blacklisting öffnen</button></a>';
  }


  public static function print_start_page_heading() : void {
    echo "<h3>Mod-Dateinamen-Manager</h3>";
  }


  public static function print_duplicate_file_check_input() : void {
    $duplicate_file_check_saved_input = (isset($_COOKIE[self::ui_key_duplicate_file_check_file_list_input]) === true ? str_replace("+"," ",$_COOKIE[self::ui_key_duplicate_file_check_file_list_input]) : "");
    printf(self::template_duplicate_file_check_input_source_path_list, self::ui_key_duplicate_file_check_root_key, "", self::ui_key_duplicate_file_check_file_list_input, self::ui_key_duplicate_file_check_search_recursive, $duplicate_file_check_saved_input);
  }

  # allways open first file detail-element for file input
  # print js script with function 'open_first_details_slot'
  public static function open_first_details_slot() : void {
    printf(self::template_open_first_details_slot, "");
  }


  # main function for handeling ui printing
  public static function print_ui() : void {

    # if no source existing in session data
    if(Session_Cookie_Handler::is_session_startpage() === true){
      self::print_start_page_heading();
      self::print_source_path_input_start();
      self::print_duplicate_file_check_input();
      self::print_source_path_input_end();

      # pull recent data from git on printing start page
      Git_Auto_Pull_Push::pull();
    }

    # if not start page
    # print delete session button
    if(Session_Cookie_Handler::is_session_startpage() === false){
      self::print_delete_session_button();

      if($_SESSION[self::ui_path_source_root_option_mode_key] !== self::ui_path_source_root_option_mode_value_search_source_dir_for_shema_files_by_shema_data){
        self::print_reread_source_path_button();
      }
    }

    # if source path option mode is search
    # print search input
    if($_SESSION[self::ui_path_source_root_option_mode_key] === self::ui_path_source_root_option_mode_value_search_source_dir_for_shema_files_by_shema_data){
      self::print_filename_shema_search_input();
      self::fill_search_input_shema_with_filename_data_list([self::ui_data_key_root => $_SESSION[self::ui_search_data_key_root]]);
    }

    # print fast edit input form
    if(Session_Cookie_Handler::is_session_startpage() === false){
      self::print_filename_shema_fast_edit_input_and_fill($_SESSION);
    }

    # if data for files exists in session
    if(isset($_SESSION[self::ui_data_key_root]) === true && empty($_SESSION[self::ui_data_key_root]) === false){
      self::print_input_shema_for_filename_data_list_and_fill($_SESSION);
    }

    # if source existing in session data
    if(isset($_SESSION[self::ui_file_list_key_root]) === true && empty($_SESSION[self::ui_file_list_key_root]) === false){
      self::print_filename_shema_input_for_filename_list($_SESSION[self::ui_file_list_key_root]);
    }

    # if auto move file is enabled
    # print js for the right select value to all file inputs
    if(isset($_SESSION[self::ui_key_auto_move_file]) === true && empty($_SESSION[self::ui_key_auto_move_file]) === false){
      self::print_set_data_in_element_by_class(self::ui_key_auto_move_file, $_SESSION[self::ui_key_auto_move_file]);
    }

    # if not start page
    # print delete session button
    if(Session_Cookie_Handler::is_session_startpage() === false){
      Session_Cookie_Handler::store_blacklist_entries_in_session();
      self::print_delete_session_button();
    }

    # if start page
    # print open blacklist site button, to navigate to the mod-blacklist page
    if(Session_Cookie_Handler::is_session_startpage() === true){
      self::print_open_blacklist_site_button();
    }

    # allways open first file detail-element for file input
    self::open_first_details_slot();
  }

}

?>