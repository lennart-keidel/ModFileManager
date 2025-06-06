<?php

# interface for every filename-shema-part
Interface I_Filename_Shema {

  # convert data collected from ui to usable data for following process
  public static function convert_ui_data_to_data(array $data_from_ui) : array;

  # if conditions are met, manipulate something in the internal input data
  public static function manipulate_ui_data(array $data_from_ui) : array;

  # convert data to filename part using this shema
  public static function convert_data_to_filename(array $data_converted) : string;

  # reverse process: converting filename back to data
  public static function convert_filename_to_data(string $filename_part) : array;

  # print converted data from filename to ui
  public static function print_filename_data_for_ui(array $filename_data) : void;

  # print filename shema input to ui
  public static function print_filename_shema_input_for_ui(int $index, string $different_ui_key_root = null, bool $is_required = true) : void;

  # print filename shema input to ui
  public static function print_filename_shema_search_input_for_ui(int $index) : void;

  # get target path considering the conditions of this shema input
  public static function get_target_path_by_condition(array $data_for_one_filename, string $source_path) : array;
}

?>