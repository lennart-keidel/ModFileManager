<?php

class Shema_Exception extends Exception {

  public function __construct(string $message = null) {
    $this->message = $message;
    $this->print_error($message);
  }

  public function print_error(string $message) : void {
    Ui::set_error($message);
  }
}

?>