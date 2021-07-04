<?php

abstract class Filename_Shema_Creator implements I_Filename_Shema {

  public const array_ui_data_key = [
    "text_shema_creator"
  ];

  # max amount of character the discription can contain
  private const max_creator_length = 48000;

  private const string_no_creator_given = "I";

  # input shema template for ui
  private const input_shema_template = '
    <div class="container_label_and_input">
      <label for="text_shema_creator%1$d">Name des Erstellers</label>
      <input class="%3$s%1$d" id="text_shema_creator%1$d" type="text" name="%2$s[%1$d][text_shema_creator]" maxlength="'.self::max_creator_length.'">
    </div>
  ';

  # input shema template for ui
  private const search_input_shema_template = '
    <div class="container_label_and_input additional_input_root">
      <label for="text_shema_creator%1$d">Name des Erstellers</label>
      <select class="%3$s_operand%1$d %3$s%1$d" id="text_shema_creator%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.'][text_shema_creator][]" maxlength="'.self::max_creator_length.'">
        <option value="contains">enthält</option>
        <option value="contains_not">enthält nicht</option>
        <option value="is">ist</option>
        <option value="is_not">ist nicht</option>
        <option value="starts_with">startet mit</option>
        <option value="ends_with">endet mit</option>
      </select>
      <input class="%3$s_value%1$d %3$s%1$d" id="text_shema_creator%1$d" type="text" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.'][text_shema_creator][]" maxlength="'.self::max_creator_length.'">
      <button type="button" class="%3$s%1$d search_plus_button" onclick="add_search_input_with_plus_button($(this))">+</button>
      <button type="button" class="%3$s%1$d search_minus_button" onclick="remove_search_input_with_minus_button($(this))">-</button>
    </div>
  ';

  # format-string to use with printf to print in ui
  private const string_ui_format = "<span>%s</span>";

  # convert data collected from ui to usable data for following process
  public static function convert_ui_data_to_data(array $data_from_ui) : array {
    # filter data for this schema from whole ui data
    $key = current(Filename_Shema_Creator::array_ui_data_key);

    if(!isset($data_from_ui[$key])){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nFehlender Schlüssel in POST-Request: '$key'");
    }

    return [
      $data_from_ui[$key]
    ];
  }


  # convert data to filename part using this shema
  public static function convert_data_to_filename(array $data_converted) : string {
    $string_creator = current($data_converted);

    if(strlen($string_creator) > Filename_Shema_Creator::max_creator_length){
      throw new Shema_Exception("Fehler beim Einlesen der Daten. Die eingegebene Beschreibung ist länger als die maximal erlaubten ".Filename_Shema_Creator::max_creator_length." Zeichen.");
    }

    # if creator input is empty
    # return short id of selected option
    if(empty($string_creator) === false){
      return Url_Shortener_API_Handler::short_text($string_creator);
    }

    # if creator input is not empty
    # return string for empty creator
    else {
      return self::string_no_creator_given;
    }
  }


  # reverse process: converting filename back to data
  public static function convert_filename_to_data(string $filename_part) : array {

    $expanded_text = "";
    if($filename_part !== self::string_no_creator_given){
      $expanded_text = Url_Shortener_API_Handler::expand_text($filename_part);
    }

    # return array in format of original ui data
    return [ current(Filename_Shema_Creator::array_ui_data_key) => $expanded_text ];
  }


  # print converted data from filename to ui
  public static function print_filename_data_for_ui(array $filename_data) : void {
    # print data from filename to ui by formated string
    printf(Filename_Shema_Creator::string_ui_format, current($filename_data));
  }


  # print filename shema input to ui
  public static function print_filename_shema_input_for_ui(int $index) : void {
    printf(self::input_shema_template, $index, Ui::ui_data_key_root, Filename_Shema_Creator::class);
  }


  # print filename shema search input to ui
  public static function print_filename_shema_search_input_for_ui(int $index) : void {
    printf(self::search_input_shema_template, $index, Ui::ui_search_data_key_root, Filename_Shema_Creator::class);
  }

  public static function compare(string $search_input, string $compare_to, string $operand) : bool {
    return $search_input === $compare_to;
  }

}

?>