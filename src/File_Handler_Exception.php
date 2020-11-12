<?php

class File_Handler_Exception extends Exception implements I_Custom_Exception {

  public $message = "";

  public function __construct(string $message = null, bool $kill_process = true) {
    $this->message = $message;
    $this->print_error($message);
    if($kill_process === true){
      // exit();
    }
  }

  public function print_error(string $message) : void {
    Ui::out_error("\"".$message."\"");
  }
}

?>