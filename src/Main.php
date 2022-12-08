<?php

abstract class Main {

  public const shema_order_global = [
    0 => "Categorie",
    1 => "Description",
    2 => "Patch_Level",
    3 => "Installation_Date",
    4 => "Flag",
    5 => "Creator",
    6 => "Long_Description",
    7 => "Link",
  ];


  public const ui_shema_order_global = [
    0 => "Link",
    1 => "Creator",
    2 => "Categorie",
    3 => "Description",
    4 => "Long_Description",
    5 => "Patch_Level",
    6 => "Installation_Date",
    7 => "Flag",
  ];

  public static function handle_ui_data(array $ui_data) : void {

    # reset POST and GET array
    $_POST = [];
    $_GET = [];

    try {


      # create session
      Session_Cookie_Handler::create_session();

      # if delete session button pushed
      # delete session
      self::execute_delete_session_button($ui_data);

      # if reread session button pushed
      # delete session
      self::execute_reread_source_path_button($ui_data);

      # if source path uploaded
      # store source path in cookie
      Session_Cookie_Handler::store_source_path_in_cookie($ui_data);

      # if source path uploaded
      # store source path in cookie
      Session_Cookie_Handler::store_source_input_path_and_input_options_in_session($ui_data);

      # if duplicate file check input uploaded
      # store the string in cookie
      Session_Cookie_Handler::store_duplicate_file_check_input_in_file($ui_data);

      # store fast edit input from start page in session
      Session_Cookie_Handler::store_fast_edit_input_in_session($ui_data);

      # if source path option mode uploaded
      # store source option mode in session for later use
      Session_Cookie_Handler::store_source_path_and_source_options_in_session($ui_data);

      # store files from source path in session as filename list
      Session_Cookie_Handler::store_filename_list_from_source_path_in_session($ui_data);

      # handle uploaded data for duplicate file check
      Duplicate_File_Check::handle_uploaded_duplicate_file_check_input($ui_data);

      # check for double files in files from source path
      # check for double files in files from double file path input
      # check for double files in files from double file path input and source path combined
      Duplicate_File_Check::check_for_double_files();

      # use filename list in session to read data from it
      # store filename data in session
      Session_Cookie_Handler::store_filename_data_from_filename_list_in_session($ui_data);

      # if search input uploaded
      Search_Shema::handle_search_input($ui_data);

      # handle uploaded data for files
      # rename files with shema
      # store data for files with errors in session data, gets printed later on
      self::handle_uploaded_file_data($ui_data);

    }
    catch(Exception $e){
    }

    # print ui
    Ui::print_ui();


  }


  # if delete session data is contained in ui-data delete the session
  private static function execute_delete_session_button(array $ui_data) : void {
    if(isset($ui_data["delete_session_button"]) === true){
      Session_Cookie_Handler::delete_session_data();
    }
  }


  # if reread source path is contained in ui-data
  private static function execute_reread_source_path_button(array &$ui_data) : void {
    if(isset($ui_data["reread_source_path_button"]) === true){
      $_POST["source"] = $_SESSION["source"];
      $ui_data["source"] = $_SESSION["source"];
    }
  }


  # if source path uploaded
  # store filename list of source files in session data
  # throw exception if missing root key
  public static function get_filename_list_from_source_path() : array {

    $source_path = empty($_SESSION[Ui::ui_path_source_root_key]) === true ? "" : $_SESSION[Ui::ui_path_source_root_key];

    # if source path option is search files recurisve
    # get filename list from path recursive
    if(isset($_SESSION[Ui::ui_path_source_root_recursive_key]) === true && $_SESSION[Ui::ui_path_source_root_recursive_key] === Ui::ui_path_source_root_recursive_value){
      $filename_list = File_Handler::get_filename_list_from_path_recursive($source_path);
    }

    # if source path option is NOT search files recurisve
    else {
      $filename_list = File_Handler::get_filename_list_from_path($source_path);
    }

    # if retrieved filename list from path is empty
    # throw error
    if(empty($filename_list) === true){
      Session_Cookie_Handler::delete_session_data();
      throw new Ui_Exception("Fehler beim Suchen der Quelldateien. Der Quellpfad enthält keine Sims3Pack- oder Package-Dateien.");
    }

    return $filename_list;
  }


  # handle uploaded data for files
  # rename files with shema
  # store data for files with errors in session data, gets printed later on
  private static function handle_uploaded_file_data(array $ui_data) : void {
    if(isset($ui_data[Ui::ui_data_key_root]) === true){

      $new_filename_list = Create_Read_Filename_By_Shema::create_filename_list_by_shema_from_ui_data($ui_data);
      $failed_filename_data = Ui_Failed_Files::get_failed_filename_data();

      # if array failed filename data is not empty
      # -> if creation of new filename failed cause of an exception
      #    data of failed filename creations is stored in $failed_filename_data
      # store data from error filenames in session
      try {
        File_Handler::set_ui_data($ui_data);
        File_Handler::rename_file_from_filename_list($new_filename_list);
      }
      catch(Exception $exception){
        $failed_filename_data = $ui_data;
      }

      # check failed filename list
      if(empty(Ui_Failed_Files::get_failed_filename_list()) === false){
        $failed_filename_data = $ui_data;
      }

      # check failed filename data
      if(empty($failed_filename_data[Ui::ui_data_key_root]) === false){
        Ui::print_error_heading("Fehler bei den eingegebenen Daten zu einer Datei:");
        Session_Cookie_Handler::replace_original_filename_data_from_session_data($failed_filename_data, true);
        return;
      }

      Session_Cookie_Handler::remove_original_filename_from_session_data($new_filename_list);

      # print heading with success message
      Ui::print_success_heading("Die Datei wurde erfolgreich umbenannt und aus der Liste entfernt.");
    }
  }



}

?>