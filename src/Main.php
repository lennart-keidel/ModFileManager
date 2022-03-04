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
      self::create_session();

      # if delete session button pushed
      # delete session
      self::execute_delete_session_button($ui_data);

      # if source path uploaded
      # store source path in cookie
      self::store_source_path_in_cookie($ui_data);

      self::store_fast_edit_input_in_session($ui_data);

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

      # handle uploaded data for duplicate file check
      self::handle_uploaded_duplicate_file_check_input($ui_data);

      // var_dump($ui_data);

    }
    catch(Exception $e){
    }

    # print ui
    self::print_ui();

    // var_dump($_SESSION);
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


  # if search input uploaded
  # store search input in session
  private static function store_search_input_in_session(array $ui_data) : void {
    if(isset($ui_data[Ui::ui_search_data_key_root]) === true){
      $_SESSION[Ui::ui_search_data_key_root] = $ui_data[Ui::ui_search_data_key_root];
    }
  }


  # if fast edit input uploaded
  # store fast edit data in session
  private static function store_fast_edit_input_in_session(array $ui_data) : void {
    if(isset($ui_data[Ui::ui_fast_edit_data_key_root]) === true){
      $_SESSION[Ui::ui_fast_edit_data_key_root] = $ui_data[Ui::ui_fast_edit_data_key_root];
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
            if(empty($filename_data) === true){
              continue;
            }
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
        self::replace_original_filename_data_from_session_data($failed_filename_data, true);
        return;
      }

      self::remove_original_filename_from_session_data($new_filename_list);

      # print heading with success message
      Ui::print_success_heading("Die Datei wurde erfolgreich umbenannt und aus der Liste entfernt.");
    }
  }


  private static function handle_uploaded_duplicate_file_check_input(array $ui_data) : void {
    if(isset($ui_data[Ui::ui_key_duplicate_file_check]) === true){
      # transform input into array
      $duplicate_files_path_list = self::transform_duplicate_file_check_input_path_into_array($ui_data[Ui::ui_key_duplicate_file_check]);

      # read files from paths
      $ret = [];
      foreach($duplicate_files_path_list as $path_source_duplicate_list){
        $ret = array_merge($ret,File_Handler::get_filename_list_from_path_recursive($path_source_duplicate_list));
      }
      var_dump($ret);
    }
  }


  private static function transform_duplicate_file_check_input_path_into_array(string $duplicate_file_check_input) : array {
    return array_filter(explode("\n",$duplicate_file_check_input), function($item){
      return empty(trim($item)) === false;
    });
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
            if($_SESSION[UI::ui_data_key_root] === true){
              $new_key = count($_SESSION[UI::ui_data_key_root]);
              $_SESSION[UI::ui_data_key_root][$new_key] = current($filename_data[UI::ui_data_key_root]);
            }
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

    if(isset($ui_data[Ui::ui_key_auto_move_file]) === true){
      $_SESSION[Ui::ui_key_auto_move_file] = $ui_data[Ui::ui_key_auto_move_file];
    }
  }



  private static function print_ui() : void {


    # if no source existing in session data
    if(empty($_SESSION) === true){
      Ui::print_start_page_heading();
      Ui::print_source_path_input();

      # pull recent data from git on printing start page
      Git_Auto_Pull_Push::pull();
    }

    # if not start page
    # print delete session button
    else {
      Ui::print_delete_session_button();
    }

    # if source path option mode is search
    # print search input
    if($_SESSION[Ui::ui_path_source_root_option_mode_key] === Ui::ui_path_source_root_option_mode_value_search_source_dir_for_shema_files_by_shema_data){
      Ui::print_filename_shema_search_input();
      Ui::fill_search_input_shema_with_filename_data_list([Ui::ui_data_key_root => $_SESSION[Ui::ui_search_data_key_root]]);
    }


    # print fast edit input form
    if(empty($_SESSION) === false){
      Ui::print_filename_shema_fast_edit_input_and_fill($_SESSION);
    }

    # if data for files exists in session
    if(isset($_SESSION[Ui::ui_data_key_root]) === true && empty($_SESSION[Ui::ui_data_key_root]) === false){
      Ui::print_input_shema_for_filename_data_list_and_fill($_SESSION);
    }

    # if source existing in session data
    if(isset($_SESSION[Ui::ui_file_list_key_root]) === true && empty($_SESSION[Ui::ui_file_list_key_root]) === false){
      Ui::print_filename_shema_input_for_filename_list($_SESSION[Ui::ui_file_list_key_root]);
    }

    # if auto move file is enabled
    # print js for the right select value to all file inputs
    if(isset($_SESSION[Ui::ui_key_auto_move_file]) === true && empty($_SESSION[Ui::ui_key_auto_move_file]) === false){
      Ui::print_set_data_in_element_by_class(Ui::ui_key_auto_move_file, $_SESSION[Ui::ui_key_auto_move_file]);
    }

    # if not start page
    # print delete session button
    if(empty($_SESSION) === false){
      self::store_blacklist_entries_in_session();
      Ui::print_delete_session_button();
    }

    # if start page
    # print open blacklist site button, to navigate to the mod-blacklist page
    else {
      Ui::print_duplicate_file_check_input();
      Ui::print_open_blacklist_site_button();
    }
  }


  # store blacklist entries in session data
  private static function store_blacklist_entries_in_session() : void {
    $_SESSION[Ui::ui_blacklist_entries_session_key] = Blacklist::get_all_blacklist_entries();
  }


}

?>