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

  private static $search_input1, $search_input2, $search_input3, $search_input4, $search_input5, $search_input6, $search_input7, $search_input8, $search_input9, $search_input10, $search_input11, $search_input12, $search_input13, $search_input14, $search_input15, $search_input16, $search_input17, $search_input18, $search_input19, $search_input20, $search_input21, $search_input22, $search_input23, $search_input24, $search_input25, $search_input26, $search_input27, $search_input28, $search_input29, $search_input30, $search_input31, $search_input32, $search_input33, $filename_data_for_one_file1, $filename_data_for_one_file2, $filename_data_for_one_file3, $filename_data_for_one_file4 = [];


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
        "Sub_Data_Flag_Depends_On_Expansion" => [ "is", ],
        "Filename_Shema_Flag" => [ "is", "is", ],
        "Sub_Data_Flag_Depends_On_Content" => [ "is", ],
        "Filename_Shema_Long_Description" => [ "is", ],
        "Filename_Shema_Creator" => [ "is", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Categorie" => [ "option_tuning", ],
        "Filename_Shema_Description" => [ "something to do with this", ],
        "Filename_Shema_Link" => [ "https://modthesims.info/", ],
        "Filename_Shema_Installation_Date" => [ "2020-10-29", ],
        "Sub_Data_Flag_Depends_On_Expansion" => [ "ep01", ],
        "Filename_Shema_Flag" => [
          "option_depends_on_content",
          "option_depends_on_expansion"
        ],
        "Sub_Data_Flag_Depends_On_Content" => [ "https://modthesims.info/", ],
        "Filename_Shema_Long_Description" => [ "A not existing Description", ],
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
        "Sub_Data_Flag_Depends_On_Expansion" => [ "is", ],
        "Filename_Shema_Flag" => [ "is", "is", ],
        "Sub_Data_Flag_Depends_On_Content" => [ "is", ],
        "Filename_Shema_Long_Description" => [ "is", ],
        "Filename_Shema_Creator" => [ "is", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Categorie" => [ "option_tuning", ],
        "Filename_Shema_Description" => [ "something to do with this", ],
        "Filename_Shema_Link" => [ "https://modthesims.info/", ],
        "Filename_Shema_Installation_Date" => [ "2020-10-29", ],
        "Sub_Data_Flag_Depends_On_Expansion" => [ "ep01", ],
        "Filename_Shema_Flag" => [
          "option_depends_on_content",
          "option_depends_on_expansion"
        ],
        "Sub_Data_Flag_Depends_On_Content" => [ "https://modthesims.info/", ],
        "Filename_Shema_Long_Description" => [ "A Longer Description", ],
        "Filename_Shema_Creator" => [ "Nraas", ],
      ],
    ];

    self::$search_input3 = [
      "search_shema_connector" => "and",
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

    self::$search_input5 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Categorie" => [ "is_not", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Categorie" => [ "option_tuning", ],
      ],
    ];

    self::$search_input6 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Description" => [ "is", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Description" => [ "something to do with this", ],
      ],
    ];

    self::$search_input7 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Description" => [ "is_not", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Description" => [ "something to do with this", ],
      ],
    ];

    self::$search_input8 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Description" => [ "contains", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Description" => [ "other", ],
      ],
    ];

    self::$search_input9 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Description" => [ "contains_not", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Description" => [ "other", ],
      ],
    ];

    self::$search_input10 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Description" => [ "starts_with", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Description" => [ "something", ],
      ],
    ];

    self::$search_input11 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Description" => [ "ends_with", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Description" => [ "description", ],
      ],
    ];

    self::$search_input12 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Patch_Level" => [ "equal_to_number", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Patch_Level" => [ "1.69", ],
      ],
    ];

    self::$search_input13 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Patch_Level" => [ "unequal_to_number", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Patch_Level" => [ "1.69", ],
      ],
    ];

    self::$search_input14 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Patch_Level" => [ "lower_than_number", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Patch_Level" => [ "1.69", ],
      ],
    ];

    self::$search_input15 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Patch_Level" => [ "lower_equal_number", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Patch_Level" => [ "1.67", ],
      ],
    ];

    self::$search_input16 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Patch_Level" => [ "higher_than_number", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Patch_Level" => [ "1.55", ],
      ],
    ];

    self::$search_input17 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Patch_Level" => [ "higher_equal_number", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Patch_Level" => [ "1.67", ],
      ],
    ];

    self::$search_input18 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Installation_Date" => [ "before_date", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Installation_Date" => [ "2020-10-31", ],
      ],
    ];

    self::$search_input19 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Installation_Date" => [ "before_or_is_date", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Installation_Date" => [ "2020-11-12", ],
      ],
    ];

    self::$search_input20 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Installation_Date" => [ "after_date", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Installation_Date" => [ "2020-10-31", ],
      ],
    ];

    self::$search_input21 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Installation_Date" => [ "after_or_is_date", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Installation_Date" => [ "2020-10-29", ],
      ],
    ];

    self::$search_input22 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Installation_Date" => [ "is_date", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Installation_Date" => [ "2020-11-12", ],
      ],
    ];

    self::$search_input23 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Long_Description" => [ "is_empty", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Long_Description" => [ "", ],
      ],
    ];

    self::$search_input24 = [
      "search_shema_connector" => "and",
      Ui::ui_search_data_key_operand_root => [
        "Filename_Shema_Long_Description" => [ "is_not_empty", ],
      ],
      Ui::ui_search_data_key_value_root => [
        "Filename_Shema_Long_Description" => [ "", ],
      ],
    ];

    # every data matches search_input1 and search_input2
    self::$filename_data_for_one_file1 = [
      "Filename_Shema_Categorie" => "option_tuning",
      "Filename_Shema_Description" => "something to do with this",
      "Filename_Shema_Link" => "https://modthesims.info/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Sub_Data_Flag_Depends_On_Expansion" => "ep01",
      "Filename_Shema_Flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion"
      ],
      "Sub_Data_Flag_Depends_On_Content" => "https://modthesims.info/",
      "Filename_Shema_Creator" => "Nraas",
      "Filename_Shema_Patch_Level" => "1.69",
      "Filename_Shema_Long_Description" => "A Longer Description",
    ];

    # two data match search_input1 and search_input2
    self::$filename_data_for_one_file2 = [
      "Filename_Shema_Categorie" => "option_tuning",
      "Filename_Shema_Description" => "some other description",
      "Filename_Shema_Link" => "https://potato-ballad-sims.tumblr.com/post/asd",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Sub_Data_Flag_Depends_On_Expansion" => "ep09",
      "Filename_Shema_Flag" => [
        "option_is_essential"
      ],
      "Filename_Shema_Patch_Level" => "1.69",
      "Filename_Shema_Long_Description" => "",
    ];

    # only one data matches search_input1 and search_input2
    self::$filename_data_for_one_file3 = [
      "Filename_Shema_Categorie" => "option_cc_buy",
      "Filename_Shema_Description" => "some other description",
      "Filename_Shema_Link" => "https://potato-ballad-sims.tumblr.com/post/asd",
      "Filename_Shema_Installation_Date" => "2020-11-12",
      "Sub_Data_Flag_Depends_On_Expansion" => "ep01",
      "Filename_Shema_Flag" => [
        "option_is_essential"
      ],
      "Filename_Shema_Patch_Level" => "1.67",
      "Filename_Shema_Long_Description" => "A Different Description",
    ];

    # no data matches search_input1 and search_input2
    self::$filename_data_for_one_file4 = [
      "Filename_Shema_Categorie" => "option_cc_buy",
      "Filename_Shema_Description" => "some other description",
      "Filename_Shema_Link" => "https://potato-ballad-sims.tumblr.com/post/asd",
      "Filename_Shema_Installation_Date" => "2020-11-12",
      "Sub_Data_Flag_Depends_On_Expansion" => "ep11",
      "Filename_Shema_Flag" => [
        "option_is_essential"
      ],
      "Filename_Shema_Patch_Level" => "1.55",
      "Filename_Shema_Long_Description" => "A Longer Description",
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

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_categorie_is() : void {
    Search_Shema::set_search_ui_data(self::$search_input3);
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_categorie_is_not() : void {
    Search_Shema::set_search_ui_data(self::$search_input5);
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_text_is() : void {
    Search_Shema::set_search_ui_data(self::$search_input6);
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_text_is_not() : void {
    Search_Shema::set_search_ui_data(self::$search_input7);
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_text_contains() : void {
    Search_Shema::set_search_ui_data(self::$search_input8);
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_text_contains_not() : void {
    Search_Shema::set_search_ui_data(self::$search_input9);
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_text_starts_with() : void {
    Search_Shema::set_search_ui_data(self::$search_input10);
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_text_ends_with() : void {
    Search_Shema::set_search_ui_data(self::$search_input11);
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_number_equal() : void {
    Search_Shema::set_search_ui_data(self::$search_input12);
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_number_unequal() : void {
    Search_Shema::set_search_ui_data(self::$search_input13);
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_number_lower() : void {
    Search_Shema::set_search_ui_data(self::$search_input14);
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_number_lower_equal() : void {
    Search_Shema::set_search_ui_data(self::$search_input15);
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_number_higher() : void {
    Search_Shema::set_search_ui_data(self::$search_input16);
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_number_higher_equal() : void {
    Search_Shema::set_search_ui_data(self::$search_input17);
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_date_before() : void {
    Search_Shema::set_search_ui_data(self::$search_input18);
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_date_before_or_is() : void {
    Search_Shema::set_search_ui_data(self::$search_input19);
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_date_after() : void {
    Search_Shema::set_search_ui_data(self::$search_input20);
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_date_after_or_is() : void {
    Search_Shema::set_search_ui_data(self::$search_input21);
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_date_is() : void {
    Search_Shema::set_search_ui_data(self::$search_input22);
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_text_is_empty() : void {
    Search_Shema::set_search_ui_data(self::$search_input23);
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_text_is_not_empty() : void {
    Search_Shema::set_search_ui_data(self::$search_input24);
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }
}

?>