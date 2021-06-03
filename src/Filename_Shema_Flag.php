<?php

use PHPUnit\Framework\Constraint\ExceptionMessageRegularExpression;

abstract class Filename_Shema_Flag implements I_Filename_Shema {

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

  # input shema template for ui
  private const input_shema_template = '
  <span class="toggle_rowbreak"></span>
  <div class="container_label_and_input">
    <input type="checkbox" class="%3$s%1$d" name="%2$s[%1$d][checkbox_shema_flag][]" id="option_install_in_overrides%1$d" value="option_install_in_overrides">
    <label for="option_install_in_overrides%1$d">muss in Overrides-Ordner installiert werden</label>
  </div>

  <div class="container_label_and_input">
    <input type="checkbox" class="%3$s%1$d" name="%2$s[%1$d][checkbox_shema_flag][]" id="option_install_in_packages%1$d" value="option_install_in_packages">
    <label for="option_install_in_packages%1$d">muss in Packages-Ordner installiert werden</label>
  </div>

  <div class="container_label_and_input">
    <input type="checkbox" class="%3$s%1$d" name="%2$s[%1$d][checkbox_shema_flag][]" id="option_depends_on_content%1$d" value="option_depends_on_content" onclick="disable_and_hide_input_by_class_name_if_source_element_is_not_checked(\'option_depends_on_content%1$d\', \'option_depends_on_content%1$d\')">
    <label for="option_depends_on_content%1$d">abhängig von anderem Mod, CC, Store oder ähnlichem</label>
    <script>
      document.addEventListener("DOMContentLoaded", function(){
        setTimeout(function(){
          disable_and_hide_input_by_class_name_if_source_element_is_not_checked(\'option_depends_on_content%1$d\',\'option_depends_on_content%1$d\');
        },100);
      });
    </script>
  </div>

  <div class="option_depends_on_content%1$d container_label_and_input sub_input">
    <label class="option_depends_on_content%1$d" for="url_flag_data_depends_on_content%1$d">Link zum Mod, CC von dem dieser Mod, CC abhängig ist</label>
    <input class="option_depends_on_content%1$d %3$s%1$d" id="url_flag_data_depends_on_content%1$d" type="url" name="%2$s[%1$d][url_flag_data_depends_on_content]" required disabled>
  </div>

  <div class="container_label_and_input">
    <input type="checkbox" class="%3$s%1$d" name="%2$s[%1$d][checkbox_shema_flag][]" id="option_depends_on_expansion%1$d" value="option_depends_on_expansion" onclick="disable_and_hide_input_by_class_name_if_source_element_is_not_checked(\'option_depends_on_expansion%1$d\', \'option_depends_on_expansion%1$d\')">
    <label for="option_depends_on_expansion%1$d">abhängig von Erweiterungspack oder Accessoirepack</label>
    <script>
      document.addEventListener("DOMContentLoaded", function(){
        setTimeout(function(){
          disable_and_hide_input_by_class_name_if_source_element_is_not_checked(\'option_depends_on_expansion%1$d\',\'option_depends_on_expansion%1$d\');
        },100);
      });
    </script>
  </div>

  <div class="option_depends_on_expansion%1$d container_label_and_input sub_input">
    <label class="option_depends_on_expansion%1$d" for="select_flag_data_depends_on_expansion%1$d">Erweiterung von dem dieser Mod, CC abhängig ist</label>
    <select class="option_depends_on_expansion%1$d %3$s%1$d" id="select_flag_data_depends_on_expansion%1$d" name="%2$s[%1$d][select_flag_data_depends_on_expansion]" required disabled>
      <option value="" selected disabled>Auswählen</option>
      <optgroup label="Erweiterungspack">
        <option value="ep01">Reiseabenteuer</option>
        <option value="ep02">Traumkarrieren</option>
        <option value="ep03">Late Night</option>
        <option value="ep04">Lebensfreude</option>
        <option value="ep05">Einfach Tierisch</option>
        <option value="ep06">Showtime</option>
        <option value="ep07">Supernatural</option>
        <option value="ep08">Jahreszeiten</option>
        <option value="ep09">Wildes Studentenleben</option>
        <option value="ep10">Inselparadies</option>
        <option value="ep11">Into The Future</option>
      </optgroup>
      <optgroup label="Accessoirepack">
        <option value="sp01">Luxus Accessoires</option>
        <option value="sp02">Gib Gas Accessoires</option>
        <option value="sp03">Design Garten Accessoires</option>
        <option value="sp04">Stadt Accessoires</option>
        <option value="sp05">Traumsuite Accessoires</option>
        <option value="sp06">Katy Perry Süße Welt</option>
        <option value="sp07">Diesel Accessoires</option>
        <option value="sp08">70er, 80er & 90er Accessoires</option>
        <option value="sp09">Movie Accessoires</option>
      </optgroup>
    </select>
  </div>

  <div class="container_label_and_input">
    <input type="checkbox" name="%2$s[%1$d][checkbox_shema_flag][]" class="%3$s%1$d" id="option_is_essential%1$d" value="option_is_essential">
    <label for="option_is_essential%1$d">gehört zu den absolut wichtigsten Mods/CC, die immer installiert sein sollen</label>
  </div>
  ';


  # convert data collected from ui to usable data for following process
  public static function convert_ui_data_to_data(array $data_from_ui) : array {

    # filter data for this schema from whole ui data
    $main_key = current(self::array_ui_data_key);

    if(!isset($data_from_ui[$main_key])){
      $data_from_ui[$main_key] = [];
    }

    # check for not valid flag-options in ui-data
    $main_data = $data_from_ui[$main_key];
    self::check_ui_data_for_not_valid_flag_options($main_data);

    # check for not double flag-options in ui-data
    self::check_ui_data_for_double_flag_options($main_data);

    # check for not combineable flag-options
    self::check_ui_data_for_not_combineable_options($main_data);

    if(empty($main_data)){
      $main_data = [self::default_flag_if_no_options_selected];
    }

    # create array with sub-options required data from other options
    $array_sub_data = self::create_array_with_required_sub_data_from_ui_data($data_from_ui);

    return [
      "keys" => $main_data,
      "sub_data" => $array_sub_data
    ];
  }


  # check ui data for not combineable options
  private static function check_ui_data_for_not_combineable_options(array $data) : bool {
    foreach($data as $key_option){
      if(isset(self::array_ui_data_option_not_combineable[$key_option])){
        foreach(self::array_ui_data_option_not_combineable[$key_option] as $key_option_not_combineable){
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
      if(array_search($flag_option, self::array_ui_data_option_valid) === false){
        throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Optionsschlüssel '$flag_option' ist nicht hinterlegt und daher nicht gültig.");
        return false;
      }
    }
    return true;
  }


  # create array with data of sub-options that are required by other options
  # error if key with sub-data not existing
  private static function create_array_with_required_sub_data_from_ui_data(array $data_from_ui) : array {
    $array_sub_data = [];
    foreach(self::array_ui_data_key_sub_data as $key_option => $array_sub_keys){
      if(array_search($key_option, $data_from_ui[current(self::array_ui_data_key)]) !== false){
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
      $array_flag_result[] = self::$function_name($data_converted, $option_key);
    }

    return implode(self::filename_flag_delimiter,$array_flag_result);
  }


  # convert data to file for install in ovverides flag option
  private static function convert_data_to_filename_option_install_in_overrides(array $data, string $option_key) : string {
    $result = "";
    $result .= self::array_option_short_id[$option_key];
    return $result;
  }

  # convert data to file for install in packages flag option
  private static function convert_data_to_filename_option_install_in_packages(array $data, string $option_key) : string {
    $result = "";
    $result .= self::array_option_short_id[$option_key];
    return $result;
  }

  # convert data to file for depends on content flag option
  private static function convert_data_to_filename_option_depends_on_content(array $data, string $option_key) : string {
    $result = "";
    $result .= self::array_option_short_id[$option_key];

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
    $result .= self::array_option_short_id[$option_key];

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
    $result .= self::array_option_short_id[$option_key];
    return $result;
  }

  # convert data to file for no option selected flag option
  private static function convert_data_to_filename_no_flag_option_selected(array $data, string $option_key) : string {
    $result = "";
    $result .= self::array_option_short_id[$option_key];
    return $result;
  }


  # reverse process: converting filename back to data
  public static function convert_filename_to_data(string $filename_part) : array {
    $main_key = current(self::array_ui_data_key);
    $array_result = [$main_key => []];
    $filename_as_array = explode(self::filename_flag_delimiter,$filename_part);

    # iterate through filename data
    foreach($filename_as_array as $filename_flag_part){

      $short_id = substr($filename_flag_part,0,1);
      $option = array_search($short_id, self::array_option_short_id);

      # if flag not valid, skip this flag for this file
      if(self::convert_filename_to_data_validate_option($option, $filename_flag_part, $filename_as_array, $array_result[$main_key]) === false ||
         self::convert_filename_to_data_check_for_not_combineable_options($option, $filename_as_array) === false){
        continue;
      }

      # add option to result array
      # process data specific to flag
      $function_name = "convert_filename_to_data_$option";
      if(self::$function_name($filename_flag_part, $array_result) === true){
        $array_result[$main_key][] = $option;
      }

    }

    return $array_result;
  }


  # validate option keys for convert filename to data
  private static function convert_filename_to_data_validate_option(string $option, string $filename_flag_part, array $filename_as_array, array $result_stored_options) : bool {
    $short_id = self::array_option_short_id[$option];

    # error if flag option not valid
    if($option === false){
      new Shema_Exception("Fehler beim Auslesen der Daten.\\nDas Flag '$short_id' im Dateinamen ist nicht gültig. Das Flag '$short_id' wird daher für diese Datei übersprungen.", false);
      return false;
    }

    # if no-options-selected flag
    # error if no-options-selected flag but additional flags are available
    if($option === self::default_flag_if_no_options_selected && count($filename_as_array) > 1){
      new Shema_Exception("Fehler beim Auslesen der Daten.\\nDas Flag '$short_id' im Dateinamen darf nur existieren, wenn kein Flag für diese Datei gewählt wurde. Das Flag '$short_id' wird für diese Datei übersprungen und die restlichen Flags und deren Daten bleiben erhalten.", false);
      return false;
    }

    # if option has duplicate in result
    if(in_array($option, $result_stored_options) === true){
      new Shema_Exception("Fehler beim Auslesen der Daten.\\nDas Flag '$short_id' ist doppelt vorhanden. Das zweite Flag '$short_id' wird für diese Datei übersprungen.", false);
      return false;
    }

    # if flag requires sub data, but no so sub data existing
    if(isset(self::array_ui_data_key_sub_data[$option]) && strlen($filename_flag_part) <= 1) {
      new Shema_Exception("Fehler beim Auslesen der Daten.\\nDas Shema sieht für das Flag '$short_id' weitere Daten vor, doch im Dateinamen sind keine für dieses Flag vorhanden. Das Flag '$short_id' wird daher für diese Datei übersprungen.", false);
      return false;
    }

    # if no so sub data required, but sub data is existing
    if(isset(self::array_ui_data_key_sub_data[$option]) === false && strlen($filename_flag_part) > 1){
      new Shema_Exception("Fehler beim Auslesen der Daten.\\nDas Shema sieht für das Flag '$short_id' keine weitere Daten vor, doch im Dateinamen sind für dieses Flag vorhanden weitere Daten vorhanden. Die weiteren Daten unter dem Flag '$short_id' werden für diese Datei ignoriert.", false);
      return true;
    }

    return true;
  }


  private static function convert_filename_to_data_option_install_in_overrides(string $filename_part, array &$array_result) : bool {
    return true;
  }


  private static function convert_filename_to_data_option_install_in_packages(string $filename_part, array &$array_result) : bool {
    return true;
  }


  private static function convert_filename_to_data_option_depends_on_content(string $filename_part, array &$array_result) : bool {
    $short_id = substr($filename_part,0,1);
    $value = substr($filename_part,1);
    try {
      $result = Url_Shortener_API_Handler::expand_url($value);
    }
    catch(Exception $e){
      return false;
    }
    $key = current(self::array_ui_data_key_sub_data["option_depends_on_content"]);
    $array_result[$key] = $result;
    return true;
  }


  private static function convert_filename_to_data_option_depends_on_expansion(string $filename_part, array &$array_result) : bool {
    $short_id = substr($filename_part,0,1);
    $value = strtolower(substr($filename_part,1));
    if(preg_match("/^ep(0[1-9]|10|11)|sp0[1-9]$/",$value) === 0){
      new Shema_Exception("Fehler beim Auslesen der Daten.\\nDer Wert '$value' für das Flag '$short_id' ist nicht gültig. Das Flag '$short_id' wird daher für diese Datei übersprungen.", false);
      return false;
    }
    $key = current(self::array_ui_data_key_sub_data["option_depends_on_expansion"]);
    $array_result[$key] = $value;
    return true;
  }


  private static function convert_filename_to_data_option_is_essential(string $filename_part, array &$array_result) : bool {
    return true;
  }


  private static function convert_filename_to_data_no_flag_option_selected(string $filename_part, array &$array_result) : bool {
    $main_key = current(self::array_ui_data_key);
    $array_result = [$main_key => []];
    return false;
  }


  # check for not combineable options in filename_part
  private static function convert_filename_to_data_check_for_not_combineable_options(string $option, array $filename_as_array) : bool {
    $short_id = self::array_option_short_id[$option];

    # return true if option not existing in array_ui_data_option_not_combineable
    if(isset(self::array_ui_data_option_not_combineable[$option]) === false){
      return true;
    }

    # iterate through not combineable options
    # return false, if not combineable option is equal to option and out error
    foreach(self::array_ui_data_option_not_combineable[$option] as $not_combineable_with_option){
      $short_id_not_combineable = self::array_option_short_id[$not_combineable_with_option];
      if(empty(preg_grep("/^".$short_id_not_combineable.".*/", $filename_as_array)) === false){
        new Shema_Exception("Fehler beim Auslesen der Daten.\\nDas Flag '$short_id' ist nicht kombinierbar mit dem Flag '$short_id_not_combineable'. Das Flag '$short_id' wird daher für diese Datei übersprungen.", false);
        return false;
      }
    }
    return true;
  }


  # print converted data from filename to ui
  public static function print_filename_data_for_ui(array $filename_data) : void {

    $main_key = current(self::array_ui_data_key);

    # filter flag options from filename data
    $flag_options = $filename_data[$main_key];

    # filter sub data from filename_data
    $sub_data = array_filter($filename_data, function($key){
      return $key == current(self::array_ui_data_key) ? false : true;
    }, ARRAY_FILTER_USE_KEY);


    # print options
    foreach($flag_options as $option){
      printf(self::string_ui_format, $option);
    }

    # print sub data value
    foreach($sub_data as $sub_data_key => $sub_data_value){
      printf(self::string_ui_format, $sub_data_value);
    }
  }


  # print filename shema input to ui
  public static function print_filename_shema_input_for_ui(int $index) : void {
    printf(self::input_shema_template, $index, Ui::ui_data_key_root, Filename_Shema_Flag::class);
  }


  # print filename shema search input to ui
  public static function print_filename_shema_search_input_for_ui(int $index) : void {
    printf(self::input_shema_template, $index, Ui::ui_search_data_key_root, Filename_Shema_Flag::class);
  }

}

?>