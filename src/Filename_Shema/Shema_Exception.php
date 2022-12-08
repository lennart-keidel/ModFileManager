<?php

class Shema_Exception extends Custom_Exception {

  # print error to ui
  public function print_error(string $message) : void {
    Ui::print_error(self::edit_error_message($message), self::class);
  }

}

?>