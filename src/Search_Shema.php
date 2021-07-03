<?php

abstract class Search_Shema {

  private static $search_connector = "";

  public static $search_ui_data = [];

  private const search_connector_valid_values = [ "or", "and" ];

  # ui data key for search shema connector
  public const ui_key_search_connector = "search_shema_connector";


  # set search connector, remove search connector element from search ui data, set search ui data
  public static function set_search_ui_data(array $search_ui_data) : void {
    self::$search_connector = $search_ui_data[self::ui_key_search_connector];
    unset($search_ui_data[self::ui_key_search_connector]);
    unset($search_ui_data[Ui::ui_key_enable_search_shema]);
    self::$search_ui_data = $search_ui_data;
  }


  # check if filename data for one file matches search input with search connector
  public static function check_if_filename_data_for_one_file_matches_search_input(array $filename_data_for_one_input, callable $compare_function = null) : bool {

    # if callable is invalid
    # set default compare function
    # checks if the excact value exists in search-target
    if(is_callable($compare_function) === false || $compare_function === null){
      $compare_function = function(string $search_for, array $search_in) {
        return in_array($search_for, $search_in) === true;
      };
    }

    # iterate through search-target
    foreach(self::$search_ui_data as $search_key => $search_element){

      // if search element is string
      if(is_array($search_element) === false){
        if($compare_function($search_element, $filename_data_for_one_input) === true){
          if(self::$search_connector === "or"){
            return true;
          }
        }
        elseif(self::$search_connector === "and") {
          return false;
        }
      }

      // if search element is array
      else {
        foreach($search_element as $inner_search_element){
          if($compare_function($inner_search_element, $filename_data_for_one_input[$search_key]) === true){
            if(self::$search_connector === "or"){
              return true;
            }
          }
          elseif(self::$search_connector === "and") {
            return false;
          }
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

    if(empty(self::$search_ui_data) === true || empty($filename_data) === true){
      throw new Ui_Exception("Fehler beim Filtern der ausgelesenen Daten. Es wurden keine zu suchenden Daten übermittelt.");
    }

    $result_filtered = array_filter($filename_data[Ui::ui_data_key_root], function($filename_data_for_one_file){
      return self::check_if_filename_data_for_one_file_matches_search_input($filename_data_for_one_file, self::create_callback_function_based_on_search_input());
    });

    return $result_filtered;
  }


  public static function create_callback_function_based_on_search_input() : callable {
    return function(){return true;};
  }


  # check search connector value
  # return false if not valid
  private static function check_search_connector_value(string $value_search_connector) : bool {
    return (in_array($value_search_connector, self::search_connector_valid_values) || empty($value_search_connector) === true);
  }

}

?>