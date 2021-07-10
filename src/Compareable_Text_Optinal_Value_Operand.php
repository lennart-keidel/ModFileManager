<?php

abstract class Compareable_Text_Optinal_Value_Operand extends Compareable_Text_Operand implements I_Shared_Shema {

  # extend inheritted get_search_operand from Compareable_Text_Operand
  # with options to search for empty values
  # only valid, if input is optional
  public static function get_search_operand() : array {
    return array_merge(parent::get_search_operand(), [
        "is_empty" => [
          "text" => "ist leer",
          "callable" => function(string $search_input, string $value_to_compare) : bool {
            return empty($value_to_compare) === true;
          }
        ],
        "is_not_empty" => [
          "text" => "ist nicht leer",
          "callable" => function(string $search_input, string $value_to_compare) : bool {
            return empty($value_to_compare) === false;
          }
        ],
      ]
    );
  }

}