<?php

abstract class Filename_Shema_Categorie extends Compareable_Is_Operand implements I_Filename_Shema {

  public const array_ui_data_key = [
    self::class
  ];

  # format-string to use with printf to print in ui
  private const string_ui_format = "<span>%s</span>";

  # array with short id's of options
  # key: internal key for this value
  # value: short id
  # SHORT IDs CAN HAVE MAX 6 CHARACTERS
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
    "option_other" => "OTH",
    "option_fix" => "FIX",
    "option_mod_tuning" => "MODTUN",
  ];

  # input shema template for ui
  private const input_shema_template = '
    <div class="container_label_and_input">
      <label for="'.self::class.'%1$d">Kategorie</label>
      <select class="%3$s%1$d" id="'.self::class.'%1$d" name="%2$s[%1$d]['.self::class.']" required>
        <option value="" selected disabled>Auswählen</option>
        <optgroup label="CC">
          <option value="option_cc_buy">Custom Content Objekt für Kaufmodus</option>
          <option value="option_cc_build">Custom Content Objekt für Baumodus</option>
          <option value="option_cc_script">Custom Content Objekt mit eigenem Script/Funktion</option>
          <option value="option_cc_create_a_sim">Cutom Content für Create-A-Sim</option>
        </optgroup>
        <optgroup label="Mod">
          <option value="option_tuning">Tuning</option>
          <option value="option_default_replacemant">Default Replacemant</option>
          <option value="option_fix">Fix</option>
          <option value="option_script">Script-Mod</option>
          <option value="option_mod_create_a_sim">Slider oder Mod für Create-A-Sim</option>
          <option value="option_core_mod">Core Mod</option>
          <option value="option_mod_tuning">Mod Tuning</option>
        </optgroup>
        <option value="option_other">keine der anderen Kategorien</option>
      </select>
    </div>
  ';

  # input shema template for search ui
  private const search_input_shema_template = '
    <div class="container_label_and_input additional_input_root">
      <label for="'.self::class.'%1$d">Kategorie</label>
      <select class="%3$s_operand%1$d %3$s%1$d" id="'.self::class.'%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]">
        %4$s
      </select>
      <select class="%3$s%1$d" id="'.self::class.'%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" required>
        <option value="" selected disabled>Auswählen</option>
        <optgroup label="CC">
          <option value="option_cc_buy">Custom Content Objekt für Kaufmodus</option>
          <option value="option_cc_build">Custom Content Objekt für Baumodus</option>
          <option value="option_cc_script">Custom Content Objekt mit eigenem Script/Funktion</option>
          <option value="option_cc_create_a_sim">Cutom Content für Create-A-Sim</option>
        </optgroup>
        <optgroup label="Mod">
          <option value="option_tuning">Tuning</option>
          <option value="option_default_replacemant">Default Replacemant</option>
          <option value="option_fix">Fix</option>
          <option value="option_script">Script-Mod</option>
          <option value="option_mod_create_a_sim">Slider oder Mod für Create-A-Sim</option>
          <option value="option_core_mod">Core Mod</option>
          <option value="option_mod_tuning">Mod Tuning</option>
        </optgroup>
        <option value="option_other">keine der anderen Kategorien</option>
      </select>
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

    return [
      $data_from_ui[$key]
    ];
  }



  # convert data to filename part using this shema
  public static function convert_data_to_filename(array $data_converted) : string {

    # search ui-text-value and get key
    $key = current($data_converted);
    if(isset(self::array_option_id[$key]) === false){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nFehlender Wert: ".current($data_converted));
    }

    # return short id of selected option
    return self::array_option_id[$key];
  }


  # reverse process: converting filename back to data
  public static function convert_filename_to_data(string $filename_part) : array {

    if(empty($filename_part)){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten. Lehren Dateinamen erhalten.");
    }

    # search for short id and get key
    $key = array_search($filename_part, self::array_option_id);
    if($key === false){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Wert '$filename_part' ist für die Kategorie nicht valide.");
    }

    # return array in format of original ui data
    return [current(self::array_ui_data_key) => $key];
  }


  # print converted data from filename to ui
  public static function print_filename_data_for_ui(array $filename_data) : void {
    # print data from filename to ui by formated string
    printf(self::string_ui_format, current($filename_data));
  }


  # print filename shema input to ui
  public static function print_filename_shema_input_for_ui(int $index) : void {
    printf(self::input_shema_template, $index, Ui::ui_data_key_root, self::class);
  }


  # print filename shema search input to ui
  public static function print_filename_shema_search_input_for_ui(int $index) : void {
    $operand_select_option_html = Ui::generate_search_operand_select_options_ui(self::class);
    $additional_search_buttons = Ui::generate_additional_search_buttons_ui(self::class);
    printf(self::search_input_shema_template, $index, Ui::ui_search_data_key_root, self::class, $operand_select_option_html, $additional_search_buttons);
  }


  # get target path considering the conditions of this shema input
  public static function get_target_path_by_condition(array $data_for_one_filename) : string {
    Ui::print_error("jey");
    return "C:\Users\U\Desktop";
  }

}

?>