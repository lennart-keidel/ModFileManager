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

    # reset POST and GET array
    $_POST = [];
    $_GET = [];

    try {


      # create session
      self::create_session();

      # if delete session button pushed
      # delete session
      self::execute_delete_session_button($ui_data);


      # if source path uploaded
      # store filename list of source files in session data
      self::store_files_from_source_path_in_session($ui_data);

  //     # if search input uploaded
  //     if(isset($ui_data[Ui::ui_search_data_key_root]) === true){
  //       Search_Shema::set_search_ui_data($ui_data);
  //       Create_Read_Filename_By_Shema::read_data_from_filename_list_by_shema($_SESSION[Ui::ui_source_input_key_root]);
  //       $filtered_filename_data = Search_Shema::filter_filename_data_by_search_input($ui_data);
  //       Ui::print_input_shema_for_filename_data_list_and_fill($filtered_filename_data);
  //     }

      # handle uploaded data for files
      # rename files with shema
      # store data for files with errors in session data, gets printed later on
      self::handle_uploaded_file_data($ui_data);



    }
    catch(Exception $e){
      Ui::print_error("Fehler in Main.php");
    }

    # if no source existing in session data
    if(empty($_SESSION) === true){
      Ui::print_source_path_input();
    }

    # if source existing in session data
    if(isset($_SESSION[Ui::ui_source_input_key_root]) === true){
      Ui::print_filename_shema_input_for_filename_list($_SESSION[Ui::ui_source_input_key_root]);
    }

    # if data for files exists in session
    if(isset($_SESSION[Ui::ui_data_key_root]) === true){
      Ui::print_input_shema_for_filename_data_list_and_fill($_SESSION);
    }

    # print delete session button
    Ui::print_delete_session_button();
  }


  # start session
  # if session data not valid, delete session data
  private static function create_session() : void{

    # start session
    session_start();

    # if session not valid
    # reset session array
    if(session_status() !== PHP_SESSION_ACTIVE ||
    empty($_SESSION) === true || (
      isset($_SESSION[Ui::ui_source_input_key_root]) === false &&
      isset($_SESSION[Ui::ui_search_data_key_root]) === false &&
      isset($_SESSION[Ui::ui_data_key_root]) === false
    )){
      self::delete_session_data();
    }
  }


  # remove all session data
  private static function delete_session_data() : void {
    $_SESSION = [];
  }


  # if delete session data is contained in ui-data delete the session
  private static function execute_delete_session_button(array $ui_data) : void {
    if(isset($ui_data["delete_session_button"]) === true){
      self::delete_session_data();
    }
  }


  # if source path uploaded
  # store filename list of source files in session data
  # throw exception if missing root key
  private static function store_files_from_source_path_in_session(array $ui_data) : void {
    if(isset($ui_data[Ui::ui_source_input_key_root]) === true){
      if(isset($ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_key]) === false){
        throw new Ui_Exception("Fehler beim verarbeiten der Anfrage. Fehlender Schlüssel: ".Ui::ui_path_source_root_key);
      }
      $source_path = $ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_key];
      if(isset($ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_recursive_key]) === true && $ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_recursive_key] === "search_source_dir_recursive"){
        $filename_list = File_Handler::get_filename_list_from_path_recursive($source_path);
      }
      else {
        $filename_list = File_Handler::get_filename_list_from_path($source_path);
      }
      if(empty($filename_list) === true){
        self::delete_session_data();
        throw new Ui_Exception("Fehler beim Suchen der Quelldateien. Der Quellpfad enthält keine Sims3Pack- oder Package-Dateien.");
      }
      $_SESSION[Ui::ui_source_input_key_root] = $filename_list;
    }
  }


  # handle uploaded data for files
  # rename files with shema
  # store data for files with errors in session data, gets printed later on
  private static function handle_uploaded_file_data(array $ui_data) : void {
    if(isset($ui_data[Ui::ui_data_key_root]) === true){
      $new_filename_list = Create_Read_Filename_By_Shema::create_filename_list_by_shema_from_ui_data($ui_data);
      $failed_filename_data = Ui_Failed_Files::get_failed_filename_data();
      if(empty($failed_filename_data) === false){
        self::delete_session_data();
        $_SESSION[Ui::ui_data_key_root] = $failed_filename_data[Ui::ui_data_key_root];
      }
      File_Handler::rename_file_from_filename_list($new_filename_list);
    }
  }


}

?>