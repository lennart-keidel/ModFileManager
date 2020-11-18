<?php

abstract class Ui_Failed_Files extends Ui {

  private static $failed_filename_data = [ self::ui_data_key_root => [] ];
  private static $failed_filename_list = [];


  # save failed filename data
  public static function add_failed_filename_data(array $filename_data) : void {
    self::$failed_filename_data[self::ui_data_key_root][] = $filename_data;
  }


  # return failed filename data
  public static function get_failed_filename_data() : array {
    return self::$failed_filename_data;
  }


  # save failed filename list
  public static function add_failed_filename_list(array $filename_list) : void {
    self::$failed_filename_list = array_merge(self::$failed_filename_list, $filename_list);
  }


  # return failed filename list
  public static function get_failed_filename_list() : array {
    return self::$failed_filename_list;
  }


  // # check format of processed data from filename
  // public static function check_format_filename_data(array $filename_data) : bool {
  //   return (is_array($filename_data) && isset($filename_data[Ui::ui_key_path_source]) && is_string($filename_data[Ui::ui_key_path_source]) && !empty($filename_data[Ui::ui_key_path_source]) && count($filename_data) > 1);
  // }


  // # check format of filename list received by file handler
  // public static function check_format_filename_list(array $filename_list) : bool {
  //   return (is_array($filename_list) && isset($filename_list[Ui::ui_key_path_source]) && is_string($filename_list[Ui::ui_key_path_source]) && !empty($filename_list[Ui::ui_key_path_source]) && count($filename_list) > 1);
  // }


  # print input shema for failed filenames by failed filename list
  public static function print_input_shema_for_failed_filename_list() : void {
    self::print_filename_shema_input_for_filename_list(self::$failed_filename_list);
  }


  # print input shema for failed filenames by failed filename data
  public static function print_input_shema_for_failed_filename_data() : void {
    self::print_input_shema_for_filename_data_list(self::$failed_filename_data);
  }


}