<?php

abstract class Main {

  public const shema_order_global = [
    0 => "Categorie",
    1 => "Description",
    2 => "Link",
    3 => "Patch_Level",
    4 => "Installation_Date",
    5 => "Flag"
  ];

  public static function handle_ui_data(array $ui_data=[]) : void {

    try {

      # start session
      if(session_status() == PHP_SESSION_NONE){
        session_start();
      }

      # no ui data existing
      if(empty($ui_data) === true){
        if(isset($_SESSION[Ui::ui_source_input_key_root]) === false){
          Ui::print_source_path_input();
        }
        else {
          Ui::print_filename_shema_input_for_filename_list($_SESSION[Ui::ui_source_input_key_root]);
        }
      }

      // var_dump($ui_data);
      # if source path uploaded
      if(isset($ui_data[Ui::ui_source_input_key_root]) === true){
        if(isset($ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_key]) === false){
          throw new Ui_Exception("Fehler beim verarbeiten der Anfrage. Fehlender Schlüssel: ".Ui::ui_path_source_root_key);
        }
        $source_path = $ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_key];
        if(isset($ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_recursive_key]) === "search_source_dir_recursive"){
          $filename_list = File_Handler::get_filename_list_from_path_recursive($source_path);
        }
        else {
          $filename_list = File_Handler::get_filename_list_from_path_recursive($source_path);
        }
        $_SESSION[Ui::ui_source_input_key_root] = $filename_list;
      }

      # if search input uploaded
      if(isset($ui_data[Ui::ui_search_data_key_root]) === true){
        Search_Shema::set_search_ui_data($ui_data);
        Create_Read_Filename_By_Shema::read_data_from_filename_list_by_shema($_SESSION[Ui::ui_source_input_key_root]);
        $filtered_filename_data = Search_Shema::filter_filename_data_by_search_input($ui_data);
        Ui::print_input_shema_for_filename_data_list_and_fill($filtered_filename_data);
      }

      # if changed filename data uploaded
      if(isset($ui_data[Ui::ui_data_key_root]) === true){
        $new_filename_list = Create_Read_Filename_By_Shema::create_filename_list_by_shema_from_ui_data($ui_data);
        $_SESSION[Ui::ui_source_input_key_root] = $new_filename_list;
        File_Handler::rename_file_from_filename_list($new_filename_list);
        $failed_filename_list = Ui_Failed_Files::get_failed_filename_list();
        var_dump($failed_filename_list);
        Ui::print_filename_shema_input_for_filename_list($failed_filename_list);
      }
    }
    catch(Exception $e){
      return;
    }
  }



}

?>