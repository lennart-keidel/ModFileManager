<?php

class Ui {

  # format-string to use with printf to print in ui
  private const input_shema_template_original_filename = '
    <input type="hidden" name="files[%1$d][originale_filename]" value="%2$s">
  ';

  private const input_shema_template_categorie = '
    <label for="select_shema_categorie%1$d">Kategorie</label>
    <select id="select_shema_categorie%1$d" name="files[%1$d][select_shema_categorie]">
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
        <option value="option_script">Script-Mod</option>
        <option value="option_mod_create_a_sim">Slider oder Mod für Create-A-Sim</option>
        <option value="option_core_mod">Core Mod</option>
      </optgroup>
      <option value="option_other">keine der anderen Kategorien</option>
    </select>
  ';

  private const input_shema_template_description = '
    <label for="text_shema_description%1$d">Beschreibung</label>
    <input id="text_shema_description%1$d" type="text" name="files[%1$d][text_shema_description]">
  ';

  private const input_shema_template_link = '
    <label for="url_shema_link%1$d">Link zum Mod, CC</label>
    <input id="url_shema_link%1$d" type="url" name="files[%1$d][url_shema_link]">
  ';

  private const input_shema_template_installation_date = '
    <label for="date_shema_installation_date%1$d">Installationsdatum</label>
    <input id="date_shema_installation_date%1$d" type="date" name="files[%1$d][date_shema_installation_date]">
  ';

  private const input_shema_template_patch_level = '
    <label for="select_shema_patch_level%1$d">Patch-Level</label>
    <select id="select_shema_patch_level%1$d" name="files[%1$d][select_shema_patch_level]" required>
      <option value="" selected disabled>Auswählen</option>
      <option value="1.69">1.69</option>
      <option value="1.67">1.67</option>
      <option value="1.66">1.66</option>
    </select>
  ';

  private const input_shema_template_flag = '
  <input type="checkbox" name="files[%1$d][checkbox_shema_flag][]" id="option_install_in_overrides%1$d" value="option_install_in_overrides">
  <label for="option_install_in_overrides%1$d">muss in Overrides-Ordner installiert werden</label>

  <input type="checkbox" name="files[%1$d][checkbox_shema_flag][]" id="option_install_in_packages%1$d" value="option_install_in_packages">
  <label for="option_install_in_packages%1$d">muss in Packages-Ordner installiert werden</label>

  <input type="checkbox" name="files[%1$d][checkbox_shema_flag][]" id="option_depends_on_content%1$d" value="option_depends_on_content">
  <label for="option_depends_on_content%1$d">abhängig von anderem Mod, CC, Store oder ähnlichem</label>

  <input disabled-and-hidden-until="[\'checked\',\'option_depends_on_content%1$d\']" id="url_flag_data_depends_on_content%1$d" type="url" name="files[%1$d][url_flag_data_depends_on_content]">
  <label disabled-and-hidden-until="[\'checked\',\'option_depends_on_content%1$d\']" for="url_flag_data_depends_on_content%1$d">Link zum Mod, CC von dem dieser Mod, CC abhängig ist</label>

  <input type="checkbox" name="files[%1$d][checkbox_shema_flag][]" id="option_depends_on_expansion%1$d" value="option_depends_on_expansion">
  <label for="option_depends_on_expansion%1$d">abhängig von Erweiterungspack oder Accessoirepack</label>

    <label disabled-and-hidden-until="[\'checked\',\'option_depends_on_expansion%1$d\']" for="select_flag_data_depends_on_expansion%1$d">Erweiterung von dem dieser Mod, CC abhängig ist</label>
    <select disabled-and-hidden-until="[\'checked\',\'option_depends_on_expansion%1$d\']" id="select_flag_data_depends_on_expansion%1$d" name="files[%1$d][select_flag_data_depends_on_expansion]">
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
        <option value="sp02">Gib Gas-Luxus Accessoires</option>
        <option value="sp03">Design Garten Accessoires</option>
        <option value="sp04">Stadt Accessoires</option>
        <option value="sp05">Traumsuite Accessoires</option>
        <option value="sp06">Katy Perry Süße Welt</option>
        <option value="sp07">Diesel Accessoires</option>
        <option value="sp08">70er, 80er & 90er Accessoires</option>
        <option value="sp09">Movie Accessoires</option>
      </optgroup>
    </select>

    <input type="checkbox" name="files[%1$d][checkbox_shema_flag][]" id="option_is_essential%1$d" value="option_is_essential">
    <label for="option_is_essential%1$d">gehört zu den absolut wichtigsten Mods/CC, die immer installiert sein sollen</label>
  ';

  private const template_error_message = "<javascript>alert(%s)</javascript>";

  private static $out_input_shema_index = 0;

  # print error message as js alert
  public static function set_error(string $message) : void {
    if(!empty($message)){
      printf(Ui::template_error_message, $message);
    }
  }


  public static function out_input_shema(string $shema_class_name) : void {

    # error if shema name not existing
    if(array_search($shema_class_name, Main::shema_order_global) === false){
      throw new Shema_Exception("Fehler beim generieren der UI. Shema-Klasse '$shema_class_name' ist nicht vorhanden.");
    }

    $shema_class_name = strtolower($shema_class_name);
    printf(constant("Ui::input_shema_template_$shema_class_name"), Ui::$out_input_shema_index);

  }


  public static function out_search_by_shema_interface() : void {
    // echo "<select name=search[""]>";
    // echo "<option selected disabled value=''>Auswählen</option>";
    foreach(Main::shema_order_global as $shema_id){
      $shema_id = strtolower($shema_id);
      // printf('<option value="%1$s">%2$s</option>', strtolower($shema_id), str_replace("_"," ",$shema_id));
    }
    // echo "</select>";
  }



}

?>