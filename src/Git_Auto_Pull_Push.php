<?php

abstract class Git_Auto_Pull_Push {

  public static function pull(){
    $output = [];
    $base_path = dirname(__FILE__);
    shell_exec("powershell -commmand \"cd $base_path; git pull $(git remote get-url --push origin)\"");
  }

  public static function push(){
    self::push_blacklist_file();
    self::push_duplicate_file_check_input_paths_file();
  }

  public static function push_blacklist_file(){
    $output = [];
    $base_path = dirname(__FILE__);
    shell_exec("powershell -command \"cd $base_path; git add \\\"$(git rev-parse --show-toplevel)/src/blacklist/mod_blacklist.json\\\"; git commit -m 'auto update mod-blacklist-file'; git push $(git remote get-url --push origin)\"");
  }

  public static function push_duplicate_file_check_input_paths_file(){
    $output = [];
    $base_path = dirname(__FILE__);
    shell_exec("powershell -command \"cd $base_path; git add \\\"$(git rev-parse --show-toplevel)/src/Duplicate_File_Check/duplicate_file_check_path_entrys.txt\\\"; git commit -m 'auto update duplicate-file-check-path-entrys-file'; git push $(git remote get-url --push origin)\"");
  }

}

?>