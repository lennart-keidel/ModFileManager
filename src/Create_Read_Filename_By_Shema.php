<?php

class Create_Read_Filename_By_Shema {

  public const filename_shema_seperator = "__";
  public const ui_data_key_root = "files";

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
}

?>