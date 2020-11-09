<?php

class Filename_Shema_Categorie implements Filename_Shema {

  private const array_ui_data_key = [
    "select_shema_categorie"
  ];

  # format-string to use with printf to print in ui
  private const string_ui_format = "<span>%s</span>";

  # array with short id's of options
  # key: internal key for this value
  # value: short id
  private const array_option_id = [
    "option_core_mod" => "COR",
    "option_default_replacemant" => "DR",
    "option_tuning" => "TUN",
    "option_script" => "SCR",
    "option_mod_create_a_sim" => "MODCAS",
    "option_cc_create_a_sim" => "CCCAS",
    "option_cc_script" => "CCSCR",
    "option_cc_buy" => "CCBUY",
    "option_cc_build" => "CCBUI",
    "option_other" => "OTH"
  ];


  # convert data collected from ui to usable data for following process
  public static function convert_ui_data_to_data(array $data_from_ui) : array {

    # filter data for this schema from whole ui data
    $key = current(Filename_Shema_Categorie::array_ui_data_key);

    if(!isset($data_from_ui[$key])){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nFehlender Schlüssel in POST-Request: '$key'");
    }

    return [
      $data_from_ui[$key]
    ];
  }



  # convert data to filename part using this shema
  public static function convert_data_to_filename(array $data_converted) : string {

    # search ui-text-value and get key
    $key = current($data_converted);
    if(isset(Filename_Shema_Categorie::array_option_id[$key]) === false){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nFehlender Wert: ".current($data_converted));
    }

    # return short id of selected option
    return Filename_Shema_Categorie::array_option_id[$key];
  }


  # reverse process: converting filename back to data
  public static function convert_filename_to_data(string $filename_part) : array {

    if(empty($filename_part)){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten. Lehren Dateinamen erhalten.");
    }

    # search for short id and get key
    $key = array_search($filename_part, Filename_Shema_Categorie::array_option_id);
    if($key === false){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Wert '$filename_part' ist für die Kategorie nicht valide.");
    }

    # return array in format of original ui data
    return [current(Filename_Shema_Categorie::array_ui_data_key) => $key];
  }


  # print converted data from filename to ui
  public static function print_filename_data_for_ui(array $filename_data) : void {
    # print data from filename to ui by formated string
    printf(Filename_Shema_Categorie::string_ui_format, current($filename_data));
  }

}

?>