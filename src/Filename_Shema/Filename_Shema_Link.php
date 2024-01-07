<?php

abstract class Filename_Shema_Link extends Compareable_Text_Operand implements I_Filename_Shema {

  public const array_ui_data_key = [
    self::class
  ];

  # max amount of character the short url can contain
  private const max_short_url_length = 10;

  # format-string to use with printf to print in ui
  private const string_ui_format = "<span>%s</span>";

  # input shema template for ui
  private const input_shema_template = '
    <div class="container_label_and_input">
      <label for="'.self::class.'%1$d">Link zum Mod, CC</label>
      <input class="%3$s%1$d" id="'.self::class.'%1$d" type="url" name="%2$s[%1$d]['.self::class.']" autocomplete="off" %4$s>
    </div>
  ';

  # input shema template for search ui
  private const search_input_shema_template = '
    <div class="container_label_and_input additional_input_root %3$s_root%1$d">
      <label for="%3$s%1$d">Link zum Mod, CC</label>
      <select class="%3$s_operand%1$d %3$s%1$d" id="%3$s_operand%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]">
        %4$s
      </select>
      <input class="%3$s_value%1$d %3$s%1$d" id="'.self::class.'%1$d" type="text" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" autocomplete="off">
      %5$s
    </div>
  ';

  # convert data collected from ui to usable data for following process
  public static function convert_ui_data_to_data(array $data_from_ui) : array {
    # filter data for this schema from whole ui data
    $key = current(self::array_ui_data_key);

    if(!isset($data_from_ui[$key])){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nFehlender Schlüssel in POST-Request: '$key'");
    }

    if(empty($data_from_ui[$key]) === true){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer eingegebene Link ist leer.");
    }

    return [
      $data_from_ui[$key]
    ];
  }


  # convert data to filename part using this shema
  public static function convert_data_to_filename(array $data_converted) : string {

    $url = current($data_converted);

    # error if website not returning valid http-response-code
    // if(!Url_Shortener_API_Handler::test_if_url_is_valid($url)){
    //   throw new Shema_Exception("Fehler beim Einlesen der Daten. Der eingegebene Link ist nicht gültig.\\nHTTP-Response-Code: ".Url_Shortener_API_Handler::get_http_response_code($url).".\\nLink: '".$url."'");
    // }

    # error if link is on blacklist
    if(isset($_SESSION[Ui::ui_blacklist_entries_session_key]) === true){
      foreach($_SESSION[Ui::ui_blacklist_entries_session_key] as $entry){
        if($entry[Blacklist::json_key_link] === $url){
          throw new Shema_Exception("Der Link für diesen Mod befindet sich auf der Blacklist.\\nBegründung: ".$entry[Blacklist::json_key_description]);
        }
      }
    }


    # create short-url-id of url
    $short_url_id = Url_Shortener_API_Handler::short_url($url);

    return $short_url_id;
  }


  # reverse process: converting filename back to data
  public static function convert_filename_to_data(string $filename_part) : array {

    # get original url from short url id
    $original_url = Url_Shortener_API_Handler::expand_url($filename_part);

    # return array in format of original ui data
    return [ current(self::array_ui_data_key) => $original_url ];
  }


  # print converted data from filename to ui
  public static function print_filename_data_for_ui(array $filename_data) : void {
    # print data from filename to ui by formated string
    printf(self::string_ui_format, current($filename_data));
  }


  # print filename shema input to ui
  public static function print_filename_shema_input_for_ui(int $index, string $different_ui_key_root = null, bool $is_required = true) : void {
    printf(self::input_shema_template, $index, ($different_ui_key_root === null ? Ui::ui_data_key_root : $different_ui_key_root), self::class, ($is_required === true ? "required" : ""));
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