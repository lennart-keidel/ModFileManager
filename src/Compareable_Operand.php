<?php

abstract class Compareable_Operand implements I_Shared_Shema {

  # call callback function stored in shema class
  # compare two values in the context of the selected operand
  public static function search_compare(string $search_input_value, string $search_input_operand, string|array $value_to_compare, string $class_reference) : bool {
    $operand_array = $class_reference::get_search_operand();
    return $operand_array[$search_input_operand]["callable"]($search_input_value,$value_to_compare);
  }

}