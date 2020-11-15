<?php

abstract class Filename_Shema_Description implements I_Filename_Shema {

  public const array_ui_data_key = [
    "text_shema_description"
  ];

  # max amount of character the discription can contain
  private const max_description_length = 75;

  # format-string to use with printf to print in ui
  private const string_ui_format = "<span>%s</span>";

  # array with regex patterns
  # key: search regex
  # value: replace with
  private const array_replace_regex_data_to_filename = [
    "[^A-Za-z0-9_]" => "_",
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
    $key = current(Filename_Shema_Description::array_ui_data_key);

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

    # error if length of string is over the max description character length
    if(strlen($string_description) > Filename_Shema_Description::max_description_length){
      throw new Shema_Exception("Fehler beim Einlesen der Daten. Die eingegebene Beschreibung ist länger als die maximal erlaubten ".Filename_Shema_Description::max_description_length." Zeichen.");
    }

    # replace stuff in description string
    foreach(Filename_Shema_Description::array_replace_regex_data_to_filename as $regex_search => $replace){
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
    foreach(Filename_Shema_Description::array_replace_regex_filename_to_data as $regex_search => $replace){
      $filename_part = preg_replace("/$regex_search/",$replace, $filename_part);
    }

    # return array in format of original ui data
    return [ current(Filename_Shema_Description::array_ui_data_key) => $filename_part ];
  }


  # print converted data from filename to ui
  public static function print_filename_data_for_ui(array $filename_data) : void {
    # print data from filename to ui by formated string
    printf(Filename_Shema_Description::string_ui_format, current($filename_data));
  }

}

?>