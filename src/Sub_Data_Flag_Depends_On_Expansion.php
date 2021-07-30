<?php

# this class is only required for a clean structuring of the ui and filename data
# it's only for ment to be a sub class of Filename_Shema_Flag
abstract class Sub_Data_Flag_Depends_On_Expansion extends Compareable_Is_Operand implements I_Filename_Shema {

  public const array_ui_data_key = [
    self::class
  ];

  # input shema template for ui
  private const input_shema_template = '
  <div class="option_depends_on_expansion%1$d container_label_and_input sub_input">
    <label class="option_depends_on_expansion%1$d" for="'.self::class.'%1$d">Erweiterung von dem dieser Mod, CC abhängig ist</label>
    <select class="option_depends_on_expansion%1$d %3$s%1$d" id="'.self::class.'%1$d" name="%2$s[%1$d]['.self::class.']" required disabled>
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
  ';


  # input shema template for search ui
  private const search_input_shema_template = '
  <div class="option_depends_on_expansion%1$d container_label_and_input sub_input">
    <label class="option_depends_on_expansion%1$d" for="'.self::class.'%1$d">Erweiterung von dem dieser Mod, CC abhängig ist</label>
    <select class="option_depends_on_expansion%1$d %3$s_operand%1$d %3$s%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]">
      %4$s
    </select>
    <select class="option_depends_on_expansion%1$d %3$s%1$d" id="'.self::class.'%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" required disabled>
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

}