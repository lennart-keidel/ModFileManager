<?php

# this class is only required for a clean structuring of the ui and filename data
# it's only for ment to be a sub class of Filename_Shema_Flag
abstract class Sub_Data_Categorie_CCBUY_Categorie extends Compareable_Is_Operand implements I_Filename_Shema {

  public const array_ui_data_key = [
    self::class
  ];

  # array with short id's of options
  # key: internal key for this value
  # value: short id
  # SHORT IDs CAN HAVE MAX 6 CHARACTERS
  private const array_option_id = [
    // "option_plumbing" => "PL",
    // "option_appliances" => "AP",
    // "option_surfaces" => "SU",
    // "option_comfort" => "CO",
    // "option_electronics" => "EL",
    // "option_entertainment" => "EN",
    // "option_lighting" => "LI",
    // "option_decor" => "DE",
    // "option_storage" => "ST",
    // "option_kids" => "KI",
    // "option_vehicles" => "VE",
    // "option_pets" => "PE",
    // "option_other" => "OT",

    "option_deco_plant" => "DPLAN",
    "option_deco_picture" => "DPICT",
    "option_deco_mirror" => "DMIRR",
    "option_deco_curtain" => "DCURT",
    "option_deco_rug" => "DRUG",
    "option_deco_roof" => "DROOF",
    "option_deco_sculpture" => "DSCUL",
    "option_deco_misc" => "DMISC",

    "option_lighting_table" => "LTABL",
    "option_lighting_stand" => "LSTAN",
    "option_lighting_wall" => "LWALL",
    "option_lighting_ceiling" => "LCEIL",
    "option_lighting_outdoor" => "LOUTD",

    "option_comfort_bed" => "CBED",
    "option_comfort_dining_chair" => "CCHAI",
    "option_comfort_armchair" => "CARMC",
    "option_comfort_sofa" => "CSOFA",
    "option_comfort_lounge_chair" => "CLOUN",
    "option_comfort_misc" => "CMISC",

    "option_plumbing_sink" => "PSINK",
    "option_plumbing_toilet" => "PTOIL",
    "option_plumbing_shower_tub" => "PSHOW",
    "option_plumbing_misc" => "PLMIS",

    "option_storage_bookshelf" => "SBOOK",
    "option_storage_drawer" => "SDRAW",
    "option_storage_misc" => "SMISC",

    "option_surfaces_counter" => "SCOUN",
    "option_surfaces_cabinet" => "SCABI",
    "option_surfaces_dining_table" => "SDINI",
    "option_surfaces_end_table" => "SENDT",
    "option_surfaces_coffee_table" => "SCOFF",
    "option_surfaces_desk" => "SDESK",
    "option_surfaces_display" => "SDISP",
    "option_surfaces_misc" => "SUMSC",

    "option_appliances_large" => "ALARG",
    "option_appliances_small" => "ASMAL",
    "option_appliances_misc" => "AMISC",

    "option_electronics_tv" => "ETV",
    "option_electronics_computer" => "ECOMP",
    "option_electronics_audio" => "EAUDI",
    "option_electronics_misc" => "EMISC",

    "option_entertainment_sport" => "ESPOR",
    "option_entertainment_hobbys_and_skills" => "EHOBB",
    "option_entertainment_party" => "EPART",
    "option_entertainment_misc" => "EMISC",

    "option_childreen_furniture" => "CFURN",
    "option_childreen_toys" => "CTOYS",
    "option_childreen_misc" => "CMISC",

    "option_pet_cat" => "PCAT",
    "option_pet_dog" => "PDOG",
    "option_pet_horse" => "PHORS",
    "option_pet_misc" => "PMISC",

    "option_vehicle_car" => "VCAR",
    "option_vehicle_bike" => "VBIKE",
    "option_vehicle_boat" => "VBOAT",
    "option_vehicle_misc" => "VMISC",

    "option_stage_effects_light" => "SEFFE",
    "option_stage_props" => "SPROP",

    "option_debug_tomb_objects" => "DGTO",
    "option_debug_underwater_objects" => "DGUO",
    "option_debug_fish_spawners" => "DGFS",
    "option_debug_gardening_plants_and_seed_spawners" => "DGGS",
    "option_debug_rock_metal_gem_spawners" => "DGRS",
    "option_debug_insect_spawners" => "DGIS",
    "option_debug_misc" => "DGMISC",
  ];

  # input shema template for ui
  private const input_shema_template = '
  <div class="container_label_and_input sub_input option_cc_buy_sub_data_categorie%1$d">
    <label for="%3$s%1$d">Buy-Kategorie</label>
    <select class="%3$s%1$d option_cc_buy_sub_data_categorie%1$d" name="%2$s[%1$d]['.self::class.']" id="%3$s%1$d" %4$s>
      <option value="" selected disabled>Auswählen</option>
      <optgroup label="Sanitär">
        <option value="option_plumbing_sink">Waschbecken</option>
        <option value="option_plumbing_toilet">Toilette</option>
        <option value="option_plumbing_shower_tub">Dusche oder Wanne</option>
        <option value="option_plumbing_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Geräte">
        <option value="option_appliances_large">Große Geräte</option>
        <option value="option_appliances_small">kleine Geräte</option>
        <option value="option_appliances_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Oberflächen">
        <option value="option_surfaces_counter">Theke</option>
        <option value="option_surfaces_cabinet">Schrank</option>
        <option value="option_surfaces_dining_table">Esstisch</option>
        <option value="option_surfaces_end_table">Beistelltisch</option>
        <option value="option_surfaces_coffee_table">Kafeetisch</optioCOn>
        <option value="option_surfaces_desk">Schreibtisch</option>
        <option value="option_surfaces_display">Schaukästen</option>
        <option value="option_surfaces_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Komfort">
        <option value="option_comfort_bed">Bett</option>
        <option value="option_comfort_dining_chair">Esszimmerstuhl</option>
        <option value="option_comfort_armchair">Sessel</option>
        <option value="option_comfort_sofa">Sofa</option>
        <option value="option_comfort_lounge_chair">Liege</option>
        <option value="option_comfort_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Elektronik">
        <option value="option_electronics_tv">Fernseher</option>
        <option value="option_electronics_computer">Computer</option>
        <option value="option_electronics_audio">Audio</option>
        <option value="option_electronics_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Unterhaltung">
        <option value="option_entertainment_sport">Sport</option>
        <option value="option_entertainment_hobbys_and_skills">Hobbys und Fähigkeiten</option>
        <option value="option_entertainment_party">Party</option>
        <option value="option_entertainment_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Beleuchtung">
        <option value="option_lighting_table">Tischlampe</option>
        <option value="option_lighting_stand">Stehlampe</option>
        <option value="option_lighting_wall">Wandlampe</option>
        <option value="option_lighting_ceiling">Deckenlampe</option>
        <option value="option_lighting_outdoor">Außenbeleuchtung</option>
      </optgroup>
      <optgroup label="Deko">
        <option value="option_deco_plant">Pflanze</option>
        <option value="option_deco_picture">Bild oder Poster</option>
        <option value="option_deco_mirror">Spiegel</option>
        <option value="option_deco_curtain">Gardiene</option>
        <option value="option_deco_rug">Teppich</option>
        <option value="option_deco_roof">Dachdekoration</option>
        <option value="option_deco_sculpture">Skulptur</option>
        <option value="option_deco_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Schränke">
        <option value="option_storage_bookshelf">Bücherregal</option>
        <option value="option_storage_drawer">Kommode</option>
        <option value="option_storage_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Kinder">
        <option value="option_childreen_furniture">Kinder Möbel</option>
        <option value="option_childreen_toys">Spielzeug</option>
        <option value="option_childreen_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Fahrzeug">
        <option value="option_vehicle_car">Auto</option>
        <option value="option_vehicle_bike">Fahrrad</option>
        <option value="option_vehicle_boat">Boot</option>
        <option value="option_vehicle_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Tiere">
        <option value="option_pet_cat">Katzen</option>
        <option value="option_pet_dog">Hunde</option>
        <option value="option_pet_horse">Pferde</option>
        <option value="option_pet_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Bühne">
        <option value="option_stage_effects_light">Beleuchtung und Effekte</option>
        <option value="option_stage_props">Requisiten</option>
      </optgroup>
      <optgroup label="Debug">
        <option value="option_debug_tomb_objects">Gruft Objekte</option>
        <option value="option_debug_underwater_objects">Unterwasser Objekte</option>
        <option value="option_debug_fish_spawners">Fish Spawner</option>
        <option value="option_debug_gardening_plants_and_seed_spawners">Pflanzen und Samen Spawner</option>
        <option value="option_debug_rock_metal_gem_spawners">Stein, Metal und Edelstein Spawner</option>
        <option value="option_debug_insect_spawners">Insekten Spawner</option>
        <option value="option_debug_misc">Verschiedenes</option>
      </optgroup>
    </select>
    <script>
      document.addEventListener("DOMContentLoaded", function(){
        setTimeout(function(){
          disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.Filename_Shema_Categorie::class.'%1$d\', \'option_cc_buy\', \'option_cc_buy_sub_data_categorie%1$d\');
        },100);
      });
    </script>
  </div>
  ';


  # input shema template for search ui
  private const search_input_shema_template = '
  <div class="container_label_and_input sub_input option_cc_buy_sub_data_categorie%1$d">
    <label for="%3$s%1$d">Buy-Kategorie</label>
    <select class="%3$s_operand%1$d %3$s%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]">
      %4$s
    </select>
    <select class="%3$s%1$d option_cc_buy_sub_data_categorie%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" id="%3$s%1$d" required>
      <option value="" selected disabled>Auswählen</option>
      <optgroup label="Sanitär">
        <option value="option_plumbing_sink">Waschbecken</option>
        <option value="option_plumbing_toilet">Toilette</option>
        <option value="option_plumbing_shower_tub">Dusche oder Wanne</option>
        <option value="option_plumbing_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Geräte">
        <option value="option_appliances_large">Große Geräte</option>
        <option value="option_appliances_small">kleine Geräte</option>
        <option value="option_appliances_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Oberflächen">
        <option value="option_surfaces_counter">Theke</option>
        <option value="option_surfaces_cabinet">Schrank</option>
        <option value="option_surfaces_dining_table">Esstisch</option>
        <option value="option_surfaces_end_table">Beistelltisch</option>
        <option value="option_surfaces_coffee_table">Kafeetisch</optioCOn>
        <option value="option_surfaces_desk">Schreibtisch</option>
        <option value="option_surfaces_display">Schaukästen</option>
        <option value="option_surfaces_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Komfort">
        <option value="option_comfort_bed">Bett</option>
        <option value="option_comfort_dining_chair">Esszimmerstuhl</option>
        <option value="option_comfort_armchair">Sessel</option>
        <option value="option_comfort_sofa">Sofa</option>
        <option value="option_comfort_lounge_chair">Liege</option>
        <option value="option_comfort_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Elektronik">
        <option value="option_electronics_tv">Fernseher</option>
        <option value="option_electronics_computer">Computer</option>
        <option value="option_electronics_audio">Audio</option>
        <option value="option_electronics_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Unterhaltung">
        <option value="option_entertainment_sport">Sport</option>
        <option value="option_entertainment_hobbys_and_skills">Hobbys und Fähigkeiten</option>
        <option value="option_entertainment_party">Party</option>
        <option value="option_entertainment_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Beleuchtung">
        <option value="option_lighting_table">Tischlampe</option>
        <option value="option_lighting_stand">Stehlampe</option>
        <option value="option_lighting_wall">Wandlampe</option>
        <option value="option_lighting_ceiling">Deckenlampe</option>
        <option value="option_lighting_outdoor">Außenbeleuchtung</option>
      </optgroup>
      <optgroup label="Deko">
        <option value="option_deco_plant">Pflanze</option>
        <option value="option_deco_picture">Bild oder Poster</option>
        <option value="option_deco_mirror">Spiegel</option>
        <option value="option_deco_curtain">Gardiene</option>
        <option value="option_deco_rug">Teppich</option>
        <option value="option_deco_roof">Dachdekoration</option>
        <option value="option_deco_sculpture">Skulptur</option>
        <option value="option_deco_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Schränke">
        <option value="option_storage_bookshelf">Bücherregal</option>
        <option value="option_storage_drawer">Kommode</option>
        <option value="option_storage_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Kinder">
        <option value="option_childreen_furniture">Kinder Möbel</option>
        <option value="option_childreen_toys">Spielzeug</option>
        <option value="option_childreen_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Fahrzeug">
        <option value="option_vehicle_car">Auto</option>
        <option value="option_vehicle_bike">Fahrrad</option>
        <option value="option_vehicle_boat">Boot</option>
        <option value="option_vehicle_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Tiere">
        <option value="option_pet_cat">Katzen</option>
        <option value="option_pet_dog">Hunde</option>
        <option value="option_pet_horse">Pferde</option>
        <option value="option_pet_misc">Verschiedenes</option>
      </optgroup>
      <optgroup label="Bühne">
        <option value="option_stage_effects_light">Beleuchtung und Effekte</option>
        <option value="option_stage_props">Requisiten</option>
      </optgroup>
      <optgroup label="Debug">
        <option value="option_debug_tomb_objects">Gruft Objekte</option>
        <option value="option_debug_underwater_objects">Unterwasser Objekte</option>
        <option value="option_debug_fish_spawners">Fish Spawner</option>
        <option value="option_debug_gardening_plants_and_seed_spawners">Pflanzen und Samen Spawner</option>
        <option value="option_debug_rock_metal_gem_spawners">Stein, Metal und Edelstein Spawner</option>
        <option value="option_debug_insect_spawners">Insekten Spawner</option>
        <option value="option_debug_misc">Verschiedenes</option>
      </optgroup>
    </select>
    <script>
      document.addEventListener("DOMContentLoaded", function(){
        setTimeout(function(){
          disable_and_hide_input_by_class_name_if_source_element_is_not_selected(\''.Filename_Shema_Categorie::class.'%1$d\', \'option_cc_buy\', \'option_cc_buy_sub_data_categorie%1$d\');
        },100);
      });
    </script>
  </div>
  ';


  # if conditions are met, manipulate something in the input data
  public static function manipulate_ui_data(array $data_from_ui) : array {
    return $data_from_ui;
  }


  # print filename shema input to ui
  public static function print_filename_shema_input_for_ui(int $index, string $different_ui_key_root = null, bool $is_required = true) : void {
    printf(self::input_shema_template, $index, ($different_ui_key_root === null ? Ui::ui_data_key_root : $different_ui_key_root), self::class, ($is_required === true ? "required" : ""));
  }


  # generate filename shema input to ui
  # return html string
  public static function generate_filename_shema_input_for_ui(int $index, string $different_ui_key_root = null, bool $is_required = true) : string {
    return sprintf(self::input_shema_template, $index, ($different_ui_key_root === null ? Ui::ui_data_key_root : $different_ui_key_root), self::class, ($is_required === true ? "required" : ""));
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