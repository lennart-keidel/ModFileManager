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
      $filename_list = Main::get_filename_list_from_source_path();
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


  # set search connector, remove search connector element from search ui data, set search ui data
  public static function set_search_ui_data(array $ui_data) : void {
    self::$search_connector = $ui_data[self::ui_key_search_connector];
    self::$search_value_array = $ui_data[Ui::ui_search_data_key_value_root];
    self::$search_operand_array = $ui_data[Ui::ui_search_data_key_operand_root];
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
      // return self::check_if_filename_data_for_one_file_matches_search_input($filename_data_for_one_file, self::create_callback_function_based_on_search_input());
      return self::check_if_filename_data_for_one_file_matches_search_input($filename_data_for_one_file);
    });

    return $result_filtered;
  }


  // public static function create_callback_function_based_on_search_input() : callable {
  //   return function() : bool {
  //     return true;
  //   };
  // }


  # check search connector value
  # return false if not valid
  private static function check_search_connector_value(string $value_search_connector) : bool {
    return (in_array($value_search_connector, self::search_connector_valid_values) || empty($value_search_connector) === true);
  }

}

?>