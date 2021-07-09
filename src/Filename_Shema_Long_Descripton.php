<?php

abstract class Filename_Shema_Long_Description extends Compareable_Text_Operand implements I_Filename_Shema {

  public const array_ui_data_key = [
    self::class
  ];

  # max amount of character the discription can contain
  private const max_long_description_length = 48000;

  private const string_no_long_description_given = "I";

  # input shema template for ui
  private const input_shema_template = '
    <div class="container_label_and_input">
      <label for="Filename_Shema_Long_Description%1$d">Weitere Informationen</label>
      <textarea class="%3$s%1$d" id="Filename_Shema_Long_Description%1$d" name="%2$s[%1$d][Filename_Shema_Long_Description]" maxlength="'.self::max_long_description_length.'" cols="40" rows="3"></textarea>
    </div>
  ';

  # format-string to use with printf to print in ui
  private const string_ui_format = "<span>%s</span>";

  # convert data collected from ui to usable data for following process
  public static function convert_ui_data_to_data(array $data_from_ui) : array {
    # filter data for this schema from whole ui data
    $key = current(Filename_Shema_Long_Description::array_ui_data_key);

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

    if(strlen($string_long_description) > Filename_Shema_Long_Description::max_long_description_length){
      throw new Shema_Exception("Fehler beim Einlesen der Daten. Die eingegebene Beschreibung ist länger als die maximal erlaubten ".Filename_Shema_Long_Description::max_long_description_length." Zeichen.");
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
    return [ current(Filename_Shema_Long_Description::array_ui_data_key) => $expanded_text ];
  }


  # print converted data from filename to ui
  public static function print_filename_data_for_ui(array $filename_data) : void {
    # print data from filename to ui by formated string
    printf(Filename_Shema_Long_Description::string_ui_format, current($filename_data));
  }


  # print filename shema input to ui
  public static function print_filename_shema_input_for_ui(int $index) : void {
    printf(self::input_shema_template, $index, Ui::ui_data_key_root, Filename_Shema_Long_Description::class);
  }


  # print filename shema search input to ui
  public static function print_filename_shema_search_input_for_ui(int $index) : void {
    printf(self::input_shema_template, $index, Ui::ui_search_data_key_root, Filename_Shema_Long_Description::class);
  }

}

?>