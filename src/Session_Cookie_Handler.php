<?php

abstract class Session_Cookie_Handler {


  # start session
  # if session data not valid, delete session data
  public static function create_session() : void {

    # start session
    # session is active for one day
    session_start([
      'cookie_lifetime' => 86400,
    ]);

    # if session not valid
    # reset session array
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


  # test if session is valid
  public static function is_session_valid() : bool {
    return session_status() === PHP_SESSION_ACTIVE && empty($_SESSION) === false;
  }


  # test if session contains keys required for not beeing on start page mode
  public static function is_session_startpage() : bool {
    return
      isset($_SESSION[Ui::ui_path_source_root_key]) === false &&
      isset($_SESSION[Ui::ui_path_source_root_option_mode_key]) === false &&
      isset($_SESSION[Ui::ui_file_list_key_root]) === false &&
      isset($_SESSION[Ui::ui_search_data_key_root]) === false &&
      isset($_SESSION[Ui::ui_data_key_root]) === false;
  }


  # remove all session data
  public static function delete_session_data() : void {
    echo "<script>console.log('Sessiondaten gelöscht.')</script>";
    $_SESSION = [];
  }


  # if source path uploaded
  # store source path in cookie
  public static function store_source_path_in_cookie(array $ui_data) : void {

    # if source path key exists in ui data
    # set expire date: now + 1 month
    if(isset($ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_key]) === true){
      self::set_cookie(Ui::ui_path_source_root_key, $ui_data[Ui::ui_source_input_key_root][Ui::ui_path_source_root_key]);
    }
  }


  # if source path uploaded
  # store source path and input options in session
  public static function store_source_input_path_and_input_options_in_session(array $ui_data) : void {

    # if source key exists in ui data
    if(isset($ui_data[Ui::ui_source_input_key_root]) === true){
      $_SESSION[Ui::ui_source_input_key_root] = $ui_data[Ui::ui_source_input_key_root];
    }
  }


  # if duplicate file check input uploaded
  # store the string in cookie
  public static function store_duplicate_file_check_input_in_cookie(array $ui_data) : void {

    # if source path key exists in ui data
    # set expire date: now + 1 month
    if(isset($ui_data[Ui::ui_key_duplicate_file_check_root_key][Ui::ui_key_duplicate_file_check_file_list_input]) === true){
      self::set_cookie(Ui::ui_key_duplicate_file_check_file_list_input, $ui_data[Ui::ui_key_duplicate_file_check_root_key][Ui::ui_key_duplicate_file_check_file_list_input]);
    }
    self::set_cookie(Ui::ui_key_duplicate_file_check_search_recursive, isset($ui_data[Ui::ui_key_duplicate_file_check_root_key][Ui::ui_key_duplicate_file_check_search_recursive]) === true);
  }


  # set cookie with high expiration date
  private static function set_cookie(string $key, $value){
    $expire_date = new DateTime();
    $expire_date->add(new DateInterval("P8M"));
    setcookie($key, $value, $expire_date->getTimestamp(), "/");
  }


  # if search input uploaded
  # store search input in session
  public static function store_search_input_in_session(array $ui_data) : void {
    if(isset($ui_data[Ui::ui_search_data_key_root]) === true){
      $_SESSION[Ui::ui_search_data_key_root] = $ui_data[Ui::ui_search_data_key_root];
    }
  }


  # if fast edit input uploaded
  # store fast edit data in session
  public static function store_fast_edit_input_in_session(array $ui_data) : void {
    if(isset($ui_data[Ui::ui_fast_edit_data_key_root]) === true){
      $_SESSION[Ui::ui_fast_edit_data_key_root] = $ui_data[Ui::ui_fast_edit_data_key_root];
    }
  }


  # if source path option mode is "replace filename by shema"
  # try to get data from filename from session filename list
  # if successfull save filename data in session and delete filename from filename list in session
  public static function store_filename_data_from_filename_list_in_session(array $ui_data) : void {
    if(isset($ui_data[Ui::ui_source_input_key_root]) === true && $_SESSION[Ui::ui_path_source_root_option_mode_key] === Ui::ui_path_source_root_option_mode_value_rename_files_by_shema && isset($_SESSION[Ui::ui_file_list_key_root]) === true) {
      $filename_data_list = Create_Read_Filename_By_Shema::read_filename_data_from_filename_list($_SESSION[Ui::ui_file_list_key_root]);

      if(empty($filename_data_list) === false){
        $_SESSION[Ui::ui_data_key_root] = $filename_data_list;
      }
    }
  }


  # if source path option mode is replace filename by shema
  # store filename list from source path in session
  public static function store_filename_list_from_source_path_in_session(array $ui_data) : void {
    if(isset($ui_data[Ui::ui_source_input_key_root]) === true && $_SESSION[Ui::ui_path_source_root_option_mode_key] === Ui::ui_path_source_root_option_mode_value_rename_files_by_shema) {
      $filename_list = Main::get_filename_list_from_source_path();

      if(empty($filename_list) === false){
        $_SESSION[Ui::ui_file_list_key_root] = $filename_list;
      }
    }
  }


  public static function remove_original_filename_from_session_data(array $filename_list) : void {

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
          $found_key = array_search($original_filename, $_SESSION[Ui::ui_file_list_key_root][$original_parent_directory]);
          if($found_key !== false){
            unset($_SESSION[Ui::ui_file_list_key_root][$original_parent_directory][$found_key]);
          }
        }
      }
    }
  }


  # replace filename data in session by path and replace it with filename data from input
  public static function replace_original_filename_data_from_session_data(array $filename_data, bool $is_failed_filename_data = false) : void {

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
  public static function store_source_path_and_source_options_in_session(array $ui_data) : void {

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


  # store blacklist entries in session data
  public static function store_blacklist_entries_in_session() : void {
    $_SESSION[Ui::ui_blacklist_entries_session_key] = Blacklist::get_all_blacklist_entries();
  }

}

?>