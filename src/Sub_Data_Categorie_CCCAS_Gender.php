<?php

# this class is only required for a clean structuring of the ui and filename data
# it's only for ment to be a sub class of Filename_Shema_Flag
abstract class Sub_Data_Categorie_CCCAS_Gender extends Compareable_Is_Operand implements I_Filename_Shema {

  public const array_ui_data_key = [
    self::class
  ];

  # input shema template for ui
  private const input_shema_template = '
  <div class="container_label_and_input sub_input option_cc_create_a_sim_sub_data_gender%1$d">
    <label for="option_cc_create_a_sim_sub_data_gender%1$d">Geschlecht</label>
    <select class="%3$s%1$d" name="%2$s[%1$d]['.self::class.'][]" id="option_cc_create_a_sim_sub_data_gender%1$d" required>
      <option value="" selected disabled>Auswählen</option>
      <option value="female">Weiblich</option>
      <option value="male">Männlich</option>
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
    <label for="option_cc_create_a_sim_sub_data_gender%1$d">Geschlecht</label>
    <select class="%3$s_operand%1$d %3$s%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]">
      %4$s
    </select>
    <select class="%3$s%1$d" name="%2$s[%1$d]['.self::class.'][]" id="option_cc_create_a_sim_sub_data_gender%1$d" required>
      <option value="" selected disabled>Auswählen</option>
      <option value="female">Weiblich</option>
      <option value="male">Männlich</option>
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

}