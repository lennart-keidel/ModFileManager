<?php

abstract class Compareable_Date_Operand implements I_Shared_Shema {

  public static function get_search_operand() : array {
    return [
      "before_date" => [
        "text" => "vor diesem Datum (älter)",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return (new DateTime($value_to_compare)) < (new DateTime($search_input));
        }
      ],
      "before_or_is_date" => [
        "text" => "vor diesem Datum oder genau dieses Datum (älter oder gleich)",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return (new DateTime($value_to_compare)) <= (new DateTime($search_input));
        }
      ],
      "is_date" => [
        "text" => "genau dieses Datum",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return (new DateTime($value_to_compare)) == (new DateTime($search_input));
        }
      ],
      "after_date" => [
        "text" => "nach diesem Datum (jünger)",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return (new DateTime($value_to_compare)) > (new DateTime($search_input));
        }
      ],
      "after_or_is_date" => [
        "text" => "nach diesem Datum oder genau dieses Datum (jünger oder gleich)",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return (new DateTime($value_to_compare)) >= (new DateTime($search_input));
        }
      ],
    ];
  }

}