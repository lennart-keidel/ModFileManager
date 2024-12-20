<?php

abstract class Filename_Shema_Categorie extends Compareable_Is_Operand implements I_Filename_Shema {

  public const array_ui_data_key = [
    self::class
  ];

  # string-delimiter to connect flag-segments in filename
  public const filename_sub_data_delimiter = "_";

  # format-string to use with printf to print in ui
  private const string_ui_format = "<span>%s</span>";

  # array with short id's of options
  # key: internal key for this value
  # value: short id
  # SHORT IDs CAN HAVE MAX 6 CHARACTERS
  private const array_option_id = [
    "option_core_mod" => "COR",
    "option_tuning" => "TUN",
    "option_script" => "SCR",
    "option_mod_create_a_sim" => "MODCAS",
    "option_cc_create_a_sim" => "CCCAS",
    "option_cc_script" => "CCSCR",
    "option_cc_buy" => "CCBUY",
    "option_cc_build" => "CCBUI",
    "option_cc_caw" => "CCCAW",
    "option_fix" => "FIX",
    "option_recategorizing" => "RECAT",
    "option_mod_tuning" => "MODTUN",
    "option_pattern" => "PATTN",
    "option_store" => "STORE",
    "option_music" => "MUSIC",
    "option_custom_animation" => "ANIMA",
    "option_lot" => "LOT",
    "option_household" => "HSHLD",
    "option_world" => "WORLD",
    "option_cas_sim" => "SIMCAS",
    "option_collection_file" => "COLEC",
    "option_pose" => "POSE",
    "option_camera_mod" => "CAMMOD",
    "option_other" => "OTH",
  ];

  # array of option-values and their keys for sub-content in ui-data
  # format: option-value => key or sub-content in ui-data
  public const array_ui_data_key_sub_data = [
    "option_cc_create_a_sim" => [
      0 => "Sub_Data_Categorie_CCCAS_Gender",
      1 => "Sub_Data_Categorie_CCCAS_Categorie",
    ],
    "option_cc_buy" => [
      0 => "Sub_Data_Categorie_CCBUY_Categorie",
    ],
    "option_cc_build" => [
      0 => "Sub_Data_Categorie_CCBUI_Categorie",
    ],
    "option_lot" => [
      0 => "Sub_Data_Categorie_Lot_Categorie",
    ],
    "option_pattern" => [
      0 => "Sub_Data_Categorie_Pattern_Categorie",
    ],
  ];

  # input shema template for ui
  private const input_shema_template = '
    <div class="container_label_and_input">
      <label for="'.self::class.'%1$d">Kategorie</label>
      <select class="%3$s%1$d" id="'.self::class.'%1$d" name="%2$s[%1$d]['.self::class.']" %10$s onclick="disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.self::class.'%1$d\', \'option_cc_create_a_sim\', \'option_cc_create_a_sim_sub_data_gender%1$d\');disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.self::class.'%1$d\', \'option_cc_create_a_sim\', \'option_cc_create_a_sim_sub_data_categorie%1$d\'); disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.self::class.'%1$d\', \'option_cc_buy\', \'option_cc_buy_sub_data_categorie%1$d\'); disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.self::class.'%1$d\', \'option_cc_build\', \'option_cc_build_sub_data_categorie%1$d\'); disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.self::class.'%1$d\', \'option_lot\', \'option_lot_sub_data_categorie%1$d\'); disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.self::class.'%1$d\', \'option_pattern\', \'option_pattern_sub_data_categorie%1$d\'); disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.self::class.'%1$d\', \'option_pattern\', \'option_pattern_sub_data_is_recolorable%1$d\');">
        <option value="" selected disabled>Auswählen</option>
        <optgroup label="CC">
          <option value="option_cc_buy">Custom Content für Kaufmodus</option>
          <option value="option_cc_build">Custom Content für Baumodus</option>
          <option value="option_cc_script">Custom Content mit eigenem Script/Funktion</option>
          <option value="option_cc_create_a_sim">Custom Content für CAS</option>
          <option value="option_pattern">Pattern</option>
          <option value="option_store">Store-Content</option>
          <option value="option_cc_caw">Custom Content für CAW</option>
        </optgroup>
        <optgroup label="Mod">
          <option value="option_tuning">Tuning</option>
          <option value="option_script">Script-Mod</option>
          <option value="option_fix">Fix</option>
          <option value="option_recategorizing">Rekategorizierung von Objekten</option>
          <option value="option_mod_create_a_sim">Slider, Skin, Mod oder anderes für CAS</option>
          <option value="option_core_mod">Core Mod</option>
          <option value="option_mod_tuning">Mod Tuning</option>
          <option value="option_music">Soundtrack oder Radio Musik</option>
          <option value="option_custom_animation">Custom Animation oder Animation Port</option>
        </optgroup>
        <optgroup label="Download">
          <option value="option_lot">Grundstück</option>
          <option value="option_household">Haushalt</option>
          <option value="option_world">Welt</option>
          <option value="option_cas_sim">gespeicherter Sim für CAS (SavedSims)</option>
          <option value="option_collection_file">Collection-Datei</option>
          <option value="option_pose">Pose</option>
          <option value="option_camera_mod">Kamera Mod</option>
        </optgroup>
        <option value="option_other">keine der anderen Kategorien</option>
      </select>
    </div>

    %4$s
    %5$s
    %6$s
    %7$s
    %8$s
    %9$s
  ';

  # input shema template for search ui
  private const search_input_shema_template = '
    <div class="container_label_and_input additional_input_root %3$s_root%1$d">
      <label for="'.self::class.'%1$d">Kategorie</label>
      <select class="%3$s_operand%1$d %3$s%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]">
        %4$s
      </select>
      <select class="%3$s%1$d" id="'.self::class.'%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" onclick="disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.self::class.'%1$d\', \'option_cc_create_a_sim\', \'option_cc_create_a_sim_sub_data_gender%1$d\'); disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.self::class.'%1$d\', \'option_cc_create_a_sim\', \'option_cc_create_a_sim_sub_data_categorie%1$d\'); disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.self::class.'%1$d\', \'option_cc_buy\', \'option_cc_buy_sub_data_categorie%1$d\'); disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.self::class.'%1$d\', \'option_cc_buy\', \'option_cc_buy_sub_data_sub_categorie%1$d\'); disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.self::class.'%1$d\', \'option_cc_build\', \'option_cc_build_sub_data_categorie%1$d\'); disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.self::class.'%1$d\', \'option_lot\', \'option_lot_sub_data_categorie%1$d\'); disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.self::class.'%1$d\', \'option_pattern\', \'option_pattern_sub_data_categorie%1$d\'); disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.self::class.'%1$d\', \'option_pattern\', \'option_pattern_sub_data_is_recolorable%1$d\');" required>
        <option value="" selected disabled>Auswählen</option>
        <optgroup label="CC">
          <option value="option_cc_buy">Custom Content für Kaufmodus</option>
          <option value="option_cc_build">Custom Content für Baumodus</option>
          <option value="option_cc_script">Custom Content mit eigenem Script/Funktion</option>
          <option value="option_cc_create_a_sim">Custom Content für CAS</option>
          <option value="option_pattern">Pattern</option>
          <option value="option_store">Store-Content</option>
          <option value="option_cc_caw">Custom Content für CAW</option>
        </optgroup>
        <optgroup label="Mod">
          <option value="option_tuning">Tuning</option>
          <option value="option_script">Script-Mod</option>
          <option value="option_fix">Fix</option>
          <option value="option_recategorizing">Rekategorizierung von Objekten</option>
          <option value="option_mod_create_a_sim">Slider, Skin, Mod oder anderes für CAS</option>
          <option value="option_core_mod">Core Mod</option>
          <option value="option_mod_tuning">Mod Tuning</option>
          <option value="option_music">Soundtrack oder Radio Musik</option>
          <option value="option_custom_animation">Custom Animation oder Animation Port</option>
        </optgroup>
        <optgroup label="Download">
          <option value="option_lot">Grundstück</option>
          <option value="option_household">Haushalt</option>
          <option value="option_world">Welt</option>
          <option value="option_cas_sim">gespeicherter Sim für CAS (SavedSims)</option>
          <option value="option_collection_file">Collection-Datei</option>
          <option value="option_pose">Pose</option>
          <option value="option_camera_mod">Kamera Mod</option>
        </optgroup>
        <option value="option_other">keine der anderen Kategorien</option>
      </select>
      %5$s
      %6$s
      %7$s
      %8$s
      %9$s
      %10$s
    </div>
  ';


  # if conditions are met, manipulate something in the input data
  public static function manipulate_ui_data(array $data_from_ui) : array {
    $ui_key_flag = current(Filename_Shema_Flag::array_ui_data_key);
    $ui_key_categorie = current(self::array_ui_data_key);
    $ui_key_sub_data_cc_buy = current(Sub_Data_Categorie_CCBUY_Categorie::array_ui_data_key);

    if(!isset($data_from_ui[$ui_key_categorie])){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nFehlender Schlüssel in POST-Request: '".$ui_key_categorie."'");
    }

    # if selected categorie is one of these
    # set flag "option_not_compress"
    if(in_array($data_from_ui[$ui_key_categorie], ["option_core_mod", "option_script", "option_mod_create_a_sim", "option_cc_script"])){
      if(array_key_exists($ui_key_flag, $data_from_ui)){
        if(!in_array("option_not_compress", $data_from_ui[$ui_key_flag])){
          $data_from_ui[$ui_key_flag][] = "option_not_compress";
        }
      }
      else {
        $data_from_ui[$ui_key_flag] = ["option_not_compress"];
      }
    }

    # if selected categorie is one of these
    # set flag "option_not_merge"
    if(in_array($data_from_ui[$ui_key_categorie], ["option_core_mod", "option_script", "option_mod_create_a_sim", "option_cc_script", "option_lot", "option_household", "option_world", "option_cas_sim", "option_collection_file"])){
      if(array_key_exists($ui_key_flag, $data_from_ui)){
        if(!in_array("option_not_merge", $data_from_ui[$ui_key_flag])){
          $data_from_ui[$ui_key_flag][] = "option_not_merge";
        }
      }
      else {
        $data_from_ui[$ui_key_flag] = ["option_not_merge"];
      }
    }

    # if selected categorie is fix
    # set flag "option_is_essential"
    if($data_from_ui[$ui_key_categorie] == "option_fix"){
      if(array_key_exists($ui_key_flag, $data_from_ui)){
        if(!in_array("option_is_essential", $data_from_ui[$ui_key_flag])){
          $data_from_ui[$ui_key_flag][] = "option_is_essential";
        }
      }
      else {
        $data_from_ui[$ui_key_flag] = ["option_is_essential"];
      }
    }


    # if selected categorie is "option_cc_buy" and Sub-Data-CC-Buy is "option_surfaces_counter"
    # set flag "option_not_merge"
    if($data_from_ui[$ui_key_categorie] === "option_cc_buy"){

      if(!isset($data_from_ui[$ui_key_sub_data_cc_buy])){
        throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nFehlender Schlüssel in POST-Request: '".$ui_key_sub_data_cc_buy."'");
      }

      if($data_from_ui[$ui_key_sub_data_cc_buy] === "option_surfaces_counter"){
        if(array_key_exists($ui_key_flag, $data_from_ui)){
          if(!in_array("option_not_merge", $data_from_ui[$ui_key_flag])){
            $data_from_ui[$ui_key_flag][] = "option_not_merge";
          }
        }
        else {
          $data_from_ui[$ui_key_flag] = ["option_not_merge"];
        }
      }
    }

    return $data_from_ui;
  }


  # convert data collected from ui to usable data for following process
  public static function convert_ui_data_to_data(array $data_from_ui) : array {

    # filter data for this schema from whole ui data
    $main_ui_key = current(self::array_ui_data_key);

    if(!isset($data_from_ui[$main_ui_key])){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nFehlender Schlüssel in POST-Request: '$main_ui_key'");
    }

    # filter data from main ui key
    $result = [
      $main_ui_key => $data_from_ui[$main_ui_key]
    ];

    # filter data from sub ui key
    foreach(self::array_ui_data_key_sub_data as $option_key => $sub_data_ui_key_array){
      foreach($sub_data_ui_key_array as $sub_data_ui_key){
        if(array_key_exists($sub_data_ui_key, $data_from_ui)){
          $result[$sub_data_ui_key] = $data_from_ui[$sub_data_ui_key];
        }
      }
    }

    return $result;
  }


  # convert data to filename part using this shema
  public static function convert_data_to_filename(array $data_converted) : string {

    # search ui-text-value and get key
    $main_ui_key = current(self::array_ui_data_key);
    $main_option_key = $data_converted[$main_ui_key];
    if(isset(self::array_option_id[$main_option_key]) === false){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nUngültiger Wert: ".$main_option_key);
    }

    $result = self::array_option_id[$main_option_key];

    foreach(self::array_ui_data_key_sub_data as $option_key_with_sub_data => $sub_data_class_name_array){
      if($main_option_key === $option_key_with_sub_data){
        foreach($sub_data_class_name_array as $sub_data_class_name){
          try {
            $sub_data = $sub_data_class_name::convert_ui_data_to_data($data_converted);
            $result .= self::filename_sub_data_delimiter.$sub_data_class_name::convert_data_to_filename($sub_data);
          }
          catch(Shema_Exception $e){}
        }
      }
    }

    # return short id of selected option
    return $result;
  }


  # reverse process: converting filename back to data
  public static function convert_filename_to_data(string $filename_part) : array {

    if(empty($filename_part)){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten. Leeren Dateinamen erhalten.");
    }

    $filename_splitted = explode(self::filename_sub_data_delimiter, $filename_part);

    # search for short id and get key
    $key = array_search($filename_splitted[0], self::array_option_id);
    if($key === false){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Wert '".$filename_splitted[0]."' ist für die Kategorie nicht valide.");
    }
    unset($filename_splitted[0]);

    $result = [current(self::array_ui_data_key) => $key];

    # if filename part contains sub data
    foreach(self::array_ui_data_key_sub_data as $option_key_with_sub_data => $sub_data_class_name_array){
      if($key === $option_key_with_sub_data){
        if(count($filename_splitted) !== count($sub_data_class_name_array)){
          throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nDer Wert '".$option_key_with_sub_data."' setzt weitere Sub-Daten voraus, die jedoch fehlen.");
        }
        foreach($sub_data_class_name_array as $sub_data_class_name){
          try {
            $result = array_merge($result, $sub_data_class_name::convert_filename_to_data(current($filename_splitted)));
            next($filename_splitted);
          }
          catch(Shema_Exception $e){}
        }
      }
    }

    # return array in format of original ui data
    return $result;
  }


  # print converted data from filename to ui
  public static function print_filename_data_for_ui(array $filename_data) : void {
    # print data from filename to ui by formated string
    printf(self::string_ui_format, current($filename_data));
  }


  # print filename shema input to ui
  public static function print_filename_shema_input_for_ui(int $index, string $different_ui_key_root = null, bool $is_required = true) : void {
    $sub_data_cccas_gender = Sub_Data_Categorie_CCCAS_Gender::generate_filename_shema_input_for_ui($index, $different_ui_key_root, $is_required);
    $sub_data_cccas_categorie = Sub_Data_Categorie_CCCAS_Categorie::generate_filename_shema_input_for_ui($index, $different_ui_key_root, $is_required);
    $sub_data_ccbuy_categorie = Sub_Data_Categorie_CCBUY_Categorie::generate_filename_shema_input_for_ui($index, $different_ui_key_root, $is_required);
    $sub_data_ccbui_categorie = Sub_Data_Categorie_CCBUI_Categorie::generate_filename_shema_input_for_ui($index, $different_ui_key_root, $is_required);
    $sub_data_lot_categorie = Sub_Data_Categorie_Lot_Categorie::generate_filename_shema_input_for_ui($index, $different_ui_key_root, $is_required);
    $sub_data_pattern_categorie = Sub_Data_Categorie_Pattern_Categorie::generate_filename_shema_input_for_ui($index, $different_ui_key_root, $is_required);
    printf(self::input_shema_template, $index, ($different_ui_key_root === null ? Ui::ui_data_key_root : $different_ui_key_root), self::class, $sub_data_cccas_gender, $sub_data_cccas_categorie, $sub_data_ccbuy_categorie, $sub_data_ccbui_categorie, $sub_data_lot_categorie, $sub_data_pattern_categorie, ($is_required === true ? "required" : ""));
  }


  # print filename shema search input to ui
  public static function print_filename_shema_search_input_for_ui(int $index) : void {
    $operand_select_option_html = Ui::generate_search_operand_select_options_ui(self::class);
    // $additional_search_buttons = Ui::generate_additional_search_buttons_ui(self::class);
    $sub_data_cccas_gender = Sub_Data_Categorie_CCCAS_Gender::generate_filename_shema_search_input_for_ui($index);
    $sub_data_cccas_categorie = Sub_Data_Categorie_CCCAS_Categorie::generate_filename_shema_search_input_for_ui($index);
    $sub_data_ccbuy_categorie = Sub_Data_Categorie_CCBUY_Categorie::generate_filename_shema_search_input_for_ui($index);
    $sub_data_ccbui_categorie = Sub_Data_Categorie_CCBUI_Categorie::generate_filename_shema_search_input_for_ui($index);
    $sub_data_lot_categorie = Sub_Data_Categorie_Lot_Categorie::generate_filename_shema_search_input_for_ui($index);
    $sub_data_pattern_categorie = Sub_Data_Categorie_Pattern_Categorie::generate_filename_shema_search_input_for_ui($index);
    printf(self::search_input_shema_template, $index, Ui::ui_search_data_key_root, self::class, $operand_select_option_html, $sub_data_cccas_gender, $sub_data_cccas_categorie, $sub_data_ccbuy_categorie, $sub_data_ccbui_categorie, $sub_data_lot_categorie, $sub_data_pattern_categorie);
  }


  # get target path considering the conditions of this shema input
  public static function get_target_path_by_condition(array $data_for_one_filename, string $source_path) : array {
    $path_result = "";
    $success_heading = "";
    $error_heading = "";
    $path_base = File_Handler::get_path_home_directory().File_Handler::path_seperator."Documents".File_Handler::path_seperator."Electronic Arts".File_Handler::path_seperator."The Sims 3";
    $categorie_value = $data_for_one_filename[current(self::array_ui_data_key)];
    if(
    $categorie_value == "option_tuning"
    || $categorie_value == "option_mod_create_a_sim"
    || $categorie_value == "option_cc_create_a_sim"
    || $categorie_value == "option_cc_script"
    || $categorie_value == "option_cc_buy"
    || $categorie_value == "option_cc_build"
    || $categorie_value == "option_fix"
    || $categorie_value == "option_mod_tuning"
    || $categorie_value == "option_pattern"
    || $categorie_value == "option_store"
    || $categorie_value == "option_music"
    || $categorie_value == "option_camera_mod"
    || $categorie_value == "option_recategorizing"
    || $categorie_value == "option_custom_animation"
    ){
      $success_heading = "Refresh-Button in CC-Magic ausführen damit die neue Datei geladen wird.";
      $path_result = $path_base.File_Handler::path_seperator."Downloads";
    }

    elseif($categorie_value == "option_lot"){
      if(File_Handler::get_fileextension_from_path($source_path) === "sims3pack"){
        $error_heading = "Grundstücke im Sims3Pack-Dateiformart müssen über den Sims-3-Launcher <span style='text-decoration:underline;'>manuell</span> installiert werden.";
        $path_result = "";
      }
      if(File_Handler::get_fileextension_from_path($source_path) === "package"){
        $path_result = $path_base.File_Handler::path_seperator."Library";
      }
      else {
        $path_result = "";
      }
    }

    elseif($categorie_value == "option_household"){
      if(File_Handler::get_fileextension_from_path($source_path) === "sims3pack"){
        $error_heading = "Haushalte im Sims3Pack-Dateiformart müssen über den Sims-3-Launcher <span style='text-decoration:underline;'>manuell</span> installiert werden.";
        $path_result = "";
      }
      if(File_Handler::get_fileextension_from_path($source_path) === "package"){
        $path_result = $path_base.File_Handler::path_seperator."Library";
      }
      else {
        $path_result = "";
      }
    }

    elseif($categorie_value == "option_world"){
      if(File_Handler::get_fileextension_from_path($source_path) === "sims3pack"){
        $error_heading = "Welten müssen über den Sims-3-Launcher <span style='text-decoration:underline;'>manuell</span> installiert werden.";
      }
      else {
        $error_heading = "Welten können nur im Sims3Pack-Dateiformat und über den Sims-3-Launcher <span style='text-decoration:underline;'>manuell</span> installiert werden.";
      }
      $path_result = "";
    }

    elseif($categorie_value == "option_cas_sim"){
      if(File_Handler::get_fileextension_from_path($source_path) === "sim"){
        $path_result = $path_base.File_Handler::path_seperator."SavedSims";
      }
      else {
        $error_heading = "gespeicherte Sims für Create-A-Sim können nur im Package-Dateiformat installiert werden";
        $path_result = "";
      }
    }

    elseif($categorie_value == "option_script"){
      $path_result = $path_base.File_Handler::path_seperator."Mods".File_Handler::path_seperator."Packages";
    }

    elseif($categorie_value == "option_core_mod"){
      $path_result = $path_base.File_Handler::path_seperator."Mods".File_Handler::path_seperator."Packages";
    }

    elseif($categorie_value == "option_other"){
      $error_heading = "Die Datei kann nicht automatisch verschoben werden, weil die Kategorie 'keine der anderen Kategorien' ausgewählt wurde";
      $path_result = "";
    }

    elseif($categorie_value == "option_collection_file"){
      $path_result = $path_base.File_Handler::path_seperator."Collections".File_Handler::path_seperator."User";
    }

    # create target directory if not existing
    if(is_dir($path_result) === false){
      mkdir($path_result);
    }

    return [$path_result, $success_heading, $error_heading];
  }

}

?>