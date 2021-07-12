<?php

# interface for every shared filename-shema parent class
Interface I_Shared_Shema {

  # compare elements for search feature
  public static function get_search_operand() : array;

  # call callback function stored in shema class
  # compare two values in the context of the selected operand
  public static function search_compare(string $search_input_value, string $search_input_operand, string|array $value_to_compare, string $class_reference) : bool;

}