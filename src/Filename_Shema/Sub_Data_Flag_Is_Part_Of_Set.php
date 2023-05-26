<?php

# this class is only required for a clean structuring of the ui and filename data
# it's only for ment to be a sub class of Filename_Shema_Flag
abstract class Sub_Data_Flag_Is_Part_Of_Set extends Compareable_Is_In_Array_Operand implements I_Filename_Shema {

  public const array_ui_data_key = [
    self::class
  ];

  # input shema template for ui
  private const input_shema_template = '
  <div class="sub_data_option_is_part_of_set%1$d additional_input_root container_label_and_input sub_input">
    <label class="sub_data_option_is_part_of_set%1$d" for="'.self::class.'%1$d">Name des Set\'s</label>
    <input class="sub_data_option_is_part_of_set%1$d %3$s%1$d" id="'.self::class.'%1$d" type="text" name="%2$s[%1$d]['.self::class.'][]" required disabled>
    %5$s
  </div>
  ';


  # input shema template for search ui
  private const search_input_shema_template = '
  <div class="sub_data_option_is_part_of_set%1$d additional_input_root container_label_and_input sub_input">
    <label class="sub_data_option_is_part_of_set%1$d" for="'.self::class.'%1$d">Name des Set\'s</label>
    <select class="sub_data_option_is_part_of_set%1$d %3$s_operand%1$d %3$s%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]" disabled>
      %4$s
    </select>
    <input class="sub_data_option_is_part_of_set%1$d %3$s%1$d" id="'.self::class.'%1$d" type="text" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" required disabled>
  </div>
  ';


  # print filename shema input to ui
  public static function print_filename_shema_input_for_ui(int $index, string $different_ui_key_root = null, bool $is_required = true) : void {
    printf(self::input_shema_template, $index, ($different_ui_key_root === null ? Ui::ui_data_key_root : $different_ui_key_root), self::class, ($is_required === true ? "required" : ""));
  }


  # generate filename shema input to ui
  # return html string
  public static function generate_filename_shema_input_for_ui(int $index, string $different_ui_key_root = null, bool $is_required = true) : string {
    $additional_search_buttons = Ui::generate_additional_search_buttons_ui(self::class);
    return sprintf(self::input_shema_template, $index, ($different_ui_key_root === null ? Ui::ui_data_key_root : $different_ui_key_root), self::class, ($is_required === true ? "required" : ""), $additional_search_buttons);
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