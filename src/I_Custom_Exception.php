<?php

interface I_Custom_Exception {

  # print error to ui
  public function print_error(string $error_message) : void;

  public static function set_source_path_array(array $path_array) : void;

  public static function set_source_path(string $path) : void;

  public static function get_source_path_array() : array;

}

?>