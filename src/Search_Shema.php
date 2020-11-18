<?php

abstract class Search_Shema {

  private static $search_connector = "";

  private static $search_ui_data = [];

  private const search_connector_valid_values = [ "or", "and" ];

  public static function set_search_ui_data(array $search_ui_data) : void {
    self::$search_ui_data = $search_ui_data;
  }

  private static function check_if_filename_data_for_one_file_matches_search_input(array $filename_data_for_one_input) : bool {

  }




}

?>