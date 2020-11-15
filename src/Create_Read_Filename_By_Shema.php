<?php

class Create_Read_Filename_By_Shema {

  public const filename_shema_seperator = "__";
  public const ui_data_key_root = "files";


  # create filename by calling shema classes and connecting results to one string
  # input is ui data part for one file
  public static function create_filename_by_shema_from_ui_data(array $ui_data_for_one_file) : string {
    $result = "";

    Shema_Exception::set_source_path($ui_data_for_one_file[Ui::ui_key_path_source]);
    $original_fileextension = File_Handler::get_fileextension_from_path($ui_data_for_one_file[Ui::ui_key_path_source]);
    foreach(Main::shema_order_global as $shema_index => $shema_class_name){
      $shema_class = "Filename_Shema_$shema_class_name";
      $data = $shema_class::convert_ui_data_to_data($ui_data_for_one_file);
      $result .= $shema_class::convert_data_to_filename($data);
      if($shema_index < count(Main::shema_order_global)-1){
        $result .= self::filename_shema_seperator;
      }

    }

    return $result.(empty($original_fileextension) ? "" : ".".$original_fileextension);
  }


  # create filename list of new filenames by whole ui data
  # repeat create_filename_by_shema_from_ui_data function for whole ui data
  # connect to filename list
  public static function create_filename_list_by_shema_from_ui_data(array $ui_data) : array {
    $result = [];
    $ui_data_for_all_files = $ui_data[self::ui_data_key_root];
    foreach($ui_data_for_all_files as $ui_data_for_one_file){
      $path_source_dir = dirname($ui_data_for_one_file[Ui::ui_key_path_source]);
      $original_filename = basename($ui_data_for_one_file[Ui::ui_key_path_source]);
      $new_filename = self::create_filename_by_shema_from_ui_data($ui_data_for_one_file);
      $result[$path_source_dir][$original_filename] = $new_filename;
    }
    $result = self::add_index_to_duplicate_filenames_in_filename_list($result);
    return $result;
  }


  # add index to double filenames of in a filename list
  # append index of 2, for the second file with the same filename
  # increment index for every duplicate file
  public static function add_index_to_duplicate_filenames_in_filename_list(array $filename_list) : array {

    # iterate through filename list
    foreach($filename_list as $path => $array_filenames){

      # sort filename-array by value
      asort($array_filenames);
      $index = 1;
      $last_new_filename = "";

      # iterate through filename-arrays in filename list
      foreach($array_filenames as $old_filename => $new_filename){

        # if at least two consecutive filenames are equal
        # add index of to filename
        if($last_new_filename === $new_filename && $index > 1 && !empty($new_filename)){
          $filename_without_extension = File_Handler::get_filename_from_path_without_fileextension($new_filename);
          $fileextension = File_Handler::get_fileextension_from_path($new_filename);
          $filename_list[$path][$old_filename] = $filename_without_extension.self::filename_shema_seperator.$index.(empty($fileextension) ? "" : ".".$fileextension);
        }
        else {
          $index = 1;
        }
        $index++;
        $last_new_filename = $new_filename;
      }
    }

    return $filename_list;
  }


  # read data from filename by shema
  # reverse process of create_filename_by_shema_from_ui_data
  # call convert_filename_to_data function of Filnema_Shema_* Classes and connect to array
  private static function read_data_from_filename_by_shema(string $filename) : array {
    $result = [];

    $filename = File_Handler::get_filename_from_path_without_fileextension($filename);
    $filename_splitted_by_shema = explode(self::filename_shema_seperator, $filename);
    foreach(Main::shema_order_global as $shema_index => $shema_name){
      $shema_class_name = "Filename_Shema_$shema_name";
      $result = array_merge($result, $shema_class_name::convert_filename_to_data($filename_splitted_by_shema[$shema_index]));
    }

    return $result;
  }



  # read data from filename list by shema
  # reverse process of create_filename_list_by_shema_from_ui_data
  # call read_data_from_filename_by_shema and connect to ui-data array
  public static function read_data_from_filename_list_by_shema(array $filename_list) : array {
    $result = [self::ui_data_key_root => []];

    foreach($filename_list as $path => $array_filenames){
      $result_part = [];
      foreach($array_filenames as $filename){
        Shema_Exception::set_source_path($path."/".$filename);
        $result_part = self::read_data_from_filename_by_shema($filename);
        $result_part[Ui::ui_key_path_source] = $path."/".$filename;
        $result[self::ui_data_key_root][] = $result_part;
      }
    }

    return $result;
  }
}

?>