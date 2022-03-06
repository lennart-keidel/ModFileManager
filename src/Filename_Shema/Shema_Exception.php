<?php

class Shema_Exception extends Custom_Exception {

  # print error to ui
  public function print_error(string $message) : void {
    self::edit_error_message($message);
    Ui::print_error($message, self::class);
  }

}

?>