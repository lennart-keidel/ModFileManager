<?php

abstract class Search_Shema {

  private static $search_connector = "";

  private static $search_value_array = [];
  private static $search_operand_array = [];

  private const search_connector_valid_values = [ "or", "and" ];

  # ui data key for search shema connector
  public const ui_key_search_connector = "search_shema_connector";


  # handle uploaded data from search input
  public static function handle_search_input(array $ui_data) : void {
    if(isset($ui_data[Ui::ui_search_data_key_root]) === true){
      Session_Cookie_Handler::store_search_input_in_session($ui_data);
      self::set_search_ui_data(current($ui_data[Ui::ui_search_data_key_root]));
      $filename_list = self::get_filename_list_for_file_search_in_duplicate_file_paths(Main::get_filename_list_from_source_path());
      Ui::dont_print_errors_from_this_exceptions(Shema_Exception::class);
      $filename_data = Create_Read_Filename_By_Shema::read_data_from_filename_list_by_shema($filename_list);
      Ui::reset_dont_print_errors_from_this_exceptions();
      $filtered_filename_data = Search_Shema::filter_filename_data_by_search_input($filename_data);

      if(empty($filtered_filename_data) === true){
        Ui::print_error_heading("Keine Dateien gefunden, die zu deinen Eingaben passen.");
      }
      else {
        Ui::print_success_heading("Diese Dateien passen zu deinen Eingaben.");
      }
      $_SESSION[Ui::ui_data_key_root] = $filtered_filename_data;
    }
  }


  # if in session additional search in duplicate files option is set in Session
  # search recursive if duplicate file check recurive option is set in Session
  # get filename list of duplicate file paths
  # merge this paths with the input filename list
  # return input with merged pathes
  private static function get_filename_list_for_file_search_in_duplicate_file_paths(array $filename_list_to_merge_with){
    if($_SESSION[Ui::ui_source_input_key_root][Ui::ui_path_source_root_option_mode_search_additional_info] === Ui::ui_path_source_root_option_mode_search_additional_info_value_search_in_double_data_paths_too
    && isset($_SESSION[Ui::ui_key_duplicate_file_check_root_key]) === true
    && isset($_SESSION[Ui::ui_key_duplicate_file_check_root_key][Ui::ui_key_duplicate_file_check_file_list_input]) === true){
      $function_name = isset($_SESSION[Ui::ui_key_duplicate_file_check_root_key][Ui::ui_key_duplicate_file_check_search_recursive]) === true ? "File_Handler::get_filename_list_from_path_recursive" : "File_Handler::get_filename_list_from_path";
      foreach(explode("\n",$_SESSION[Ui::ui_key_duplicate_file_check_root_key][Ui::ui_key_duplicate_file_check_file_list_input]) as $path_duplicate_file_check_dir){
        $path_duplicate_file_check_dir = trim($path_duplicate_file_check_dir);
        $filename_list_to_merge_with = array_merge($filename_list_to_merge_with, $function_name($path_duplicate_file_check_dir));
      }
    }
    return $filename_list_to_merge_with;
  }


  # set search connector, remove search connector element from search ui data, set search ui data
  public static function set_search_ui_data(array $ui_data) : void {
    self::$search_connector = $ui_data[self::ui_key_search_connector];
    self::$search_value_array = $ui_data[Ui::ui_search_data_key_value_root];
    self::$search_operand_array = $ui_data[Ui::ui_search_data_key_operand_root];
  }


  # filter whole filename data array by search
  # return array with filtered filename data
  public static function filter_filename_data_by_search_input(array $filename_data) : array {
    if(self::check_search_connector_value(self::$search_connector) === false){
      throw new Ui_Exception("Fehler beim Filtern der ausgelesenen Daten. Der übermittelte Such-Verbindung ist nicht valide. Such-Verbindung: ".self::$search_connector);
    }

    if(empty(self::$search_value_array) === true || empty($filename_data) === true){
      throw new Ui_Exception("Fehler beim Filtern der ausgelesenen Daten. Es wurden keine zu suchenden Daten übermittelt.");
    }

    $result_filtered = array_filter($filename_data[Ui::ui_data_key_root], function($filename_data_for_one_file){
      return self::check_if_filename_data_for_one_file_matches_search_input($filename_data_for_one_file);
    });

    return $result_filtered;
  }


  # check if filename data for one file matches search input with search connector
  public static function check_if_filename_data_for_one_file_matches_search_input(array $filename_data_for_one_input) : bool {

    # iterate through search-target
    foreach(self::$search_value_array as $search_ui_key => $search_value_array_for_this_key){
      foreach($search_value_array_for_this_key as $index => $search_value){

        if(array_key_exists($search_ui_key, $filename_data_for_one_input) === true){
          $value_to_compare = $filename_data_for_one_input[$search_ui_key];
        }

        # if key not existing in search data
        # this value can't be compared with the search input, cause it's not existing in the file data
        else {

          # if search connector is and
          # return false
          if(self::$search_connector === "and") {
            return false;
          }

          # if search connector is or
          # continue, cause only one search value has to match
          continue;
        }

        $search_operand = self::$search_operand_array[$search_ui_key][$index];
        if($search_ui_key::search_compare($search_value, $search_operand, $value_to_compare, $search_ui_key) === true){
          if(self::$search_connector === "or"){

            # if current search key is Filename_Shema_Flag
            # and flag is something with sub data
            # continue
            # -> this is required, so it doesn't skip the sub data from the flag
            # -> otherwise it just checks that the flag is matching, but not the sub data of the flag
            $ui_data_key_for_sub_data = (array_key_exists($search_value, Filename_Shema_Flag::array_ui_data_key_sub_data) === true ? current(Filename_Shema_Flag::array_ui_data_key_sub_data[$search_value]) : "");
            if($search_ui_key === current(Filename_Shema_Flag::array_ui_data_key) && array_key_exists($ui_data_key_for_sub_data, self::$search_value_array) === true){
              continue;
            }
            return true;
          }
        }
        elseif(self::$search_connector === "and") {
          return false;
        }
      }
    }

    if(self::$search_connector === "or"){
      return false;
    }
    if(self::$search_connector === "and"){
      return true;
    }
    return false;
  }


  # check search connector value
  # return false if not valid
  private static function check_search_connector_value(string $value_search_connector) : bool {
    return (in_array($value_search_connector, self::search_connector_valid_values) || empty($value_search_connector) === true);
  }

}

?>