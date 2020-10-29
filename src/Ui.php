<?php

class Ui {

  # format-string to use with printf to print in ui
  private const string_ui_format_error = "<javascript>alert(%s)</javascript>";

  # print error message as js alert
  public static function set_error(string $message) : void {
    if(!empty($message)){
      printf(Ui::string_ui_format_error, $message);
    }
  }

}

?>