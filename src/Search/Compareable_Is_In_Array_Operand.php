<?php

abstract class Compareable_Is_In_Array_Operand extends Compareable_Operand implements I_Shared_Shema {

  public static function get_search_operand() : array {
    return [
      "is" => [
        "text" => "ist",
        "callable" => function(string $search_input, array $value_to_compare) : bool {
          return in_array($search_input, $value_to_compare) === true;
        }
      ],
      "is_not" => [
        "text" => "ist nicht",
        "callable" => function(string $search_input, array $value_to_compare) : bool {
          return in_array($search_input, $value_to_compare) === false;
        }
      ]
    ];
  }

}