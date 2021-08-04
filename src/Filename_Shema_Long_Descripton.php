<?php

abstract class Filename_Shema_Long_Description extends Compareable_Text_Optinal_Value_Operand implements I_Filename_Shema {

  public const array_ui_data_key = [
    self::class
  ];

  # max amount of character the discription can contain
  private const max_long_description_length = 48000;

  private const string_no_long_description_given = "I";

  # input shema template for ui
  private const input_shema_template = '
    <div class="container_label_and_input">
      <label for="'.self::class.'%1$d">Weitere Informationen</label>
      <textarea class="%3$s%1$d" id="'.self::class.'%1$d" name="%2$s[%1$d]['.self::class.']" maxlength="'.self::max_long_description_length.'" cols="40" rows="3"></textarea>
    </div>
  ';

  # input shema template for search ui
  private const search_input_shema_template = '
    <div class="container_label_and_input additional_input_root %3$s_root%1$d">
      <label for="'.self::class.'%1$d">Weitere Informationen (optional)</label>
      <select class="%3$s_operand%1$d %3$s%1$d" id="'.self::class.'%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]">
        %4$s
      </select>
      <textarea class="special_vertical_align %3$s%1$d" id="'.self::class.'%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" maxlength="'.self::max_long_description_length.'" cols="40" rows="1"></textarea>
      %5$s
    </div>
  ';

  # format-string to use with printf to print in ui
  private const string_ui_format = "<span>%s</span>";

  # convert data collected from ui to usable data for following process
  public static function convert_ui_data_to_data(array $data_from_ui) : array {
    # filter data for this schema from whole ui data
    $key = current(self::array_ui_data_key);

    if(!isset($data_from_ui[$key])){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nFehlender Schlüssel in POST-Request: '$key'");
    }

    return [
      $data_from_ui[$key]
    ];
  }

  # convert data to filename part using this shema
  public static function convert_data_to_filename(array $data_converted) : string {
    $string_long_description = current($data_converted);

    if(strlen($string_long_description) > self::max_long_description_length){
      throw new Shema_Exception("Fehler beim Einlesen der Daten. Die eingegebene Beschreibung ist länger als die maximal erlaubten ".self::max_long_description_length." Zeichen.");
    }

    # if long_description input is empty
    # return short id of selected option
    if(empty($string_long_description) === false){
      return Url_Shortener_API_Handler::short_text($string_long_description);
    }

    # if long_description input is not empty
    # return string for empty long_description
    else {
      return self::string_no_long_description_given;
    }
  }


  # reverse process: converting filename back to data
  public static function convert_filename_to_data(string $filename_part) : array {

    $expanded_text = "";
    if($filename_part !== self::string_no_long_description_given){
      $expanded_text = Url_Shortener_API_Handler::expand_text($filename_part);
    }

    # return array in format of original ui data
    return [ current(self::array_ui_data_key) => $expanded_text ];
  }


  # print converted data from filename to ui
  public static function print_filename_data_for_ui(array $filename_data) : void {
    # print data from filename to ui by formated string
    printf(self::string_ui_format, current($filename_data));
  }


  # print filename shema input to ui
  public static function print_filename_shema_input_for_ui(int $index) : void {
    printf(self::input_shema_template, $index, Ui::ui_data_key_root, self::class);
  }


  # print filename shema search input to ui
  public static function print_filename_shema_search_input_for_ui(int $index) : void {
    $operand_select_option_html = Ui::generate_search_operand_select_options_ui(self::class);
    $additional_search_buttons = Ui::generate_additional_search_buttons_ui(self::class);
    printf(self::search_input_shema_template, $index, Ui::ui_search_data_key_root, self::class, $operand_select_option_html, $additional_search_buttons);
  }


  # get target path considering the conditions of this shema input
  public static function get_target_path_by_condition(array $data_for_one_filename, string $source_path) : array {
    $path_result = "";
    $success_heading = "";
    $error_heading = "";
    return [$path_result, $success_heading, $error_heading];
  }

}

?>