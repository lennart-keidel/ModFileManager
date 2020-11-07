<?php

class Shema_Exception extends Exception {

  public function __construct(string $message = null, bool $kill_process = true) {
    $this->message = $message;
    $this->print_error($message);
    if($kill_process === true){
      // exit();
    }
  }

  public function print_error(string $message) : void {
    Ui::set_error("\"".$message."\"");
  }
}

?>