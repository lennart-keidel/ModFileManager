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
      # store source path in cookie
      self::store_source_path_in_cookie($ui_data);


      # if source path uploaded
      # store filename list of source files in session data
      self::store_files_from_source_path_in_session($ui_data);

      // # if search input uploaded
      // if(isset($ui_data[Ui::ui_search_data_key_root]) === true){
      //   Search_Shema::set_search_ui_data($ui_data);
      //   Create_Read_Filename_By_Shema::read_data_from_filename_list_by_shema($_SESSION[Ui::ui_source_input_key_root]);
      //   $filtered_filename_data = Search_Shema::filter_filename_data_by_search_input($ui_data);
      //   Ui::print_input_shema_for_filename_data_list_and_fill($filtered_filename_data);
      // }

      # handle uploaded data for files
      # rename files with shema
      # store data for files with errors in session data, gets printed later on
      self::handle_uploaded_file_data($ui_data);



    }
    catch(Exception $e){
      Ui::print_error("Fehler in Main.php");
    }

    self::print_ui();

    var_dump($_SESSION);
  }


  # start session
  # if session data not valid, delete session data
  private static function create_session() : void {

    # start session
    session_start();

    # if session not valid
    # reset session array
    if(session_status() !== PHP_SESSION_ACTIVE ||
    empty($_SESSION) === true || (
      isset($_SESSION[Ui::ui_source_input_key_root]) === false &&
      isset($_SESSION[Ui::ui_search_data_key_root]) === false &&
      isset($_SESSION[Ui::ui_data_key_root]) === false ||
      (isset($_SESSION[Ui::ui_data_key_root]) === true && empty($_SESSION[Ui::ui_data_key_root]) === true)
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
  # store source path in cookie
  private static function store_source_path_in_cookie(array $ui_data) : void {

    # if source path key exists in ui data
    # set expire date: now + 1 month
    if(isset($ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_key]) === true){
      $expire_date = new DateTime();
      $expire_date->add(new DateInterval("P8M"));
      setcookie(Ui::ui_path_source_root_key, $ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_key], $expire_date->getTimestamp(), "/");
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
      if(isset($ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_recursive_key]) === true && $ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_recursive_key] === Ui::ui_path_source_root_recursive_value){
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
      self::remove_original_filename_from_session_data($new_filename_list);

      # if array failed filename data is not empty
      # -> if creation of new filename failed cause of an exception
      #    data of failed filename creations is stored in $failed_filename_data
      # store data from error filenames in session
      try {
        File_Handler::rename_file_from_filename_list($new_filename_list);
      }
      catch(Exception $exception){
      }

      # check failed filename data
      $failed_filename_data = Ui_Failed_Files::get_failed_filename_data();
      if(empty($failed_filename_data[Ui::ui_data_key_root]) === false){
        Ui::print_error_heading("Fehler bei den eingegebenen Daten zu einer Datei:");
        $_SESSION[Ui::ui_data_key_root] = (empty($_SESSION[Ui::ui_data_key_root]) === false ? array_merge($_SESSION[Ui::ui_data_key_root], $failed_filename_data[Ui::ui_data_key_root]) : $failed_filename_data[Ui::ui_data_key_root]);
        var_dump($_SESSION[Ui::ui_data_key_root]);
        return;
      }

      # check failed filename list
      $failed_filename_list = Ui_Failed_Files::get_failed_filename_list();
      if(empty($failed_filename_list) === false){
        Ui::print_error_heading("Fehler bei den eingegebenen Daten zu einer Datei:");
        $_SESSION[Ui::ui_source_input_key_root] = array_merge($_SESSION[Ui::ui_source_input_key_root], $failed_filename_list);
        return;
      }

      # print heading with success message
      Ui::print_success_heading("Die Datei wurde erfolgreich umbenannt.");
    }
  }


  private static function remove_original_filename_from_session_data(array $filename_list) : void {

    # get original filename from filename list
    foreach($filename_list as $path => $array_filename){
      foreach($array_filename as $original_filename => $new_filename){
        $original_path = $path.File_Handler::path_seperator.$original_filename;

        # find original path in session filename data, root key: files
        # remove this filename data
        if(isset($_SESSION[Ui::ui_data_key_root]) === true){
          foreach($_SESSION[Ui::ui_data_key_root] as $index => $file_data){
            if($file_data[Ui::ui_key_path_source] === $original_path){
              unset($_SESSION[Ui::ui_data_key_root][$index]);
              return;
            }
          }
        }

        # find original path in session filename list, root key: source
        # remove this filename list item
        if(isset($_SESSION[Ui::ui_source_input_key_root]) === true){
          $original_parent_directory = File_Handler::remove_trailing_slash_from_path(dirname($original_path));
          $original_filename = basename($original_path);
          $found_key = array_search($original_filename, $_SESSION[Ui::ui_source_input_key_root][$original_parent_directory]);
          if($found_key !== false){
            unset($_SESSION[Ui::ui_source_input_key_root][$original_parent_directory][$found_key]);
            return;
          }
        }
      }
    }
  }


  private static function print_ui() : void {

    # if no source existing in session data
    if(empty($_SESSION) === true){
      Ui::print_source_path_input();
    }

    # if data for files exists in session
    if(isset($_SESSION[Ui::ui_data_key_root]) === true && empty($_SESSION[Ui::ui_data_key_root]) === false){
      Ui::print_input_shema_for_filename_data_list_and_fill($_SESSION);
    }

    # if source existing in session data
    if(isset($_SESSION[Ui::ui_source_input_key_root]) === true && empty($_SESSION[Ui::ui_source_input_key_root]) === false){
      Ui::print_filename_shema_input_for_filename_list($_SESSION[Ui::ui_source_input_key_root]);
    }

    # print delete session button
    Ui::print_delete_session_button();
  }


}

?>