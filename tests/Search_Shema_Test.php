<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertIsNotResource;
use function PHPUnit\Framework\assertTrue;

# test class
class Search_Shema_Test extends TestCase {

  private static $search_input1, $search_input2, $search_input3, $search_input4, $filename_data_for_one_file1, $filename_data_for_one_file2, $filename_data_for_one_file3, $filename_data_for_one_file4 = [];


  # set up ui data with realistic data
  protected function setUp() : void {




    ## ---------------- DISABLE TESTS IN THIS FILE -----------------------
    // $this->markTestSkipped("Dieser Test ist deaktiviert.");




  }

  public static function setUpBeforeClass() : void {
    self::$search_input1 = [
      "search_shema_connector" => "or",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Categorie" => [ "is", ],
        "Filename_Shema_Description" => [ "is", ],
        "Filename_Shema_Link" => [ "is", ],
        "Filename_Shema_Installation_Date" => [ "is_date", ],
        "Flag_Data_Option_Depends_On_Expansion" => [ "is", ],
        "Filename_Shema_Flag" => [ "is", "is", ],
        "Flag_Data_Option_Depends_On_Content" => [ "is", ],
        "Filename_Shema_Long_Description" => [ "is", ],
        "Filename_Shema_Creator" => [ "is", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Categorie" => [ "option_tuning", ],
        "Filename_Shema_Description" => [ "somtehing to do with this", ],
        "Filename_Shema_Link" => [ "https://modthesims.info/", ],
        "Filename_Shema_Installation_Date" => [ "2020-10-29", ],
        "Flag_Data_Option_Depends_On_Expansion" => [ "ep01", ],
        "Filename_Shema_Flag" => [
          "option_depends_on_content",
          "option_depends_on_expansion"
        ],
        "Flag_Data_Option_Depends_On_Content" => [ "https://modthesims.info/", ],
        "Filename_Shema_Long_Description" => [ "A Longer Description", ],
        "Filename_Shema_Creator" => [ "Nraas", ],
      ],
    ];

    self::$search_input2 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Categorie" => [ "is", ],
        "Filename_Shema_Description" => [ "is", ],
        "Filename_Shema_Link" => [ "is", ],
        "Filename_Shema_Installation_Date" => [ "is_date", ],
        "Flag_Data_Option_Depends_On_Expansion" => [ "is", ],
        "Filename_Shema_Flag" => [ "is", "is", ],
        "Flag_Data_Option_Depends_On_Content" => [ "is", ],
        "Filename_Shema_Long_Description" => [ "is", ],
        "Filename_Shema_Creator" => [ "is", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Categorie" => [ "option_tuning", ],
        "Filename_Shema_Description" => [ "somtehing to do with this", ],
        "Filename_Shema_Link" => [ "https://modthesims.info/", ],
        "Filename_Shema_Installation_Date" => [ "2020-10-29", ],
        "Flag_Data_Option_Depends_On_Expansion" => [ "ep01", ],
        "Filename_Shema_Flag" => [
          "option_depends_on_content",
          "option_depends_on_expansion"
        ],
        "Flag_Data_Option_Depends_On_Content" => [ "https://modthesims.info/", ],
        "Filename_Shema_Long_Description" => [ "A Longer Description", ],
        "Filename_Shema_Creator" => [ "Nraas", ],
      ],
    ];

    self::$search_input3 = [
      "search_shema_connector" => "or",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Categorie" => [ "is", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Categorie" => [ "option_tuning", ],
      ],
    ];

    self::$search_input4 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Categorie" => [ "is", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Categorie" => [ "option_tuning", ],
      ],
    ];

    # every data matches search_input1 and search_input2
    self::$filename_data_for_one_file1 = [
      "Filename_Shema_Categorie" => "option_tuning",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "https://modthesims.info/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Flag_Data_Option_Depends_On_Expansion" => "ep01",
      "Filename_Shema_Flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion"
      ],
      "Flag_Data_Option_Depends_On_Content" => "https://modthesims.info/",
      "Filename_Shema_Long_Description" => "A Longer Description",
      "Filename_Shema_Creator" => "Nraas",
    ];

    # two data match search_input1 and search_input2
    self::$filename_data_for_one_file2 = [
      "Filename_Shema_Categorie" => "option_tuning",
      "Filename_Shema_Description" => "some other description",
      "Filename_Shema_Link" => "https://potato-ballad-sims.tumblr.com/post/asd",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Flag_Data_Option_Depends_On_Expansion" => "ep09",
      "Filename_Shema_Flag" => [
        "option_is_essential"
      ]
    ];

    # only one data matches search_input1 and search_input2
    self::$filename_data_for_one_file3 = [
      "Filename_Shema_Categorie" => "option_cc_buy",
      "Filename_Shema_Description" => "some other description",
      "Filename_Shema_Link" => "https://potato-ballad-sims.tumblr.com/post/asd",
      "Filename_Shema_Installation_Date" => "2020-11-12",
      "Flag_Data_Option_Depends_On_Expansion" => "ep01",
      "Filename_Shema_Flag" => [
        "option_is_essential"
      ]
    ];

    # no data matches search_input1 and search_input2
    self::$filename_data_for_one_file4 = [
      "Filename_Shema_Categorie" => "option_cc_buy",
      "Filename_Shema_Description" => "some other description",
      "Filename_Shema_Link" => "https://potato-ballad-sims.tumblr.com/post/asd",
      "Filename_Shema_Installation_Date" => "2020-11-12",
      "Flag_Data_Option_Depends_On_Expansion" => "ep11",
      "Filename_Shema_Flag" => [
        "option_is_essential"
      ]
    ];

  }


  public function test_check_if_filename_data_for_one_file_matches_search_input_with_or_connector() : void {
    Search_Shema::set_search_ui_data(self::$search_input1);
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_and_connector() : void {
    Search_Shema::set_search_ui_data(self::$search_input2);
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }


  public function test_check_if_filename_data_for_one_file_matches_search_input_with_or_connector_with_only_one_parameter_in_search_input() : void {
    Search_Shema::set_search_ui_data(self::$search_input3);
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_and_connector_with_only_one_parameter_in_search_input() : void {
    Search_Shema::set_search_ui_data(self::$search_input4);
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_filter_filename_data_by_search_input1_with_or_connector() : void {
    Search_Shema::set_search_ui_data(self::$search_input1);
    $filename_data_input = [
      Ui::ui_data_key_root => [
        self::$filename_data_for_one_file1,
        self::$filename_data_for_one_file2,
        self::$filename_data_for_one_file3,
        self::$filename_data_for_one_file4
      ]
    ];
    $filtered_filename_data_expected_output = [
      self::$filename_data_for_one_file1,
      self::$filename_data_for_one_file2,
      self::$filename_data_for_one_file3
    ];
    $filtered_filename_data = Search_Shema::filter_filename_data_by_search_input($filename_data_input);
    assertIsArray($filtered_filename_data);
    assertCount(3, $filtered_filename_data);
    assertEquals($filtered_filename_data_expected_output, $filtered_filename_data);
  }


  public function test_filter_filename_data_by_search_input2_with_and_connector() : void {
    Search_Shema::set_search_ui_data(self::$search_input2);
    $filename_data_input = [
      Ui::ui_data_key_root => [
        self::$filename_data_for_one_file1,
        self::$filename_data_for_one_file2,
        self::$filename_data_for_one_file3,
        self::$filename_data_for_one_file4
      ]
    ];
    $filtered_filename_data_expected_output = [
      self::$filename_data_for_one_file1
    ];
    $filtered_filename_data = Search_Shema::filter_filename_data_by_search_input($filename_data_input);
    assertIsArray($filtered_filename_data);
    assertCount(1, $filtered_filename_data);
    assertEquals($filtered_filename_data_expected_output, $filtered_filename_data);
  }


  public function test_filter_filename_data_by_search_input3_with_or_connector() : void {
    Search_Shema::set_search_ui_data(self::$search_input3);
    $filename_data_input = [
      Ui::ui_data_key_root => [
        self::$filename_data_for_one_file1,
        self::$filename_data_for_one_file2,
        self::$filename_data_for_one_file3,
        self::$filename_data_for_one_file4
      ]
    ];
    $filtered_filename_data_expected_output = [
      self::$filename_data_for_one_file1,
      self::$filename_data_for_one_file2
    ];
    $filtered_filename_data = Search_Shema::filter_filename_data_by_search_input($filename_data_input);
    assertIsArray($filtered_filename_data);
    assertCount(2, $filtered_filename_data);
    assertEquals($filtered_filename_data_expected_output, $filtered_filename_data);
  }


  public function test_filter_filename_data_by_search_input4_with_and_connector() : void {
    Search_Shema::set_search_ui_data(self::$search_input4);
    $filename_data_input = [
      Ui::ui_data_key_root => [
        self::$filename_data_for_one_file1,
        self::$filename_data_for_one_file2,
        self::$filename_data_for_one_file3,
        self::$filename_data_for_one_file4
      ]
    ];
    $filtered_filename_data_expected_output = [
      self::$filename_data_for_one_file1,
      self::$filename_data_for_one_file2
    ];
    $filtered_filename_data = Search_Shema::filter_filename_data_by_search_input($filename_data_input);
    assertIsArray($filtered_filename_data);
    assertCount(2, $filtered_filename_data);
    assertEquals($filtered_filename_data_expected_output, $filtered_filename_data);
  }

}

?>