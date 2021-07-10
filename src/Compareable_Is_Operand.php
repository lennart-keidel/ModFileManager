<?php

abstract class Compareable_Is_Operand implements I_Shared_Shema {

  public static function get_search_operand() : array {
    return [
      "is" => [
        "text" => "ist",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          var_dump($value_to_compare, $search_input, "");
          return $value_to_compare === $search_input;
        }
      ],
      "is_not" => [
        "text" => "ist nicht",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          var_dump($value_to_compare, $search_input, "");
          return $value_to_compare !== $search_input;
        }
      ]
    ];
  }

}