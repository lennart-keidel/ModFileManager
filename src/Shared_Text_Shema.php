<?php

abstract class Shared_Text_Shema implements I_Shared_Shema {

  const search_input_operands_template = '
  <select class="%3$s_operand%1$d %3$s%1$d" id="text_shema_creator%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.'][text_shema_creator][]">
    <option value="contains">enthält</option>
    <option value="contains_not">enthält nicht</option>
    <option value="is">ist</option>
    <option value="is_not">ist nicht</option>
    <option value="starts_with">startet mit</option>
    <option value="ends_with">endet mit</option>
  </select>
  ';

  public function compare(string $search_for, array $search_in, string $search_key) : bool {
    return $search_for === $search_in[$search_key];
  }

}