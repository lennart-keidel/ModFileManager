<?php

abstract class Filename_Shema_Description extends Compareable_Text_Operand implements I_Filename_Shema {

  public const array_ui_data_key = [
    self::class
  ];

  # max amount of character the discription can contain
  private const max_description_length = 70;

  # input shema template for ui
  private const input_shema_template = '
    <div class="container_label_and_input">
      <label for="'.self::class.'%1$d">Beschreibung
        <span class="sub">max. '.self::max_description_length.' Zeichen; Sonderzeichen werden ersetzt</span>
      </label>
      <input class="%3$s%1$d" id="'.self::class.'%1$d" type="text" name="%2$s[%1$d]['.self::class.']" required>
    </div>
  ';

  # input shema template for search ui
  private const search_input_shema_template = '
    <div class="container_label_and_input additional_input_root %3$s_root%1$d">
      <label for="'.self::class.'%1$d">Beschreibung
        <span class="sub">max. '.self::max_description_length.' Zeichen; Sonderzeichen werden ersetzt</span>
      </label>
      <select class="%3$s_operand%1$d %3$s%1$d" id="%3$s_operand%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]">
        %4$s
      </select>
      <input class="%3$s%1$d" id="'.self::class.'%1$d" type="text" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" required>
      %5$s
    </div>
  ';

  # format-string to use with printf to print in ui
  private const string_ui_format = "<span>%s</span>";

  # array with regex patterns
  # key: search regex
  # value: replace with
  private const array_replace_regex_data_to_filename = [
    "[^A-Za-z0-9_]" => "_",
    "[ü]" => "ue",
    "[Ü]" => "Ue",
    "[ö]" => "oe",
    "[Ö]" => "Oe",
    "[ä]" => "ae",
    "[Ä]" => "Ae",
    "[ß]" => "ss",
    "_{2,}" => "_",
    "_$" => ""
  ];


  # array with regex patterns
  # key: search regex
  # value: replace with
  private const array_replace_regex_filename_to_data = [
    "[_]" => " "
  ];


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
    $string_description = current($data_converted);

    if(!strlen($string_description) || !preg_match("/[a-zA-Z0-9]/",$string_description)){
      throw new Shema_Exception("Fehler beim Einlesen der Daten. Die Mod-Beschreibung enthält keine validen Zeichen.");
    }

    if(strlen($string_description) > self::max_description_length){
      throw new Shema_Exception("Fehler beim Einlesen der Daten. Die eingegebene Beschreibung ist länger als die maximal erlaubten ".self::max_description_length." Zeichen.");
    }

    # replace stuff in description string
    foreach(self::array_replace_regex_data_to_filename as $regex_search => $replace){
      $string_description = preg_replace("/$regex_search/",$replace, $string_description);
    }

    # return short id of selected option
    return $string_description;
  }


  # reverse process: converting filename back to data
  public static function convert_filename_to_data(string $filename_part) : array {

    if(!strlen($filename_part) || !preg_match("/[a-zA-Z0-9]/",$filename_part)){
      throw new Shema_Exception("Fehler beim Einlesen der Datei. Mod-Beschreibung ist ein String ohne valide Zeichen.");
    }

    # replace stuff in description string from file
    foreach(self::array_replace_regex_filename_to_data as $regex_search => $replace){
      $filename_part = preg_replace("/$regex_search/",$replace, $filename_part);
    }

    # return array in format of original ui data
    return [ current(self::array_ui_data_key) => $filename_part ];
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