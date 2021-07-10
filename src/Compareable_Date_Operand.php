<?php

abstract class Compareable_Date_Operand implements I_Shared_Shema {

  public static function get_search_operand() : array {
    return [
      "before_date" => [
        "text" => "&lt;",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return (new DateTime($value_to_compare)) < (new DateTime($search_input));
        }
      ],
      "before_or_is_date" => [
        "text" => "&lt;=",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return (new DateTime($value_to_compare)) <= (new DateTime($search_input));
        }
      ],
      "after_date" => [
        "text" => "&gt;=",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return (new DateTime($value_to_compare)) > (new DateTime($search_input));
        }
      ],
      "after_or_is_date" => [
        "text" => "&gt;",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return (new DateTime($value_to_compare)) >= (new DateTime($search_input));
        }
      ],
      "is_date" => [
        "text" => "=",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return (new DateTime($value_to_compare)) == (new DateTime($search_input));
        }
      ],
    ];
  }

}