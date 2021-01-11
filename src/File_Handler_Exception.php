<?php

class File_Handler_Exception extends Exception implements I_Custom_Exception {

  public $message = "";
  private static $path = "";


  public function __construct(string $message = "", bool $kill_process = false) {
    $this->message = $message;
    $this->print_error($this->message);
    if($kill_process === true){
      // exit();
    }
  }


  public static function set_source_path(string $path) : void {
    self::$path = str_replace("\\", "\\\\", $path);
  }


  public static function get_source_path() : string {
    return self::$path;
  }


  public static function append_source_path(string $paht_to_append) : void {
    self::$path = File_Handler::remove_trailing_slash_from_path(self::$path).File_Handler::path_seperator.$paht_to_append;
  }


  # print error to ui
  public function print_error(string $message) : void {
    if(empty($message)){
      $message = $this->$message;
    }
    if(empty(self::$path) === false){
      $message = "$message\\nPfad: ".self::$path;
    }
    Ui::print_error("\"".$message."\"", self::class);
  }
}

?>