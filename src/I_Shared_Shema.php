<?php

# interface for every shared filename-shema parent class
Interface I_Shared_Shema {

  # compare elements for search feature
  public static function get_search_operand() : array;

}