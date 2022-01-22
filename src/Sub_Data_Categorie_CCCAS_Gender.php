<?php

# this class is only required for a clean structuring of the ui and filename data
# it's only for ment to be a sub class of Filename_Shema_Flag
abstract class Sub_Data_Categorie_CCCAS_Gender extends Compareable_Is_Operand implements I_Filename_Shema {

  public const array_ui_data_key = [
    self::class
  ];

  # array with short id's of options
  # key: internal key for this value
  # value: short id
  # SHORT IDs CAN HAVE MAX 6 CHARACTERS
  private const array_option_id = [
    "option_elder_female" => "EF",
    "option_elder_male" => "EM",
    "option_elder_unisex" => "EU",
    "option_adult_female" => "AF",
    "option_adult_male" => "AM",
    "option_adult_unisex" => "AU",
    "option_teenager_female" => "TF",
    "option_teenager_male" => "TM",
    "option_teenager_unisex" => "TU",
    "option_child_female" => "CF",
    "option_child_male" => "CM",
    "option_child_unisex" => "CU",
    "option_toddler_female" => "DF",
    "option_toddler_male" => "DM",
    "option_toddler_unisex" => "DU",
    "option_baby_female" => "BF",
    "option_baby_male" => "BM",
    "option_baby_unisex" => "BU",
    "option_multiple" => "MLTPL",
  ];

  # input shema template for ui
  private const input_shema_template = '
  <div class="container_label_and_input sub_input option_cc_create_a_sim_sub_data_gender%1$d">
    <label for="%3$s%1$d">Geschlecht und Alter</label>
    <select class="%3$s%1$d option_cc_create_a_sim_sub_data_gender%1$d" name="%2$s[%1$d]['.self::class.']" id="%3$s%1$d" required>
      <option value="" selected disabled>Auswählen</option>
      <optgroup label="Senioren">
        <option value="option_elder_female">Weiblich</option>
        <option value="option_elder_male">Männlich</option>
        <option value="option_elder_unisex">Unisex</option>
      </optgroup>
      <optgroup label="Erwachsene">
        <option value="option_adult_female">Weiblich</option>
        <option value="option_adult_male">Männlich</option>
        <option value="option_adult_unisex">Unisex</option>
      </optgroup>
      <optgroup label="Teenager">
        <option value="option_teenager_female">Weiblich</option>
        <option value="option_teenager_male">Männlich</option>
        <option value="option_teenager_unisex">Unisex</option>
      </optgroup>
      <optgroup label="Kinder">
        <option value="option_child_female">Weiblich</option>
        <option value="option_child_male">Männlich</option>
        <option value="option_child_unisex">Unisex</option>
      </optgroup>
      <optgroup label="Kleinkinder">
        <option value="option_toddler_female">Weiblich</option>
        <option value="option_toddler_male">Männlich</option>
        <option value="option_toddler_unisex">Unisex</option>
      </optgroup>
      <optgroup label="Baby">
        <option value="option_baby_female">Weiblich</option>
        <option value="option_baby_male">Männlich</option>
        <option value="option_baby_unisex">Unisex</option>
        </optgroup>
      <option value="option_multiple">Mehrere Optionen</option>
    </select>
    <script>
      document.addEventListener("DOMContentLoaded", function(){
        setTimeout(function(){
          disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.Filename_Shema_Categorie::class.'%1$d\', \'option_cc_create_a_sim\', \'option_cc_create_a_sim_sub_data_gender%1$d\');
        },100);
      });
    </script>
  </div>
  ';


  # input shema template for search ui
  private const search_input_shema_template = '
  <div class="container_label_and_input sub_input option_cc_create_a_sim_sub_data_gender%1$d">
    <label for="%3$s%1$d">Geschlecht</label>
    <select class="%3$s_operand%1$d %3$s%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]">
      %4$s
    </select>
    <select class="%3$s%1$d option_cc_create_a_sim_sub_data_gender%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" id="%3$s%1$d" required>
      <option value="" selected disabled>Auswählen</option>
      <optgroup label="Senioren">
        <option value="option_elder_female">Weiblich</option>
        <option value="option_elder_male">Männlich</option>
        <option value="option_elder_unisex">Unisex</option>
      </optgroup>
      <optgroup label="Erwachsene">
        <option value="option_adult_female">Weiblich</option>
        <option value="option_adult_male">Männlich</option>
        <option value="option_adult_unisex">Unisex</option>
      </optgroup>
      <optgroup label="Teenager">
        <option value="option_teenager_female">Weiblich</option>
        <option value="option_teenager_male">Männlich</option>
        <option value="option_teenager_unisex">Unisex</option>
      </optgroup>
      <optgroup label="Kinder">
        <option value="option_child_female">Weiblich</option>
        <option value="option_child_male">Männlich</option>
        <option value="option_child_unisex">Unisex</option>
      </optgroup>
      <optgroup label="Kleinkinder">
        <option value="option_toddler_female">Weiblich</option>
        <option value="option_toddler_male">Männlich</option>
        <option value="option_toddler_unisex">Unisex</option>
      </optgroup>
      <optgroup label="Baby">
        <option value="option_baby_female">Weiblich</option>
        <option value="option_baby_male">Männlich</option>
        <option value="option_baby_unisex">Unisex</option>
        </optgroup>
      <option value="option_multiple">Mehrere Optionen</option>
    </select>
    <script>
      document.addEventListener("DOMContentLoaded", function(){
        setTimeout(function(){
          disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.Filename_Shema_Categorie::class.'%1$d\', \'option_cc_create_a_sim\', \'option_cc_create_a_sim_sub_data_gender%1$d\');
        },100);
      });
    </script>
  </div>
  ';


  # print filename shema input to ui
  public static function print_filename_shema_input_for_ui(int $index) : void {
    printf(self::input_shema_template, $index, Ui::ui_data_key_root, self::class);
  }


  # generate filename shema input to ui
  # return html string
  public static function generate_filename_shema_input_for_ui(int $index) : string {
    return sprintf(self::input_shema_template, $index, Ui::ui_data_key_root, self::class);
  }


  # print filename shema search input to ui
  public static function print_filename_shema_search_input_for_ui(int $index) : void {
    $operand_select_option_html = Ui::generate_search_operand_select_options_ui(self::class);
    printf(self::search_input_shema_template, $index, Ui::ui_search_data_key_root, self::class, $operand_select_option_html);
  }


  # generate filename shema search input to ui
  # return html string
  public static function generate_filename_shema_search_input_for_ui(int $index) : string {
    $operand_select_option_html = Ui::generate_search_operand_select_options_ui(self::class);
    return sprintf(self::search_input_shema_template, $index, Ui::ui_search_data_key_root, self::class, $operand_select_option_html);
  }


  # get target path considering the conditions of this shema input
  public static function get_target_path_by_condition(array $data_for_one_filename, string $source_path) : array {
    $path_result = "";
    $success_heading = "";
    $error_heading = "";
    return [$path_result, $success_heading, $error_heading];
  }


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
  public static function convert_data_to_filename(array $data_converted) : string{
    $key = current($data_converted);
    if(isset(self::array_option_id[$key]) === false){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nFehlender Wert: ".$key);
    }
    return self::array_option_id[$key];
  }


  # reverse process: converting filename back to data
  public static function convert_filename_to_data(string $filename_part) : array{
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

}