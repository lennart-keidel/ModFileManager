<?php

abstract class Filename_Shema_Link implements I_Filename_Shema {

  public const array_ui_data_key = [
    "url_shema_link"
  ];

  # max amount of character the short url can contain
  private const max_short_url_length = 10;

  # format-string to use with printf to print in ui
  private const string_ui_format = "<span>%s</span>";

  # input shema template for ui
  private const input_shema_template = '
    <div class="container_label_and_input">
      <label for="url_shema_link%1$d">Link zum Mod, CC</label>
      <input class="%3$s%1$d" id="url_shema_link%1$d" type="url" name="%2$s[%1$d][url_shema_link]" required>
    </div>
  ';

  # convert data collected from ui to usable data for following process
  public static function convert_ui_data_to_data(array $data_from_ui) : array {
    # filter data for this schema from whole ui data
    $key = current(Filename_Shema_Link::array_ui_data_key);

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
    if(!Url_Shortener_API_Handler::test_if_url_is_valid($url)){
      throw new Shema_Exception("Fehler beim Einlesen der Daten. Der eingegebene Link ist nicht gültig.\\nHTTP-Response-Code: ".Url_Shortener_API_Handler::get_http_response_code($url).".\\nLink: '".$url."'");
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
    return [ current(Filename_Shema_Link::array_ui_data_key) => $original_url ];
  }


  # print converted data from filename to ui
  public static function print_filename_data_for_ui(array $filename_data) : void {
    # print data from filename to ui by formated string
    printf(Filename_Shema_Link::string_ui_format, current($filename_data));
  }


  # print filename shema input to ui
  public static function print_filename_shema_input_for_ui(int $index) : void {
    printf(self::input_shema_template, $index, Ui::ui_data_key_root, Filename_Shema_Link::class);
  }


  # print filename shema search input to ui
  public static function print_filename_shema_search_input_for_ui(int $index) : void {
    printf(self::input_shema_template, $index, Ui::ui_search_data_key_root, Filename_Shema_Link::class);
  }

}

?>