<?php

abstract class Duplicate_File_Check {

  # handle duplicate file check input
  public static function handle_uploaded_duplicate_file_check_input(array $ui_data) : void {
    if(isset($ui_data[Ui::ui_key_duplicate_file_check_root_key]) === true){

      # store duplicate file check input from start page in session
      self::store_uploaded_duplicate_file_check_input_in_session($ui_data);

      # transform input into array
      $input_file_list = $ui_data[Ui::ui_key_duplicate_file_check_root_key][Ui::ui_key_duplicate_file_check_file_list_input];
      $duplicate_files_path_list = self::transform_duplicate_file_check_input_path_into_array($input_file_list);

      # read files from paths
      # every array element has full path to file
      $filename_list_from_input = [];
      $input_search_recursive = isset($ui_data[Ui::ui_key_duplicate_file_check_root_key][Ui::ui_key_duplicate_file_check_search_recursive]) && $ui_data[Ui::ui_key_duplicate_file_check_root_key][Ui::ui_key_duplicate_file_check_search_recursive] === "on";
      foreach($duplicate_files_path_list as $path_source_duplicate_list){
        $filename_list_from_input = array_merge($filename_list_from_input, $input_search_recursive === true ? File_Handler::get_filename_list_from_path_recursive(trim($path_source_duplicate_list)) : File_Handler::get_filename_list_from_path(trim($path_source_duplicate_list)));
      }

      self::store_file_list_with_special_format_in_session(self::transform_filename_list_into_specific_format_and_check_for_double_files($filename_list_from_input));
    }
  }


  # check for double files from user input from
  public static function check_for_double_files() : void {
    if(isset($_SESSION[Ui::ui_file_list_key_root]) === true && empty($_SESSION[Ui::ui_file_list_key_root]) === false){

      # check if double files exist in filename list stored in session
      # the filename list in session got generated by fetching all files from the source path
      $check_from_filename_list = self::transform_filename_list_into_specific_format_and_check_for_double_files($_SESSION[Ui::ui_file_list_key_root]);

      if(isset($_SESSION[Ui::ui_key_duplicate_file_check_root_key][Ui::ui_key_duplicate_file_check_file_list_for_check]) === true){

        # check for duplicate files when comparing the files from duplicate file check input and the files from the source path
        $check_for_duplicates_input = $_SESSION[Ui::ui_key_duplicate_file_check_root_key][Ui::ui_key_duplicate_file_check_file_list_for_check];
        foreach($check_for_duplicates_input as $full_path_file => $filesize){
          self::check_if_file_is_duplicate($check_from_filename_list, $full_path_file, $filesize);
        }
      }
    }
  }


  private static function transform_filename_list_into_specific_format_and_check_for_double_files(array $filename_list) : array {
    $ret = [];
    foreach($filename_list as $path_directory => $path_file_array){
      foreach($path_file_array as $path_file){
        $full_path_file = $path_directory.File_Handler::path_seperator.$path_file;
        $filesize = filesize($full_path_file);
        if(self::check_if_file_is_duplicate($ret, $full_path_file, $filesize) === false){
          $ret[$full_path_file] = $filesize;
        }
      }
    }
    return $ret;
  }


  # check if file with same filesizes exists already
  # use filesize as array key
  private static function check_if_file_is_duplicate(array $duplicate_file_check_list, string $path_file_to_check, int $filesize) : bool {

    # if file with same filesize exists
    $path_existing_file_in_list = array_search($filesize, $duplicate_file_check_list);
    if($path_existing_file_in_list !== false && hash_file("md5",$path_file_to_check) === hash_file("md5",$path_existing_file_in_list) && $path_existing_file_in_list !== $path_file_to_check){
      Ui::print_error_heading("Es wurden zwei Dateien gefunden, die doppelt sind. Bitte eine der doppelten Dateien entfernen, damit fortgefahren werden kann.");
      Ui::print_duplicate_files_error($path_file_to_check, $path_existing_file_in_list);
      throw new File_Handler_Exception("Es wurden zwei Dateien gefunden, die identisch sind");
      return true;
    }
    return false;
  }


  # transform duplicate file check input from text with whitespace into an array
  private static function transform_duplicate_file_check_input_path_into_array(string $duplicate_file_check_input) : array {
    return array_filter(explode("\n",$duplicate_file_check_input), function($item){
      return empty(trim($item)) === false;
    });
  }


  # store duplicate file check input from start page in session
  private static function store_uploaded_duplicate_file_check_input_in_session(array $ui_data){
    $_SESSION[Ui::ui_key_duplicate_file_check_root_key] = $ui_data[Ui::ui_key_duplicate_file_check_root_key];
  }


  # store file list with file sizes in keys in session
  private static function store_file_list_with_special_format_in_session(array $file_list){
    $_SESSION[Ui::ui_key_duplicate_file_check_root_key][Ui::ui_key_duplicate_file_check_file_list_for_check] = $file_list;
  }

}

?>