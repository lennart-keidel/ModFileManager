<?php

abstract class Filename_Shema_Patch_Level implements I_Filename_Shema {

  public const array_ui_data_key = [
    "select_shema_patch_level"
  ];

  # format-string to use with printf to print in ui
  private const string_ui_format = "<span>%s</span>";

  public const array_valid_patch_level = [
    "1.70",
    "1.69",
    "1.67",
    "1.66",
    "1.63",
    "1.57",
    "1.55",
    "1.50",
    "1.48",
    "1.47",
    "1.42",
    "1.39",
    "1.38",
    "1.36",
    "1.34",
    "1.33",
    "1.32",
    "1.31",
    "1.29",
    "1.27",
    "1.26",
    "1.25",
    "1.24",
    "1.22",
    "1.19",
    "1.18",
    "1.17",
    "1.15",
    "1.14",
    "1.12",
    "1.11",
    "1.10",
    "1.09",
    "1.08",
    "1.07",
    "1.06",
    "1.05",
    "1.04",
    "1.03",
    "1.02",
    "1.01",
    "1.00"
  ];


  # convert data collected from ui to usable data for following process
  public static function convert_ui_data_to_data(array $data_from_ui) : array {
    # filter data for this schema from whole ui data
    $key = current(Filename_Shema_Patch_Level::array_ui_data_key);

    if(!isset($data_from_ui[$key])){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nFehlender Schlüssel in POST-Request: '$key'");
    }

    return [
      $data_from_ui[$key]
    ];
  }


  # convert data to filename part using this shema
  public static function convert_data_to_filename(array $data_converted) : string {

    $patch_level = current($data_converted);

    # error if patch level not matching patch level
    if(in_array($patch_level, self::array_valid_patch_level) === false){
      throw new Shema_Exception("Fehler beim Einlesen der Daten. Der eingegebene Patch-Level ist nicht gültig.\\nPatch-Level Eingabe-String: '".$patch_level."'");
    }

    return str_replace(".","",$patch_level);
  }


  # reverse process: converting filename back to data
  public static function convert_filename_to_data(string $filename_part) : array {

    # error if patch level not matching regex pattern
    if(in_array(substr($filename_part,0,1).".".substr($filename_part,1), self::array_valid_patch_level) === false){
      throw new Shema_Exception("Fehler beim Auslesen der Daten. Der ausgelesene Patch-Level ist nicht gültig.\\nPatch-Level Eingabe-String: '".$filename_part."'");
    }

    $converted_patch_level = substr($filename_part,0,1).".".substr($filename_part,1);

    # return array in format of original ui data
    return [ current(Filename_Shema_Patch_Level::array_ui_data_key) => $converted_patch_level ];
  }


  # print converted data from filename to ui
  public static function print_filename_data_for_ui(array $filename_data) : void {
    # print data from filename to ui by formated string
    printf(Filename_Shema_Patch_Level::string_ui_format, current($filename_data));
  }

}

?>