<?php

# interface for every shared filename-shema parent class
Interface I_Shared_Shema {

  # compare elements for search feature
  public function compare(string $search_for, array $search_in, string $search_key) : bool;

}