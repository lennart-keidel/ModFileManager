<?php

class Custom_Exception extends Exception implements I_Custom_Exception {

  public $message = "";
  private static $path_array = [];


  public function __construct(string $message = "", bool $kill_process = false) {
    $this->message = $message;
    $this->print_error($this->message);
    if($kill_process === true){
      // exit();
    }
  }

  private static function edit_source_path(string $path) : string {
    return str_replace("\\", "\\\\", $path);
  }

  public static function set_source_path_array(array $path_array) : void {
    array_walk($path_array, function(&$path, $key){
      $path = self::edit_source_path($path);
    });
    self::$path_array = $path_array;
  }

  public static function set_source_path(string $path) : void {
    self::$path_array[] = self::edit_source_path($path);
  }


  public static function get_source_path_array() : array {
    return self::$path_array;
  }


  # prepapre error message
  protected function edit_error_message(string $message) : string {
    if(empty($message)){
      $message = $this->$message;
    }
    if(empty(self::$path_array) === false){
      foreach (self::$path_array as $array_key => $path) {
        $message .= "\\nPfad".(count(self::$path_array) > 1 ? " #".++$array_key : "").": ".$path;
      }
    }
    return $message;
  }


  # print error to ui
  public function print_error(string $message) : void {
    Ui::print_error(self::edit_error_message($message), self::class);
  }
}

?>