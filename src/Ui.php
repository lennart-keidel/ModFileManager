<?php

abstract class Ui {

  public const ui_key_path_source = "path_source";

  public const ui_data_key_root = "files";

  public const ui_search_data_key_root = "search";

  # format-string to use with printf to print in ui
  private const input_shema_template_path_source_dir = '
    <input type="hidden" name="files[%1$d][path_source_dir]" value="%2$s">
  ';

  private const input_shema_template_original_filename = '
    <input type="hidden" name="files[%1$d][original_filename]" value="%2$s">
  ';

  private const template_error_message = "<javascript>alert(%s)</javascript>";

  private static $out_input_shema_index = 0;

  # print error message as js alert
  public static function out_error(string $message) : void {
    if(!empty($message)){
      printf(Ui::template_error_message, $message);
    }
  }






}

?>