<?php

abstract class Search_Shema {

  private static $search_connector = "";

  private static $search_ui_data = [];

  private const search_connector_valid_values = [ "or", "and" ];

  # ui data key for search shema connector
  public const ui_key_search_connector = "search_shema_connector";


  # set search connector, remove search connector element from search ui data, set search ui data
  public static function set_search_ui_data(array $search_ui_data) : void {
    self::$search_connector = $search_ui_data[self::ui_key_search_connector];
    unset($search_ui_data[self::ui_key_search_connector]);
    self::$search_ui_data = $search_ui_data;
  }


  public static function check_if_filename_data_for_one_file_matches_search_input(array $filename_data_for_one_input) : bool {

    foreach(self::$search_ui_data as $search_element){
      if(in_array($search_element, $filename_data_for_one_input) === true){
        if(self::$search_connector === "or"){
          return true;
        }
      }
      elseif(self::$search_connector === "and") {
        return false;
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




}

?>