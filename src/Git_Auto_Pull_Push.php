<?php

abstract class Git_Auto_Pull_Push {

  public static function pull(){
    $output = [];
    $base_path = dirname(__FILE__);
    shell_exec("powershell -commmand \"cd $base_path; git pull $(git remote get-url --push origin)\"");
  }

  public static function push(){
    $output = [];
    $base_path = dirname(__FILE__);
    shell_exec("powershell -command \"cd $base_path; git add \\\"$(git rev-parse --show-toplevel)/src/blacklist/mod_blacklist.json\\\"; git commit -m 'auto update mod-blacklist-file'; git push $(git remote get-url --push origin)\"");
  }

}

?>