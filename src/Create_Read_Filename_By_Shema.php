<?php

class Create_Read_Filename_By_Shema {

  public const filename_shema_seperator = "__";
  public const ui_data_key_root = "files";


  # create filename by calling shema classes and connecting results to one string
  # input is ui data part for one file
  public static function create_filename_by_shema_from_ui_data(array $ui_data_for_one_file) : string {
    $result = "";

    foreach(Main::shema_order_global as $shema_index => $shema_class_name){
      $shema_class = "Filename_Shema_$shema_class_name";
      $data = $shema_class::convert_ui_data_to_data($ui_data_for_one_file);
      $result .= $shema_class::convert_data_to_filename($data);
      if($shema_index < count(Main::shema_order_global)-1){
        $result .= Create_Read_Filename_By_Shema::filename_shema_seperator;
      }
    }

    return $result;
  }


  public static function create_filename_list_by_shema_from_ui_data(array $ui_data) : array {
    $result = [];
    $ui_data_for_all_files = $ui_data[Create_Read_Filename_By_Shema::ui_data_key_root];
    foreach($ui_data_for_all_files as $ui_data_for_one_file){
      $path_source_dir = $ui_data_for_one_file[Ui::ui_key_path_source_dir];
      $original_filename = $ui_data_for_one_file[Ui::ui_key_original_filename];
      $new_filename = Create_Read_Filename_By_Shema::create_filename_by_shema_from_ui_data($ui_data_for_one_file);
      $result[$path_source_dir][$original_filename] = $new_filename;
    }
    $result = Create_Read_Filename_By_Shema::add_index_to_double_filenames_in_filename_list($result);
    return $result;
  }


  # add index to double filenames of in a filename list
  # append index of 2, for the second file with the same filename
  # increment index for every duplicate file
  public static function add_index_to_double_filenames_in_filename_list(array $filename_list) : array {

    foreach($filename_list as $path => $array_filenames){
      asort($array_filenames);
      $index = 1;
      $last_new_filename = "";
      foreach($array_filenames as $old_filename => $new_filename){
        if($last_new_filename === $new_filename && $index > 1 && !empty($new_filename)){
          $filename_list[$path][$old_filename] = $new_filename.Create_Read_Filename_By_Shema::filename_shema_seperator.$index;
        }
        else {
          $index = 1;
          $filename_list[$path][$old_filename] = $new_filename;
        }
        $index++;
        $last_new_filename = $new_filename;
      }
    }

    return $filename_list;
  }
}

?>