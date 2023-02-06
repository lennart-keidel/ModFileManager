<?php

abstract class Filename_Shema_Flag extends Compareable_Is_In_Array_Operand implements I_Filename_Shema {

  public const array_ui_data_key = [
    self::class
  ];

  # array of valid flag options
  private const array_ui_data_option_valid = [
    "option_install_in_overrides",
    "option_not_merge",
    // "option_install_in_packages",
    "option_depends_on_content",
    "option_depends_on_expansion",
    "option_is_essential",
    "option_is_default_replacement",
  ];

  # default flag to use if no flag-options were selected
  # equal to an empty option
  public const default_flag_if_no_options_selected = "no_flag_option_selected";

  # short id for each valid flag-option
  public const array_option_short_id = [
    "option_install_in_overrides" => "O",
    "option_not_merge" => "M",
    // "option_install_in_packages" => "P",
    "option_depends_on_content" => "C",
    "option_depends_on_expansion" => "E",
    "option_is_essential" => "V",
    "no_flag_option_selected" => "I",
    "option_is_default_replacement" => "D",
  ];

  # array of invalid combinations of values from ui-data-key-array
  # format: option-value => option-value to not combine with
  private const array_ui_data_option_not_combineable = [
    // "option_install_in_overrides" => [
    //   "option_install_in_packages"
    // ],
    "no_flag_option_selected" => [
      "option_install_in_overrides",
      "option_not_merge",
      // "option_install_in_packages",
      "option_depends_on_content",
      "option_depends_on_expansion",
      "option_is_essential",
      "option_is_default_replacement"
    ]
  ];


  # string-delimiter to connect flag-segments in filename
  public const filename_flag_delimiter = "_";

  # array of option-values and their keys for sub-content in ui-data
  # format: option-value => key or sub-content in ui-data
  public const array_ui_data_key_sub_data = [
    "option_depends_on_expansion" => [
      "Sub_Data_Flag_Depends_On_Expansion"
    ],
    "option_depends_on_content" => [
      "Sub_Data_Flag_Depends_On_Content"
    ]
  ];

  # format-string to use with printf to print in ui
  private const string_ui_format = "<span>%s</span>";

  # input shema template for ui
  private const input_shema_template = '
  <span class="toggle_rowbreak"></span>
  <div class="container_label_and_input">
    <input type="checkbox" %6$s name="%2$s[%1$d]['.self::class.'][]" class="%3$s%1$d option_is_default_replacement%1$d" id="option_is_default_replacement%1$d" value="option_is_default_replacement">
    <label for="option_is_default_replacement%1$d">ist Default Replacement</label>
  </div>

  <div class="container_label_and_input">
    <input type="checkbox" %6$s class="%3$s%1$d option_install_in_overrides%1$d" name="%2$s[%1$d]['.self::class.'][]" id="option_install_in_overrides%1$d" value="option_install_in_overrides">
    <label for="option_install_in_overrides%1$d">muss in Overrides-Ordner installiert werden</label>
  </div>

  <div class="container_label_and_input">
    <input type="checkbox" %6$s class="%3$s%1$d option_not_merge%1$d" name="%2$s[%1$d]['.self::class.'][]" id="option_not_merge%1$d" value="option_not_merge">
    <label for="option_not_merge%1$d">darf nicht mit anderen Dateien gemerget werden</label>
  </div>
  '.
  // <div class="container_label_and_input">
  //   <input type="checkbox" class="%3$s%1$d" name="%2$s[%1$d]['.self::class.'][]" id="option_install_in_packages%1$d" value="option_install_in_packages">
  //   <label for="option_install_in_packages%1$d">muss in Packages-Ordner installiert werden</label>
  // </div>
  '
  <div class="container_label_and_input">
    <input type="checkbox" %6$s class="%3$s%1$d option_depends_on_content%1$d" name="%2$s[%1$d]['.self::class.'][]" id="option_depends_on_content%1$d" value="option_depends_on_content" onclick="disable_and_hide_input_by_class_name_if_source_element_is_not_checked(\'option_depends_on_content%1$d\', \'sub_data_option_depends_on_content%1$d\')">
    <label for="option_depends_on_content%1$d">abhängig von anderem Mod, CC, Store oder ähnlichem</label>
    <script>
      document.addEventListener("DOMContentLoaded", function(){
        setTimeout(function(){
          disable_and_hide_input_by_class_name_if_source_element_is_not_checked(\'option_depends_on_content%1$d\',\'sub_data_option_depends_on_content%1$d\');
        },100);
      });
    </script>
  </div>

  %4$s

  <div class="container_label_and_input">
    <input type="checkbox" %6$s class="%3$s%1$d option_depends_on_expansion%1$d" name="%2$s[%1$d]['.self::class.'][]" id="option_depends_on_expansion%1$d" value="option_depends_on_expansion" onclick="disable_and_hide_input_by_class_name_if_source_element_is_not_checked(\'option_depends_on_expansion%1$d\', \'sub_data_option_depends_on_expansion%1$d\')">
    <label for="option_depends_on_expansion%1$d">abhängig von Erweiterungspack oder Accessoirepack</label>
    <script>
      document.addEventListener("DOMContentLoaded", function(){
        setTimeout(function(){
          disable_and_hide_input_by_class_name_if_source_element_is_not_checked(\'option_depends_on_expansion%1$d\',\'sub_data_option_depends_on_expansion%1$d\');
        },100);
      });
    </script>
  </div>

  %5$s

  <div class="container_label_and_input">
    <input type="checkbox" %6$s name="%2$s[%1$d]['.self::class.'][]" class="%3$s%1$d option_is_essential%1$d" id="option_is_essential%1$d" value="option_is_essential">
    <label for="option_is_essential%1$d">gehört zu den absolut wichtigsten Mods/CC, die immer installiert sein sollen</label>
  </div>
  ';


  # input shema template for search ui
  private const search_input_shema_template = '
  <script>
    document.addEventListener("DOMContentLoaded", function(){
      setTimeout(function(){
        disable_and_hide_input_by_class_name_if_source_element_is_not_checked(\'option_depends_on_content%1$d\',\'sub_data_option_depends_on_content%1$d\');
        disable_and_hide_input_by_class_name_if_source_element_is_not_checked(\'option_depends_on_expansion%1$d\',\'sub_data_option_depends_on_expansion%1$d\');
        disable_input_by_id_name_if_source_element_is_not_checked(\'option_install_in_overrides%1$d\',\'%3$s_operand%1$d_deaktivate_1\');
        disable_input_by_id_name_if_source_element_is_not_checked(\'option_not_merge%1$d\',\'%3$s_operand%1$d_deaktivate_2\');
        disable_input_by_id_name_if_source_element_is_not_checked(\'option_depends_on_content%1$d\',\'%3$s_operand%1$d_deaktivate_3\');
        disable_input_by_id_name_if_source_element_is_not_checked(\'option_depends_on_expansion%1$d\',\'%3$s_operand%1$d_deaktivate_4\');
        disable_input_by_id_name_if_source_element_is_not_checked(\'option_is_essential%1$d\',\'%3$s_operand%1$d_deaktivate_5\');
        disable_input_by_id_name_if_source_element_is_not_checked(\'option_is_default_replacement%1$d\',\'%3$s_operand%1$d_deaktivate_6\');
      },100);
    });
  </script>


  <div class="container_label_and_input">
    <select class="%3$s_operand%1$d %3$s%1$d" id="%3$s_operand%1$d_deaktivate_6" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]">
      %4$s
    </select>
    <input type="checkbox" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" class="%3$s%1$d %3$s_root%1$d option_is_default_replacement%1$d" id="option_is_default_replacement%1$d" value="option_is_default_replacement" onclick="disable_input_by_id_name_if_source_element_is_not_checked(\'option_is_default_replacement%1$d\',\'%3$s_operand%1$d_deaktivate_6\');">
    <label for="option_is_default_replacement%1$d">ist Default Replacement</label>
  </div>

  <span class="toggle_rowbreak"></span>
  <div class="container_label_and_input">
    <select class="%3$s_operand%1$d %3$s%1$d" id="%3$s_operand%1$d_deaktivate_1" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]">
      %4$s
    </select>
    <input type="checkbox" class="%3$s%1$d %3$s_root%1$d option_install_in_overrides%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" id="option_install_in_overrides%1$d" value="option_install_in_overrides" onclick="disable_input_by_id_name_if_source_element_is_not_checked(\'option_install_in_overrides%1$d\',\'%3$s_operand%1$d_deaktivate_1\');">
    <label for="option_install_in_overrides%1$d">muss in Overrides-Ordner installiert werden</label>
  </div>

  <div class="container_label_and_input">
    <select class="%3$s_operand%1$d %3$s%1$d" id="%3$s_operand%1$d_deaktivate_2" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]">
      %4$s
    </select>
    <input type="checkbox" class="%3$s%1$d %3$s_root%1$d option_not_merge%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" id="option_not_merge%1$d" value="option_not_merge" onclick="disable_input_by_id_name_if_source_element_is_not_checked(\'option_not_merge%1$d\',\'%3$s_operand%1$d_deaktivate_2\');">
    <label for="option_not_merge%1$d">darf nicht mit anderen Dateien gemerget werden</label>
  </div>
  '.
  // <div class="container_label_and_input">
  //   <input type="checkbox" class="%3$s%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" id="option_install_in_packages%1$d" value="option_install_in_packages">
  //   <label for="option_install_in_packages%1$d">muss in Packages-Ordner installiert werden</label>
  // </div>
  '
  <div class="container_label_and_input">
    <select class="%3$s_operand%1$d %3$s%1$d" id="%3$s_operand%1$d_deaktivate_3" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]">
      %4$s
    </select>
    <input type="checkbox" class="%3$s%1$d %3$s_root%1$d option_depends_on_content%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" id="option_depends_on_content%1$d" value="option_depends_on_content" onclick="disable_and_hide_input_by_class_name_if_source_element_is_not_checked(\'option_depends_on_content%1$d\', \'sub_data_option_depends_on_content%1$d\'); disable_input_by_id_name_if_source_element_is_not_checked(\'option_depends_on_content%1$d\',\'%3$s_operand%1$d_deaktivate_3\');">
    <label for="option_depends_on_content%1$d">abhängig von anderem Mod, CC, Store oder ähnlichem</label>

    %6$s

  </div>


  <div class="container_label_and_input">
    <select class="%3$s_operand%1$d %3$s%1$d" id="%3$s_operand%1$d_deaktivate_4" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]">
      %4$s
    </select>
    <input type="checkbox" class="%3$s%1$d %3$s_root%1$d option_depends_on_expansion%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" id="option_depends_on_expansion%1$d" value="option_depends_on_expansion" onclick="disable_and_hide_input_by_class_name_if_source_element_is_not_checked(\'option_depends_on_expansion%1$d\', \'sub_data_option_depends_on_expansion%1$d\'); disable_input_by_id_name_if_source_element_is_not_checked(\'option_depends_on_expansion%1$d\',\'%3$s_operand%1$d_deaktivate_4\');">
    <label for="option_depends_on_expansion%1$d">abhängig von Erweiterungspack oder Accessoirepack</label>

    %7$s

  </div>


  <div class="container_label_and_input">
    <select class="%3$s_operand%1$d %3$s%1$d" id="%3$s_operand%1$d_deaktivate_5" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]">
      %4$s
    </select>
    <input type="checkbox" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" class="%3$s%1$d %3$s_root%1$d option_is_essential%1$d" id="option_is_essential%1$d" value="option_is_essential" onclick="disable_input_by_id_name_if_source_element_is_not_checked(\'option_is_essential%1$d\',\'%3$s_operand%1$d_deaktivate_5\');">
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

  # convert data to file for install in ovverides flag option
  private static function convert_data_to_filename_option_not_merge(array $data, string $option_key) : string {
    $result = "";
    $result .= self::array_option_short_id[$option_key];
    return $result;
  }

  # convert data to file for install in packages flag option
  // private static function convert_data_to_filename_option_install_in_packages(array $data, string $option_key) : string {
  //   $result = "";
  //   $result .= self::array_option_short_id[$option_key];
  //   return $result;
  // }

  # convert data to file for depends on content flag option
  private static function convert_data_to_filename_option_depends_on_content(array $data, string $option_key) : string {
    $connected_links = "";

    # iterate through sub data
    foreach($data["sub_data"][$option_key] as $key_sub_data => $sub_data_array){

      # iterate through mulitple urls
      foreach($sub_data_array as $sub_data){

        # error if required sub data is empty
        if(empty($sub_data)){
          throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Optionsschlüssel '$key_sub_data' darf nicht leer sein.");
        }

        // if(Url_Shortener_API_Handler::test_if_url_is_valid($sub_data) === false){
        //   throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Link für den Optionsschlüssel '$key_sub_data' gibt keinen validen HTTP-Response-Code zurück.");
        // }

        # encode ; in url
        $sub_data = str_replace(";","%3B",$sub_data);

        # connect multiple url in one string with ; character
        if(empty($connected_links)){
          $connected_links = $sub_data;
        }
        else {
          $connected_links .= ";".$sub_data;
        }

      }
    }


    # return complete string of short id and short url
    return self::array_option_short_id[$option_key] . Url_Shortener_API_Handler::short_url($connected_links);
  }



  # convert data to file for depends on expansion flag option
  private static function convert_data_to_filename_option_depends_on_expansion(array $data, string $option_key) : string {
    $result = "";
    $result .= self::array_option_short_id[$option_key];

    # iterate through sub data
    foreach($data["sub_data"][$option_key] as $key_sub_data => $sub_data_array){

      # error if required sub data is empty
      if(empty($sub_data_array)){
        throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Optionsschlüssel '$key_sub_data' darf nicht leer sein.");
      }

      # error if value of sub data not matching regex pattern
      # subdata value always to lowercase
      foreach(array_unique($sub_data_array) as $sub_data){
        $sub_data = strtolower($sub_data);
        if(preg_match("/^ep(0[1-9]|10|11)|sp0[1-9]$/",$sub_data) === 0){
          throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Wert '$sub_data' für den Optionsschlüssel '$key_sub_data' ist nicht gültig.");
        }
        $result .= $sub_data;
      }

    }

    return $result;
  }

  # convert data to file for is essential flag option
  private static function convert_data_to_filename_option_is_essential(array $data, string $option_key) : string {
    $result = "";
    $result .= self::array_option_short_id[$option_key];
    return $result;
  }

  # convert data to file for is default replacement flag option
  private static function convert_data_to_filename_option_is_default_replacement(array $data, string $option_key) : string {
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
      if($option === false){
        throw new Shema_Exception("Fehler beim Auslesen der Daten.\\nDas Flag '$short_id' im Dateinamen ist nicht gültig. Das Flag '$short_id' wird daher für diese Datei übersprungen.", false);
        continue;
      }

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
      throw new Shema_Exception("Fehler beim Auslesen der Daten.\\nDas Flag '$short_id' im Dateinamen ist nicht gültig. Das Flag '$short_id' wird daher für diese Datei übersprungen.", false);
      return false;
    }

    # if no-options-selected flag
    # error if no-options-selected flag but additional flags are available
    if($option === self::default_flag_if_no_options_selected && count($filename_as_array) > 1){
      throw new Shema_Exception("Fehler beim Auslesen der Daten.\\nDas Flag '$short_id' im Dateinamen darf nur existieren, wenn kein Flag für diese Datei gewählt wurde. Das Flag '$short_id' wird für diese Datei übersprungen und die restlichen Flags und deren Daten bleiben erhalten.", false);
      return false;
    }

    # if option has duplicate in result
    if(in_array($option, $result_stored_options) === true){
      throw new Shema_Exception("Fehler beim Auslesen der Daten.\\nDas Flag '$short_id' ist doppelt vorhanden. Das zweite Flag '$short_id' wird für diese Datei übersprungen.", false);
      return false;
    }

    # if flag requires sub data, but no so sub data existing
    if(isset(self::array_ui_data_key_sub_data[$option]) && strlen($filename_flag_part) <= 1) {
      throw new Shema_Exception("Fehler beim Auslesen der Daten.\\nDas Shema sieht für das Flag '$short_id' weitere Daten vor, doch im Dateinamen sind keine für dieses Flag vorhanden. Das Flag '$short_id' wird daher für diese Datei übersprungen.", false);
      return false;
    }

    # if no so sub data required, but sub data is existing
    if(isset(self::array_ui_data_key_sub_data[$option]) === false && strlen($filename_flag_part) > 1){
      throw new Shema_Exception("Fehler beim Auslesen der Daten.\\nDas Shema sieht für das Flag '$short_id' keine weitere Daten vor, doch im Dateinamen sind für dieses Flag vorhanden weitere Daten vorhanden. Die weiteren Daten unter dem Flag '$short_id' werden für diese Datei ignoriert.", false);
      return true;
    }

    return true;
  }


  private static function convert_filename_to_data_option_install_in_overrides(string $filename_part, array &$array_result) : bool {
    return true;
  }

  private static function convert_filename_to_data_option_not_merge(string $filename_part, array &$array_result) : bool {
    return true;
  }


  // private static function convert_filename_to_data_option_install_in_packages(string $filename_part, array &$array_result) : bool {
  //   return true;
  // }


  private static function convert_filename_to_data_option_depends_on_content(string $filename_part, array &$array_result) : bool {
    $result = [];

    # extract short id from filename part (first letter)
    $short_id = substr($filename_part,0,1);

    # remove short id from filename part (first letter)
    $filename_part = substr($filename_part,1);

    # expand url through url shortener
    try {
      $value = Url_Shortener_API_Handler::expand_url($filename_part);
    }
    catch(Exception $e){
      return false;
    }

    # explode filename part by ;
    # in case their're multiple url
    $array_value = explode(";",$value);

    # iterate through url list
    foreach($array_value as $value){
      # replace ; in string back to original character
      $result[] = str_replace("%3B",";",$value);
    }

    $key = current(self::array_ui_data_key_sub_data["option_depends_on_content"]);
    $array_result[$key] = $result;
    return true;
  }


  private static function convert_filename_to_data_option_depends_on_expansion(string $filename_part, array &$array_result) : bool {
    $short_id = substr($filename_part,0,1);
    $value_splited_as_array = array_unique(str_split(strtolower(substr($filename_part,1)),4));
    foreach($value_splited_as_array as $value){
      if(preg_match("/^ep(0[1-9]|10|11)|sp0[1-9]$/",$value) === 0){
        new Shema_Exception("Fehler beim Auslesen der Daten.\\nDer Wert '$value' für das Flag '$short_id' ist nicht gültig. Das Flag '$short_id' wird daher für diese Datei übersprungen.", false);
        return false;
      }
    }
    $key = current(self::array_ui_data_key_sub_data["option_depends_on_expansion"]);
    $array_result[$key] = $value_splited_as_array;
    return true;
  }


  private static function convert_filename_to_data_option_is_essential(string $filename_part, array &$array_result) : bool {
    return true;
  }


  private static function convert_filename_to_data_option_is_default_replacement(string $filename_part, array &$array_result) : bool {
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
    foreach($sub_data as $sub_data_value_array){
      if(is_array($sub_data_value_array) === true){
        foreach($sub_data_value_array as $sub_data_value){
          printf(self::string_ui_format, $sub_data_value);
        }
      }
      else {
        printf(self::string_ui_format, $sub_data_value_array);
      }
    }
  }


  # print filename shema input to ui
  public static function print_filename_shema_input_for_ui(int $index, string $different_ui_key_root = null, bool $is_required = false) : void {
    $sub_data_flag_depends_on_content_input_html = Sub_Data_Flag_Depends_On_Content::generate_filename_shema_input_for_ui($index, $different_ui_key_root, $is_required);
    $sub_data_flag_depends_on_expansion_input_html = Sub_Data_Flag_Depends_On_Expansion::generate_filename_shema_input_for_ui($index, $different_ui_key_root, $is_required);
    printf(self::input_shema_template, $index, ($different_ui_key_root === null ? Ui::ui_data_key_root : $different_ui_key_root), self::class, $sub_data_flag_depends_on_content_input_html, $sub_data_flag_depends_on_expansion_input_html, ($is_required === true ? "required" : ""));
  }


  # print filename shema search input to ui
  public static function print_filename_shema_search_input_for_ui(int $index) : void {
    $operand_select_option_html = Ui::generate_search_operand_select_options_ui(self::class);
    $additional_search_buttons = Ui::generate_additional_search_buttons_ui(self::class);
    $sub_data_flag_depends_on_content_input_html = Sub_Data_Flag_Depends_On_Content::generate_filename_shema_search_input_for_ui($index);
    $sub_data_flag_depends_on_expansion_input_html = Sub_Data_Flag_Depends_On_Expansion::generate_filename_shema_search_input_for_ui($index);
    printf(self::search_input_shema_template, $index, Ui::ui_search_data_key_root, self::class, $operand_select_option_html, $additional_search_buttons, $sub_data_flag_depends_on_content_input_html, $sub_data_flag_depends_on_expansion_input_html);
  }


  # get target path considering the conditions of this shema input
  public static function get_target_path_by_condition(array $data_for_one_filename, string $source_path) : array {
    $path_result = "";
    $success_heading = "";
    $error_heading = "";
    $path_base = File_Handler::get_path_home_directory().File_Handler::path_seperator."Documents".File_Handler::path_seperator."Electronic Arts".File_Handler::path_seperator."The Sims 3";
    $flag_value = $data_for_one_filename[current(self::array_ui_data_key)];
    if(in_array("option_install_in_overrides", $flag_value)){
      if(File_Handler::get_fileextension_from_path($source_path) !== "package"){
        $error_heading = "nur Package-Dateien können in den Mods/Overrides-Ordner verschoben werden.";
        $path_result = "";
      }
      else {
        $path_result = $path_base.File_Handler::path_seperator."Mods".File_Handler::path_seperator."Overrides";
      }
    }

    if(in_array("option_not_merge", $flag_value) === true){
      if(in_array("option_install_in_overrides", $flag_value) === false){
        $path_result = $path_base.File_Handler::path_seperator."Mods".File_Handler::path_seperator."Packages";
      }
      if(File_Handler::get_fileextension_from_path($source_path) !== "package"){
        $error_heading = "Package-Dateien können in den Mods/Packages-Ordner verschoben werden.";
      }
    }
    return [$path_result, $success_heading, $error_heading];
  }

}

?>