<?php

use PHPUnit\Framework\Constraint\ExceptionMessageRegularExpression;

class Filename_Shema_Flag implements Filename_Shema {

  public const array_ui_data_key = [
    "checkbox_shema_flag"
  ];

  # array of valid flag options
  private const array_ui_data_option_valid = [
    "option_install_in_overrides",
    "option_install_in_packages",
    "option_depends_on_content",
    "option_depends_on_expansion",
    "option_is_essential"
  ];

  # default flag to use if no flag-options were selected
  # equal to an empty option
  public const default_flag_if_no_options_selected = "no_flag_option_selected";

  # short id for each valid flag-option
  public const array_option_short_id = [
    "option_install_in_overrides" => "O",
    "option_install_in_packages" => "P",
    "option_depends_on_content" => "D",
    "option_depends_on_expansion" => "E",
    "option_is_essential" => "V",
    "no_flag_option_selected" => "I"
  ];

  # array of invalid combinations of values from ui-data-key-array
  # format: option-value => option-value to not combine with
  private const array_ui_data_option_not_combineable = [
    "option_install_in_overrides" => [
      "option_install_in_packages"
    ],
    "no_flag_option_selected" => [
      "option_install_in_overrides",
      "option_install_in_packages",
      "option_depends_on_content",
      "option_depends_on_expansion",
      "option_is_essential"
    ]
  ];


  # string-delimiter to connect flag-segments in filename
  public const filename_flag_delimiter = "_";

  # array of option-values and their keys for sub-content in ui-data
  # format: option-value => key or sub-content in ui-data
  public const array_ui_data_key_sub_data = [
    "option_depends_on_expansion" => [
      "select_flag_data_depends_on_expansion"
    ],
    "option_depends_on_content" => [
      "url_flag_data_depends_on_content"
    ]
  ];

  # format-string to use with printf to print in ui
  private const string_ui_format = "<span>%s</span>";


  # convert data collected from ui to usable data for following process
  public static function convert_ui_data_to_data(array $data_from_ui) : array {

    # filter data for this schema from whole ui data
    $main_key = current(Filename_Shema_Flag::array_ui_data_key);

    if(!isset($data_from_ui[$main_key])){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nFehlender Schlüssel in POST-Request: '$main_key'");
    }

    # check for not valid flag-options in ui-data
    $main_data = $data_from_ui[$main_key];
    Filename_Shema_Flag::check_ui_data_for_not_valid_flag_options($main_data);

    # check for not double flag-options in ui-data
    Filename_Shema_Flag::check_ui_data_for_double_flag_options($main_data);

    # check for not combineable flag-options
    Filename_Shema_Flag::check_ui_data_for_not_combineable_options($main_data);

    if(empty($main_data)){
      $main_data = [Filename_Shema_Flag::default_flag_if_no_options_selected];
    }

    # create array with sub-options required data from other options
    $array_sub_data = Filename_Shema_Flag::create_array_with_required_sub_data_from_ui_data($data_from_ui);

    return [
      "keys" => $main_data,
      "sub_data" => $array_sub_data
    ];
  }


  # check ui data for not combineable options
  private static function check_ui_data_for_not_combineable_options(array $data) : bool {
    foreach($data as $key_option){
      if(isset(Filename_Shema_Flag::array_ui_data_option_not_combineable[$key_option])){
        foreach(Filename_Shema_Flag::array_ui_data_option_not_combineable[$key_option] as $key_option_not_combineable){
          if(array_search($key_option_not_combineable, $data) !== false){
            throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Optionsschlüssel '$key_option' ist nicht kombinierbar mit dem Optionsschlüssel '$key_option_not_combineable'.");
            return false;
          }
        }
      }
    }
    return true;
  }


  # check for double flag options in ui-data
  private static function check_ui_data_for_double_flag_options(array $data) : bool {
    if(count(array_unique($data))<count($data)){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Optionsschlüssel '".current(array_diff_key($data,array_unique($data)))."' existiert doppelt.");
      return false;
    }
    return true;
  }


  # check for not valid flag options in ui-data
  private static function check_ui_data_for_not_valid_flag_options(array $data) : bool {
    foreach($data as $flag_option){
      if(array_search($flag_option, Filename_Shema_Flag::array_ui_data_option_valid) === false){
        throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Optionsschlüssel '$flag_option' ist nicht hinterlegt und daher nicht gültig.");
        return false;
      }
    }
    return true;
  }


  # create array with data of sub-options that are required by other options
  # error if key with sub-data not existing
  public static function create_array_with_required_sub_data_from_ui_data(array $data_from_ui) : array {
    $array_sub_data = [];
    foreach(Filename_Shema_Flag::array_ui_data_key_sub_data as $key_option => $array_sub_keys){
      if(array_search($key_option, $data_from_ui[current(Filename_Shema_Flag::array_ui_data_key)]) !== false){
        foreach($array_sub_keys as $key_sub_data){
          if(!isset($data_from_ui[$key_sub_data])){
            throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Optionsschlüssel '$key_option' braucht zustätzliche Daten unter dem Schlüssel '$key_sub_data'.");
          }
          else {
            $array_sub_data[$key_option][$key_sub_data] = $data_from_ui[$key_sub_data];
          }
        }
      }
    }
    return $array_sub_data;
  }


  # convert data to filename part using this shema
  public static function convert_data_to_filename(array $data_converted) : string {

    $array_flag_result = [];

    foreach($data_converted["keys"] as $option_key){
      $function_name = "convert_data_to_filename_$option_key";
      $array_flag_result[] = Filename_Shema_Flag::$function_name($data_converted, $option_key);
    }

    return implode(Filename_Shema_Flag::filename_flag_delimiter,$array_flag_result);
  }


  # convert data to file for install in ovverides flag option
  private static function convert_data_to_filename_option_install_in_overrides(array $data, string $option_key) : string {
    $result = "";
    $result .= Filename_Shema_Flag::array_option_short_id[$option_key];
    return $result;
  }

  # convert data to file for install in packages flag option
  private static function convert_data_to_filename_option_install_in_packages(array $data, string $option_key) : string {
    $result = "";
    $result .= Filename_Shema_Flag::array_option_short_id[$option_key];
    return $result;
  }

  # convert data to file for depends on content flag option
  private static function convert_data_to_filename_option_depends_on_content(array $data, string $option_key) : string {
    $result = "";
    $result .= Filename_Shema_Flag::array_option_short_id[$option_key];

    # iterate through sub data
    foreach($data["sub_data"][$option_key] as $key_sub_data => $sub_data){

      # error if required sub data is empty
      if(empty($sub_data)){
        throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Optionsschlüssel '$key_sub_data' darf nicht leer sein.");
      }

      if(Url_Shortener_API_Handler::test_if_url_is_valid($sub_data) === false){
        throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Link für den Optionsschlüssel '$key_sub_data' gibt keinen validen HTTP-Response-Code zurück.");
      }

      $result .= Url_Shortener_API_Handler::short_url($sub_data);
    }

    return $result;
  }



  # convert data to file for depends on expansion flag option
  private static function convert_data_to_filename_option_depends_on_expansion(array $data, string $option_key) : string {
    $result = "";
    $result .= Filename_Shema_Flag::array_option_short_id[$option_key];

    # iterate through sub data
    foreach($data["sub_data"][$option_key] as $key_sub_data => $sub_data){

      # error if required sub data is empty
      if(empty($sub_data)){
        throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Optionsschlüssel '$key_sub_data' darf nicht leer sein.");
      }

      # error if value of sub data not matching regex pattern
      # subdata value always to lowercase
      $sub_data_lowercase = strtolower($sub_data);
      if(preg_match("/^ep(0[1-9]|10|11)|sp0[1-9]$/",$sub_data_lowercase) === 0){
        throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Wert '$sub_data' für den Optionsschlüssel '$key_sub_data' ist nicht gültig.");
      }

      $result .= $sub_data_lowercase;
    }

    return $result;
  }

  # convert data to file for is essential flag option
  private static function convert_data_to_filename_option_is_essential(array $data, string $option_key) : string {
    $result = "";
    $result .= Filename_Shema_Flag::array_option_short_id[$option_key];
    return $result;
  }

  # convert data to file for no option selected flag option
  private static function convert_data_to_filename_no_flag_option_selected(array $data, string $option_key) : string {
    $result = "";
    $result .= Filename_Shema_Flag::array_option_short_id[$option_key];
    return $result;
  }



  # reverse process: converting filename back to data
  public static function convert_filename_to_data(string $filename_part) : array {
    $array_result = [];

    $filename_as_array = explode(Filename_Shema_Flag::filename_flag_delimiter,$filename_part);
    $main_key = current(Filename_Shema_Flag::array_ui_data_key);
    $array_result[$main_key] = [];

    # iterate through filename data
    foreach($filename_as_array as $filename_part){

      $short_id = substr($filename_part,0,1);
      $option = array_search($short_id, Filename_Shema_Flag::array_option_short_id);

      # error if flag not valid
      # skip this flag
      if($option === false){
        new Shema_Exception("Fehler beim Auslesen der Daten.\\nDas Flag '$short_id' im Dateinamen ist nicht gültig. Das Flag '$short_id' wird daher für diese Datei übersprungen.", false);
        continue;
      }

      # if no-options-selected flag, reset result and stop loop
      if($option === Filename_Shema_Flag::default_flag_if_no_options_selected){

        # error if no-options-selected flag but additional flags are available
        # skip this flag, do not reset result-array
        if(count($filename_as_array) > 1){
          new Shema_Exception("Fehler beim Auslesen der Daten.\\nDas Flag '$short_id' im Dateinamen darf nur existieren, wenn kein Flag für diese Datei gewählt wurde. Das Flag '$short_id' wird für diese Datei übersprungen und die restlichen Flags und deren Daten bleiben erhalten.", false);
          continue;
        }
        $array_result = [];
        $array_result[$main_key] = [];
        break;
      }


      if(array_search($option, $array_result[$main_key]) !== false){
        new Shema_Exception("Fehler beim Auslesen der Daten.\\nDas Flag '$short_id' ist doppelt vorhanden. Das zweite Flag '$short_id' wird für diese Datei übersprungen.", false);
        continue;
      }

      # if option contains sub-data, add it to result array
      if(isset(Filename_Shema_Flag::array_ui_data_key_sub_data[$option])){
        if(strlen($filename_part) > 1){
          $value = substr($filename_part,1);
          $key = current(Filename_Shema_Flag::array_ui_data_key_sub_data[$option]);
          if($option === "option_depends_on_content"){
            try {
              $value = Url_Shortener_API_Handler::expand_url($value);
            }
            catch(Exception $e){
              $value = "";
            }
          }
          $array_result[$key] = $value;
        }

        # error if flag requires sub-data, but no sub-data given
        # skip adding the sub-data
        else {
          new Shema_Exception("Fehler beim Auslesen der Daten.\\nDas Shema sieht für das Flag '$short_id' weitere Daten vor, doch im Dateinamen sind keine für dieses Flag vorhanden. Das Flag '$short_id' wird daher für diese Datei übersprungen.", false);
          continue;
        }
      }

      # if flag from filename contains sub data, but no sub data is required
      elseif(strlen($filename_part) > 1){
        new Shema_Exception("Fehler beim Auslesen der Daten.\\nDas Shema sieht für das Flag '$short_id' keine weitere Daten vor, doch im Dateinamen sind für dieses Flag vorhanden weitere Daten vorhanden. Die weiteren Daten unter dem Flag '$short_id' werden für diese Datei ignoriert.", false);
      }

      # add option to result array
      $array_result[$main_key][] = $option;
    }

    return $array_result;
  }



  # print converted data from filename to ui
  public static function print_filename_data_for_ui(array $filename_data) : void {

    $main_key = current(Filename_Shema_Flag::array_ui_data_key);

    # filter flag options from filename data
    $flag_options = $filename_data[$main_key];

    # filter sub data from filename_data
    $sub_data = array_filter($filename_data, function($key){
      return $key == current(Filename_Shema_Flag::array_ui_data_key) ? false : true;
    }, ARRAY_FILTER_USE_KEY);


    # print options
    foreach($flag_options as $option){
      printf(Filename_Shema_Flag::string_ui_format, $option);
    }

    # print sub data value
    foreach($sub_data as $sub_data_key => $sub_data_value){
      printf(Filename_Shema_Flag::string_ui_format, $sub_data_value);
    }
  }

}

?>