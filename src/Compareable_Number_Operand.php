<?php

abstract class Compareable_Number_Operand extends Compareable_Operand implements I_Shared_Shema {

  # important: dont use type strict comparison
  # so can string-numbers be compared as well
  public static function get_search_operand() : array {
    return [
      "equal_to_number" => [
        "text" => "=",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return $value_to_compare == $search_input;
        }
      ],
      "lower_than_number" => [
        "text" => "&lt;",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return $value_to_compare < $search_input;
        }
      ],
      "lower_equal_number" => [
        "text" => "&lt;=",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return $value_to_compare <= $search_input;
        }
      ],
      "higher_than_number" => [
        "text" => "&gt;",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return $value_to_compare > $search_input;
        }
      ],
      "higher_equal_number" => [
        "text" => "&gt;=",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return $value_to_compare >= $search_input;
        }
      ],
    ];
  }

}