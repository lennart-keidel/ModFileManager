<?php

abstract class Compareable_Text_Operand extends Compareable_Operand implements I_Shared_Shema {

  public static function get_search_operand() : array {
    return [
      "is" => [
        "text" => "ist",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return !preg_match("/^".preg_quote($value_to_compare, "/")."$/i",$search_input) ? false : true;
        }
      ],
      "is_not" => [
        "text" => "ist nicht",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return !preg_match("/^".preg_quote($value_to_compare, "/")."$/i",$search_input) ? true : false;
        }
      ],
      "contains" => [
        "text" => "enthält",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return stripos($value_to_compare, $search_input) === false ? false : true;
        }
      ],
      "contains_not" => [
        "text" => "enthält nicht",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return stripos($value_to_compare, $search_input) === false ? true : false;
        }
      ],
      "starts_with" => [
        "text" => "startet mit",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return !preg_match("/^".preg_quote($value_to_compare, "/")."/i",$search_input) ? false : true;
        }
      ],
      "ends_with" => [
        "text" => "endet mit",
        "callable" => function(string $search_input, string $value_to_compare) : bool {
          return !preg_match("/".preg_quote($value_to_compare, "/")."$/i",$search_input) ? false : true;
        }
      ],
    ];
  }

}