<?php

# interface for every filename-shema-part
Interface I_Filename_Shema {

  # convert data collected from ui to usable data for following process
  public static function convert_ui_data_to_data(array $data_from_ui) : array;

  # convert data to filename part using this shema
  public static function convert_data_to_filename(array $data_converted) : string;

  # reverse process: converting filename back to data
  public static function convert_filename_to_data(string $filename_part) : array;

  # print converted data from filename to ui
  public static function print_filename_data_for_ui(array $filename_data) : void;

}

?>