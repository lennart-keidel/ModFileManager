<?php

class Filename_Shema_Flag implements Filename_Shema {

  public const array_ui_data_key = [
    "checkbox_shema_flag"
  ];

  # array of option-values and their keys for sub-content in ui-data
  # format: option-value => key or sub-content in ui-data
  private const array_ui_data_key_sub_data = [
    "option_depends_on_expansion" => "select_flag_data_depends_on_expansion",
    "option_depends_on_content" => "url_flag_data_depends_on_content"
  ];

  # array of invalid combinations of values from ui-data-key-array
  # format: option-value => option-value to not combine with
  private const array_ui_data_value_not_combineable = [
    "option_install_in_overrides" => [
      "option_install_in_packages"
    ]
  ];

  # format-string to use with printf to print in ui
  private const string_ui_format = "<span>%s</span>";


  # convert data collected from ui to usable data for following process
  public static function convert_ui_data_to_data(array $data_from_ui) : array {

    # filter data for this schema from whole ui data
    $main_key = current(Filename_Shema_Flag::array_ui_data_key);
    $main_data = $data_from_ui[$main_key];

    if(!isset($main_data)){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nFehlender Schlüssel in POST-Request: '$main_key'");
    }

    # check for not combineable flag-options
    foreach($main_data as $key_option){
      if(isset(Filename_Shema_Flag::array_ui_data_value_not_combineable[$key_option])){
        foreach(Filename_Shema_Flag::array_ui_data_value_not_combineable[$key_option] as $key_option_not_combineable){
          if(isset($main_data[$key_option_not_combineable])){
            throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Optionsschlüssel '$key_option' ist nicht kombinierbar mit dem Optionsschlüssel '$key_option_not_combineable'.");
          }
        }
      }
    }

    # create array with sub-data
    # error if key with sub-data not existing
    $array_sub_data = [];
    foreach(Filename_Shema_Flag::array_ui_data_key_sub_data as $key_option => $key_sub_data){
      if(isset($main_data[$key_option])){
        if(!isset($data_from_ui[$key_sub_data])){
          throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Optionsschlüssel '$key_option' braucht zustätzliche Daten unter dem Schlüssel '$key_sub_data'.");
        }
        else {
          $array_sub_data[$key_option] = $data_from_ui[$key_sub_data];
        }
      }
    }

    var_dump([
      $main_data,
      "sub" => $array_sub_data
    ]);

    return [
      $main_data,
      "sub_data" => $array_sub_data
    ];
  }


  # convert data to filename part using this shema
  public static function convert_data_to_filename(array $data_converted) : string {

    $installation_date = current($data_converted);

    # error if patch level not matching regex input format
    if(preg_match(Filename_Shema_Flag::regex_date_io,$installation_date) !== 1){
      throw new Shema_Exception("Fehler beim Einlesen der Daten. Das eingegebene Installationsdatum ist nicht gültig.\\nDatum Eingabe-String: '".$installation_date."'");
    }

    # create datetime-object from input date
    # use datetime-object to be unix-epoch error safe
    $date_time_object = @DateTime::createFromFormat(Filename_Shema_Flag::date_format_io, $installation_date);

    # format date
    $formated_date = @$date_time_object->format(Filename_Shema_Flag::date_format_filename);

    # error if
    # datetime-object is false
    # or formated date is not matching the regex output format
    # or formating datetime-object back to original date format is not equal to the original date
    if($date_time_object === false || preg_match(Filename_Shema_Flag::regex_date_filename, $formated_date) !== 1 || $date_time_object->format(Filename_Shema_Flag::date_format_io) !== $installation_date){
      throw new Shema_Exception("Fehler beim Verarbeiten der Daten. Das eingegebene Installationsdatum konnte nicht ohne Fehler umformatiert werden.\\nDatum Eingabe-String: '".$installation_date."'");
    }

    return $formated_date;
  }


  # reverse process: converting filename back to data
  public static function convert_filename_to_data(string $filename_part) : array {

    # error if patch level not matching regex pattern
    if(preg_match(Filename_Shema_Flag::regex_date_filename,$filename_part) !== 1){
      throw new Shema_Exception("Fehler beim Auslesen der Daten. Das ausgelesene Installationsdatum ist nicht gültig.\\nDatum Eingabe-String: '".$filename_part."'");
    }

    # create datetime-object from filename date
    # use datetime-object to be unix-epoch error safe
    $date_time_object = DateTime::createFromFormat(Filename_Shema_Flag::date_format_filename, $filename_part);

    # format date
    $formated_date = @$date_time_object->format(Filename_Shema_Flag::date_format_io);

    # error if
    # datetime-object is false
    # or formated date is not matching the regex output format
    # or formating datetime-object back to original date format is not equal to the original date
    if($date_time_object === false || preg_match(Filename_Shema_Flag::regex_date_io, $formated_date) !== 1 || $date_time_object->format(Filename_Shema_Flag::date_format_filename) !== $filename_part){
      throw new Shema_Exception("Fehler beim Auslesen der Daten. Das ausgelesene Installationsdatum ist nicht gültig.\\nDatum Eingabe-String: '".$filename_part."'");
    }

    # return array in format of original ui data
    return [ current(Filename_Shema_Flag::array_ui_data_key) => $formated_date ];
  }


  # print converted data from filename to ui
  public static function print_filename_data_for_ui(array $filename_data) : void {
    # print data from filename to ui by formated string
    printf(Filename_Shema_Flag::string_ui_format, current($filename_data));
  }

}

?>