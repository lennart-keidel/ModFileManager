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

      # if source path option mode uploaded
      # store source option mode in session for later use
      self::store_source_path_and_source_options_in_session($ui_data);

      # store files from source path in session
      self::store_filename_list_from_source_path_in_session($ui_data);

      # if search input uploaded
      self::handle_search_input($ui_data);

      # handle uploaded data for files
      # rename files with shema
      # store data for files with errors in session data, gets printed later on
      self::handle_uploaded_file_data($ui_data);
    }
    catch(Exception $e){
    }

    # print ui
    self::print_ui();
  }


  # start session
  # if session data not valid, delete session data
  private static function create_session() : void {

    # start session
    # session is active for one day
    session_start([
      'cookie_lifetime' => 86400,
    ]);

    # if session not valid
    # reset session array
    if(session_status() !== PHP_SESSION_ACTIVE ||
    empty($_SESSION) === true || (
      (isset($_SESSION[Ui::ui_path_source_root_key]) === false || empty($_SESSION[Ui::ui_path_source_root_key]) === true) &&
      (isset($_SESSION[Ui::ui_path_source_root_option_mode_key]) === false || empty($_SESSION[Ui::ui_path_source_root_option_mode_key]) === true) &&
      isset($_SESSION[Ui::ui_file_list_key_root]) === false &&
      isset($_SESSION[Ui::ui_search_data_key_root]) === false &&
      isset($_SESSION[Ui::ui_data_key_root]) === false
    )){
      self::delete_session_data();
    }
  }


  # remove all session data
  private static function delete_session_data() : void {
    echo "<script>console.log('Sessiondaten gelöscht.')</script>";
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
  # store source path in cookie
  private static function store_search_input_in_session(array $ui_data) : void {

    # if source path key exists in ui data
    # set expire date: now + 1 month
    if(isset($ui_data[Ui::ui_search_data_key_root]) === true){
      $_SESSION[Ui::ui_search_data_key_root] = $ui_data[Ui::ui_search_data_key_root];
    }
  }


  # if source path uploaded
  # store filename list of source files in session data
  # throw exception if missing root key
  private static function get_filename_list_from_source_path() : array {

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
        self::delete_session_data();
        throw new Ui_Exception("Fehler beim Suchen der Quelldateien. Der Quellpfad enthält keine Sims3Pack- oder Package-Dateien.");
      }

      return $filename_list;
  }


  # if source path option mode is replace filename by shema
  # store filename list from source path in session
  # try to get data from filename
  # if successfull save filename data in session and delete filename from filename list in session
  private static function store_filename_list_from_source_path_in_session(array $ui_data) : void {
    if(isset($ui_data[Ui::ui_source_input_key_root]) === true && $_SESSION[Ui::ui_path_source_root_option_mode_key] === Ui::ui_path_source_root_option_mode_value_rename_files_by_shema) {
      $filename_list = self::get_filename_list_from_source_path();
      $filename_data_list = [];
      Ui::dont_print_errors_from_this_exceptions(Shema_Exception::class);
      foreach($filename_list as $path_directory => $filename_array){
        foreach($filename_array as $index => $filename){
          try {
            $filename_data = Create_Read_Filename_By_Shema::read_data_from_filename_by_shema($filename);
            $filename_data[Ui::ui_key_path_source] = $path_directory.File_Handler::path_seperator.$filename;
            $filename_data_list[] = $filename_data;
            unset($filename_list[$path_directory][$index]);
            if(empty($filename_data[$path_directory]) === true){
              unset($filename_data[$path_directory]);
            }
          }
          catch(Exception $exception){
            continue;
          }
        }
      }
      Ui::reset_dont_print_errors_from_this_exceptions();
      if(empty($filename_list) === false){
        $_SESSION[Ui::ui_file_list_key_root] = $filename_list;
      }
      if(empty($filename_data_list) === false){
        $_SESSION[Ui::ui_data_key_root] = $filename_data_list;
      }
    }
  }


  private static function handle_search_input(array $ui_data) : void {
    if(isset($ui_data[Ui::ui_search_data_key_root]) === true){
      self::store_search_input_in_session($ui_data);
      Search_Shema::set_search_ui_data(current($ui_data[Ui::ui_search_data_key_root]));
      $filename_list = self::get_filename_list_from_source_path();
      Ui::dont_print_errors_from_this_exceptions(Shema_Exception::class);
      $filename_data = Create_Read_Filename_By_Shema::read_data_from_filename_list_by_shema($filename_list);
      Ui::reset_dont_print_errors_from_this_exceptions();
      $filtered_filename_data = Search_Shema::filter_filename_data_by_search_input($filename_data);

      if(empty($filtered_filename_data) === true){
        Ui::print_error_heading("Keine Dateien gefunden, die zu deinen Eingaben passen.");
      }
      else {
        Ui::print_success_heading("Diese Dateien passen zu deinen Eingaben.");
      }
      $_SESSION[Ui::ui_data_key_root] = $filtered_filename_data;
    }
  }


  # handle uploaded data for files
  # rename files with shema
  # store data for files with errors in session data, gets printed later on
  private static function handle_uploaded_file_data(array $ui_data) : void {
    if(isset($ui_data[Ui::ui_data_key_root]) === true){

      $new_filename_list = Create_Read_Filename_By_Shema::create_filename_list_by_shema_from_ui_data($ui_data);


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
        self::replace_original_filename_data_from_session_data($failed_filename_data, true);
        // $_SESSION[Ui::ui_data_key_root] = array_merge((isset($_SESSION[Ui::ui_data_key_root]) === true ? $_SESSION[Ui::ui_data_key_root] : []), $failed_filename_data[Ui::ui_data_key_root]);
        return;
      }

      # check failed filename list
      $failed_filename_list = Ui_Failed_Files::get_failed_filename_list();
      if(empty($failed_filename_list) === false){
        $failed_filename_list[UI::ui_key_error_flag_for_filename_data] = true;
        Ui::print_error_heading("Fehler bei den eingegebenen Daten zu einer Datei:");
        // $_SESSION[Ui::ui_file_list_key_root] = array_merge_recursive($_SESSION[Ui::ui_file_list_key_root], $failed_filename_list);
        return;
      }

      self::remove_original_filename_from_session_data($new_filename_list);

      # print heading with success message
      Ui::print_success_heading("Die Datei wurde erfolgreich umbenannt und aus der Liste entfernt.");
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
            }
          }
        }

        # find original path in session filename list, root key: source
        # remove this filename list item
        if(isset($_SESSION[Ui::ui_file_list_key_root]) === true){
          $original_parent_directory = File_Handler::remove_trailing_slash_from_path(dirname($original_path));
          $original_filename = basename($original_path);
          $found_key = array_search($original_filename, $_SESSION[Ui::ui_file_list_key_root][$original_parent_directory]);
          if($found_key !== false){
            unset($_SESSION[Ui::ui_file_list_key_root][$original_parent_directory][$found_key]);
          }
        }
      }
    }
  }


  # replace filename data in session by path and replace it with filename data from input
  private static function replace_original_filename_data_from_session_data(array $filename_data, bool $is_failed_filename_data = false) : void {

    # if file with error was in session under file_list
    # remove file_list item
    # merge failed file data into file_data in session
    foreach($_SESSION[UI::ui_file_list_key_root] as $path_session => $filename_array_session){
      foreach($filename_array_session as $key_filename_session => $filename_session){
        foreach($filename_data[UI::ui_data_key_root] as $fe_input){
          $full_path = $path_session . File_Handler::path_seperator . $filename_session;
          if($full_path === $fe_input[UI::ui_key_path_source]){
            unset($_SESSION[UI::ui_file_list_key_root][$path_session][$key_filename_session]);
            $new_key = count($_SESSION[UI::ui_data_key_root]);
            $_SESSION[UI::ui_data_key_root][$new_key] = current($filename_data[UI::ui_data_key_root]);
            if($is_failed_filename_data === true){
              $_SESSION[UI::ui_data_key_root][$new_key][UI::ui_key_error_flag_for_filename_data] = true;
            }
          }
        }
      }
    }

    # if file with error was in session under file_data
    # replace this one instance in session under file_data
    foreach($_SESSION[UI::ui_data_key_root] as $k_session => $fe_session){
      foreach($filename_data[UI::ui_data_key_root] as $fe_input){
        if($fe_session[UI::ui_key_path_source] === $fe_input[UI::ui_key_path_source]){
          $_SESSION[UI::ui_data_key_root][$k_session] = $fe_input;
          if($is_failed_filename_data === true){
            $_SESSION[UI::ui_data_key_root][$k_session][UI::ui_key_error_flag_for_filename_data] = true;
          }
        }
      }
    }
  }


  # store source path option mode in session
  private static function store_source_path_and_source_options_in_session(array $ui_data) : void {

    if(isset($_SESSION[Ui::ui_path_source_root_key]) === false && isset($ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_key]) === true){
      $_SESSION[Ui::ui_path_source_root_key] = $ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_key];
    }

    if(isset($_SESSION[Ui::ui_path_source_root_recursive_key]) === false && isset($ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_recursive_key]) === true){
      $_SESSION[Ui::ui_path_source_root_recursive_key] = Ui::ui_path_source_root_recursive_value;
    }

    if(isset($_SESSION[Ui::ui_path_source_root_option_mode_key]) === false && isset($ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_option_mode_key]) === true){
      $_SESSION[Ui::ui_path_source_root_option_mode_key] = $ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_option_mode_key];
    }
  }


  private static function print_ui() : void {

    Ui::print_delete_session_button();

    # if no source existing in session data
    if(empty($_SESSION) === true){
      Ui::print_source_path_input();
    }

    # if source path option mode is search
    # print search input
    if($_SESSION[Ui::ui_path_source_root_option_mode_key] === Ui::ui_path_source_root_option_mode_value_search_source_dir_for_shema_files_by_shema_data){
      Ui::print_filename_shema_search_input();
      Ui::fill_input_shema_with_filename_data_list([Ui::ui_data_key_root => $_SESSION[Ui::ui_search_data_key_root]]);
    }

    # if data for files exists in session
    if(isset($_SESSION[Ui::ui_data_key_root]) === true && empty($_SESSION[Ui::ui_data_key_root]) === false){
      Ui::print_input_shema_for_filename_data_list_and_fill($_SESSION);
    }

    # if source existing in session data
    if(isset($_SESSION[Ui::ui_file_list_key_root]) === true && empty($_SESSION[Ui::ui_file_list_key_root]) === false){
      Ui::print_filename_shema_input_for_filename_list($_SESSION[Ui::ui_file_list_key_root]);
    }

    # print delete session button
    Ui::print_delete_session_button();
  }


}

?>