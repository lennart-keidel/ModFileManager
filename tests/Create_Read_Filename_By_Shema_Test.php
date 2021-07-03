<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFileDoesNotExist;
use function PHPUnit\Framework\assertFileExists;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertTrue;

# test class
class Create_Read_Filename_By_Shema_Test extends TestCase {


  protected $ui_data_for_one_file1 = [];
  protected $wrong_ui_data_for_one_file1 = [];
  protected $filename_list_for_add_index_to_double_filenames_expected_result = [];
  protected $filename_list_for_add_index_to_double_filenames_input = [];
  protected $full_ui_data1 = [];
  protected $test_create_filename_list_by_shema_from_ui_data_input = [];
  protected $test_create_filename_list_by_shema_from_ui_data_expected_result = [];
  protected $test_read_data_from_filename_by_shema_input_and_expected_output = [];
  protected $wrong_filename1 = "";
  protected $test_read_data_from_filename_list_by_shema_wrong_data = [];


  # set up ui data with realistic data
  public function setUp() : void {




    ## ---------------- DISABLE TESTS IN THIS FILE -----------------------
    // $this->markTestSkipped("Dieser Test ist deaktiviert.");






    $this->ui_data_for_one_file1 = [
      "path_source" => "/path/to/a/dir/abc.sims3pack",
      "select_shema_categorie" => "option_tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://modthesims.info/",
      "date_shema_installation_date" => "2020-10-29",

      "select_flag_data_depends_on_expansion" => "ep01",
      "select_shema_patch_level" => "1.67",
      "checkbox_shema_flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion"
      ],
      "url_flag_data_depends_on_content" => "https://modthesims.info/",
      "text_shema_long_description" => "A Longer Description",
      "text_shema_creator" => "Nraas",
    ];

    $this->wrong_ui_data_for_one_file1 = [
      "path_source" => "/path/to/a/dir/abc.sims3pack",
      "select_shema_categorie" => "option_tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://modthesims.info/",
      "date_shema_installation_date" => "2020-10-29",

      "select_flag_data_depends_on_expansion" => "ep01",
      "checkbox_shema_flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion"
      ],
      "url_flag_data_depends_on_content" => "https://modthesims.info/",
      "text_shema_long_description" => "A Longer Description",
      "text_shema_creator" => "Nraas",
    ];

    $this->filename_list_for_add_index_to_double_filenames_input = [
      "./first_path" => [
        "abc" => "duplicate_name.package",
        "def" => "name",
        "ghi" => "duplicate_name.package",
        "jkl" => "duplicate_name.package",
        "mno" => "second_duplicate_name",
        "pqr" => "",
        "stu" => "second_duplicate_name",
        "vwx" => "",
        "kga" => ".hidden_duplicate_name",
        "kgb" => ".hidden_duplicate_name",
        "kgc" => ".hidden_duplicate_name_with_filextension.package",
        "kgd" => ".hidden_duplicate_name_with_filextension.package",
      ],
      "./second_path" => [
        "abc" => "a_name.package",
        "def" => "ab_name.sims3pack",
        "ghi" => "abc_name"
      ],
      "./third_path" => [

      ]
    ];

    $this->filename_list_for_add_index_to_double_filenames_expected_result = [
      "./first_path" => [
        "abc" => "duplicate_name.package",
        "def" => "name",
        "ghi" => "duplicate_name__2.package",
        "jkl" => "duplicate_name__3.package",
        "mno" => "second_duplicate_name",
        "pqr" => "",
        "stu" => "second_duplicate_name__2",
        "vwx" => "",
        "kga" => ".hidden_duplicate_name",
        "kgb" => ".hidden_duplicate_name__2",
        "kgc" => ".hidden_duplicate_name_with_filextension.package",
        "kgd" => ".hidden_duplicate_name_with_filextension__2.package"
      ],
      "./second_path" => [
        "abc" => "a_name.package",
        "def" => "ab_name.sims3pack",
        "ghi" => "abc_name"
      ],
      "./third_path" => [

      ]
    ];

    $this->test_create_filename_list_by_shema_from_ui_data_input = [
      Ui::ui_data_key_root => [
        [
          "path_source" => "\\path\\to\\a\\dir\\abc.sims3pack",
          "select_shema_categorie" => "option_tuning",
          "text_shema_description" => "somtehing to do with this",
          "url_shema_link" => "https://modthesims.info/",
          "date_shema_installation_date" => "2020-10-29",
          "select_flag_data_depends_on_expansion" => "ep01",
          "select_shema_patch_level" => "1.67",
          "checkbox_shema_flag" => [
            "option_depends_on_content",
            "option_depends_on_expansion"
          ],
          "url_flag_data_depends_on_content" => "https://modthesims.info/",
          "text_shema_long_description" => "A Longer Description",
          "text_shema_creator" => "Nraas",
        ],
        [
          "path_source" => "\\path\\to\\a\\dir\\def.sims3pack",
          "select_shema_categorie" => "option_tuning",
          "text_shema_description" => "somtehing to do with this",
          "url_shema_link" => "https://modthesims.info/",
          "date_shema_installation_date" => "2020-10-29",
          "select_flag_data_depends_on_expansion" => "ep01",
          "select_shema_patch_level" => "1.67",
          "checkbox_shema_flag" => [
            "option_depends_on_content",
            "option_depends_on_expansion"
          ],
          "url_flag_data_depends_on_content" => "https://modthesims.info/",
          "text_shema_long_description" => "A Longer Description",
          "text_shema_creator" => "Nraas",
        ],
        [
          "path_source" => "\\path\\to\\another\\dir\\def.package",
          "select_shema_categorie" => "option_default_replacemant",
          "text_shema_description" => "a little description",
          "url_shema_link" => "https://modthesims.info/",
          "date_shema_installation_date" => "2020-11-12",
          "select_shema_patch_level" => "1.67",
          "checkbox_shema_flag" => [
            "option_is_essential"
          ],
          "text_shema_long_description" => "A Longer Description",
          "text_shema_creator" => "Nraas",
        ]
      ]
    ];


    $this->test_create_filename_list_by_shema_from_ui_data_expected_result = [
      "\\path\\to\\a\\dir" => [
        "abc.sims3pack" => "TUN__somtehing_to_do_with_this__zd5tW__167__29Oct20__Dzd5tW_Eep01__q3vcX__f0XFQ.sims3pack",
        "def.sims3pack" => "TUN__somtehing_to_do_with_this__zd5tW__167__29Oct20__Dzd5tW_Eep01__q3vcX__f0XFQ__2.sims3pack"
      ],
      "\\path\\to\\another\\dir" => [
        "def.package" => "DR__a_little_description__zd5tW__167__12Nov20__V__q3vcX__f0XFQ.package"
      ]
    ];


    $this->test_read_data_from_filename_list_by_shema_input_and_expected_output = [
      "input" => [
        "\\path\\to\\a\\dir" => [
          "TUN__somtehing_to_do_with_this__zd5tW__167__29Oct20__Dzd5tW_Eep01__q3vcX__f0XFQ.sims3pack",
          "TUN__somtehing_to_do_with_this__zd5tW__167__29Oct20__Dzd5tW_Eep01__q3vcX__f0XFQ__2.sims3pack"
        ],
        "\\path\\to\\another\\dir" => [
          "DR__a_little_description__zd5tW__167__12Nov20__V__q3vcX__f0XFQ.package"
        ]
      ],
      "expected_output" => [
        Ui::ui_data_key_root => [
          [
            "path_source" => "\\path\\to\\a\\dir\\TUN__somtehing_to_do_with_this__zd5tW__167__29Oct20__Dzd5tW_Eep01__q3vcX__f0XFQ.sims3pack",
            "select_shema_categorie" => "option_tuning",
            "text_shema_description" => "somtehing to do with this",
            "url_shema_link" => "https://modthesims.info/",
            "date_shema_installation_date" => "2020-10-29",
            "select_flag_data_depends_on_expansion" => "ep01",
            "select_shema_patch_level" => "1.67",
            "checkbox_shema_flag" => [
              "option_depends_on_content",
              "option_depends_on_expansion"
            ],
            "url_flag_data_depends_on_content" => "https://modthesims.info/",
            "text_shema_long_description" => "A Longer Description",
            "text_shema_creator" => "Nraas",
          ],
          [
            "path_source" => "\\path\\to\\a\\dir\\TUN__somtehing_to_do_with_this__zd5tW__167__29Oct20__Dzd5tW_Eep01__q3vcX__f0XFQ__2.sims3pack",
            "select_shema_categorie" => "option_tuning",
            "text_shema_description" => "somtehing to do with this",
            "url_shema_link" => "https://modthesims.info/",
            "date_shema_installation_date" => "2020-10-29",
            "select_flag_data_depends_on_expansion" => "ep01",
            "select_shema_patch_level" => "1.67",
            "checkbox_shema_flag" => [
              "option_depends_on_content",
              "option_depends_on_expansion"
            ],
            "url_flag_data_depends_on_content" => "https://modthesims.info/",
            "text_shema_long_description" => "A Longer Description",
            "text_shema_creator" => "Nraas",
          ],
          [
            "path_source" => "\\path\\to\\another\\dir\\DR__a_little_description__zd5tW__167__12Nov20__V__q3vcX__f0XFQ.package",
            "select_shema_categorie" => "option_default_replacemant",
            "text_shema_description" => "a little description",
            "url_shema_link" => "https://modthesims.info/",
            "date_shema_installation_date" => "2020-11-12",
            "select_shema_patch_level" => "1.67",
            "checkbox_shema_flag" => [
              "option_is_essential"
            ],
            "text_shema_long_description" => "A Longer Description",
            "text_shema_creator" => "Nraas",
          ]
        ]
      ]
    ];

    $this->wrong_filename1 = "TUN__somtehing_to_do_with_this__zd5tW__167__29Oct20__Dzd5tW_Eep01.sims3pack";

    $this->test_read_data_from_filename_list_by_shema_wrong_data = [
      "\\path\\to\\a\\dir" => [
        "TUN__somtehing_to_do_with_this__zd5tW__167__29Oct20__Dzd5tW_Eep01__q3vcX__f0XFQ.sims3pack",
        "TUN__somtehing_to_do_with_this__zd5tW__167__29Oct20__Dzd5tW_Eep99__q3vcX__f0XFQ__2.sims3pack"
      ],
      "\\path\\to\\another\\dir" => [
        "DR__a_little_description__zd5tW__167__12Nov20__V__q3vcX__f0XFQ.package"
      ]
    ];
  }


  public function test_create_filename_by_shema_from_ui_data() : void {
    $filename = Create_Read_Filename_By_Shema::create_filename_by_shema_from_ui_data($this->ui_data_for_one_file1);
    assertIsString($filename);
    assertNotEmpty($filename);
    assertTrue(strpos($filename, Create_Read_Filename_By_Shema::filename_shema_seperator) !== false);
    assertEquals(substr_count($filename, Create_Read_Filename_By_Shema::filename_shema_seperator), 7);
  }


  public function test_create_filename_by_shema_from_ui_data_with_wrong_ui_data() : void {
    $result = Create_Read_Filename_By_Shema::create_filename_by_shema_from_ui_data($this->wrong_ui_data_for_one_file1);
    assertEmpty($result);
  }


  public function test_add_index_to_duplicate_filenames_in_filename_list() : void {
    $result = Create_Read_Filename_By_Shema::add_index_to_duplicate_filenames_in_filename_list($this->filename_list_for_add_index_to_double_filenames_input);
    assertisArray($result);
    assertEquals($this->filename_list_for_add_index_to_double_filenames_expected_result, $result);
  }


  public function test_create_filename_list_by_shema_from_ui_data() : void {
    $result = Create_Read_Filename_By_Shema::create_filename_list_by_shema_from_ui_data($this->test_create_filename_list_by_shema_from_ui_data_input);
    assertIsArray($result);
    assertEquals($this->test_create_filename_list_by_shema_from_ui_data_expected_result, $result);
  }


  public function test_read_data_from_filename_list_by_shema() : void {
    $input = $this->test_read_data_from_filename_list_by_shema_input_and_expected_output["input"];
    $expected_output = $this->test_read_data_from_filename_list_by_shema_input_and_expected_output["expected_output"];
    $result = Create_Read_Filename_By_Shema::read_data_from_filename_list_by_shema($input);
    assertIsArray($result);
    assertEquals($expected_output, $result);
  }


  public function test_read_data_from_filename_list_by_shema_with_wrong_data() : void {
    $result = Create_Read_Filename_By_Shema::read_data_from_filename_list_by_shema($this->test_read_data_from_filename_list_by_shema_wrong_data);
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEmpty($output);
  }




}

?>