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
      "Filename_Shema_Categorie" => "option_tuning",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "https://modthesims.info/",
      "Filename_Shema_Installation_Date" => "2020-10-29",

      "Sub_Data_Flag_Depends_On_Expansion" => ["ep01"],
      "Filename_Shema_Patch_Level" => "1.67",
      "Filename_Shema_Flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion"
      ],
      "Sub_Data_Flag_Depends_On_Content" => "https://modthesims.info/",
      "Filename_Shema_Long_Description" => "A Longer Description",
      "Filename_Shema_Creator" => "Nraas",
    ];

    $this->wrong_ui_data_for_one_file1 = [
      "path_source" => "/path/to/a/dir/abc.sims3pack",
      "Filename_Shema_Categorie" => "option_tuning",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "https://modthesims.info/",
      "Filename_Shema_Installation_Date" => "2020-10-29",

      "Sub_Data_Flag_Depends_On_Expansion" => ["ep01"],
      "Filename_Shema_Flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion"
      ],
      "Sub_Data_Flag_Depends_On_Content" => "https://modthesims.info/",
      "Filename_Shema_Long_Description" => "A Longer Description",
      "Filename_Shema_Creator" => "Nraas",
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
          "Filename_Shema_Categorie" => "option_tuning",
          "Filename_Shema_Description" => "somtehing to do with this",
          "Filename_Shema_Link" => "https://modthesims.info/",
          "Filename_Shema_Installation_Date" => "2020-10-29",
          "Sub_Data_Flag_Depends_On_Expansion" => ["ep01"],
          "Filename_Shema_Patch_Level" => "1.67",
          "Filename_Shema_Flag" => [
            "option_depends_on_content",
            "option_depends_on_expansion"
          ],
          "Sub_Data_Flag_Depends_On_Content" => "https://modthesims.info/",
          "Filename_Shema_Long_Description" => "A Longer Description",
          "Filename_Shema_Creator" => "Nraas",
        ],
        [
          "path_source" => "\\path\\to\\a\\dir\\def.sims3pack",
          "Filename_Shema_Categorie" => "option_tuning",
          "Filename_Shema_Description" => "somtehing to do with this",
          "Filename_Shema_Link" => "https://modthesims.info/",
          "Filename_Shema_Installation_Date" => "2020-10-29",
          "Sub_Data_Flag_Depends_On_Expansion" => ["ep01"],
          "Filename_Shema_Patch_Level" => "1.67",
          "Filename_Shema_Flag" => [
            "option_depends_on_content",
            "option_depends_on_expansion"
          ],
          "Sub_Data_Flag_Depends_On_Content" => "https://modthesims.info/",
          "Filename_Shema_Long_Description" => "A Longer Description",
          "Filename_Shema_Creator" => "Nraas",
        ],
        [
          "path_source" => "\\path\\to\\another\\dir\\def.package",
          "Filename_Shema_Categorie" => "option_fix",
          "Filename_Shema_Description" => "a little description",
          "Filename_Shema_Link" => "https://modthesims.info/",
          "Filename_Shema_Installation_Date" => "2020-11-12",
          "Filename_Shema_Patch_Level" => "1.67",
          "Filename_Shema_Flag" => [
            "option_is_essential"
          ],
          "Filename_Shema_Long_Description" => "A Longer Description",
          "Filename_Shema_Creator" => "Nraas",
        ]
      ]
    ];


    $this->test_create_filename_list_by_shema_from_ui_data_expected_result = [
      "\\path\\to\\a\\dir" => [
        "abc.sims3pack" => "TUN__somtehing_to_do_with_this__167__29Oct20__Czd5tW_Eep01__q3vcX__f0XFQ__zd5tW.sims3pack",
        "def.sims3pack" => "TUN__somtehing_to_do_with_this__167__29Oct20__Czd5tW_Eep01__q3vcX__f0XFQ__zd5tW__2.sims3pack"
      ],
      "\\path\\to\\another\\dir" => [
        "def.package" => "FIX__a_little_description__167__12Nov20__V__q3vcX__f0XFQ__zd5tW.package"
      ]
    ];


    $this->test_read_data_from_filename_list_by_shema_input_and_expected_output = [
      "input" => [
        "\\path\\to\\a\\dir" => [
          "TUN__somtehing_to_do_with_this__167__29Oct20__Czd5tW_Eep01__q3vcX__f0XFQ__zd5tW.sims3pack",
          "TUN__somtehing_to_do_with_this__167__29Oct20__Czd5tW_Eep01sp01ep08__q3vcX__f0XFQ__zd5tW__2.sims3pack"
        ],
        "\\path\\to\\another\\dir" => [
          "FIX__a_little_description__167__12Nov20__V__q3vcX__f0XFQ__zd5tW.package"
        ]
      ],
      "expected_output" => [
        Ui::ui_data_key_root => [
          [
            "path_source" => "\\path\\to\\a\\dir\\TUN__somtehing_to_do_with_this__167__29Oct20__Czd5tW_Eep01__q3vcX__f0XFQ__zd5tW.sims3pack",
            "Filename_Shema_Categorie" => "option_tuning",
            "Filename_Shema_Description" => "somtehing to do with this",
            "Filename_Shema_Link" => "https://modthesims.info/",
            "Filename_Shema_Installation_Date" => "2020-10-29",
            "Sub_Data_Flag_Depends_On_Expansion" => ["ep01"],
            "Filename_Shema_Patch_Level" => "1.67",
            "Filename_Shema_Flag" => [
              "option_depends_on_content",
              "option_depends_on_expansion"
            ],
            "Sub_Data_Flag_Depends_On_Content" => "https://modthesims.info/",
            "Filename_Shema_Long_Description" => "A Longer Description",
            "Filename_Shema_Creator" => "Nraas",
          ],
          [
            "path_source" => "\\path\\to\\a\\dir\\TUN__somtehing_to_do_with_this__167__29Oct20__Czd5tW_Eep01sp01ep08__q3vcX__f0XFQ__zd5tW__2.sims3pack",
            "Filename_Shema_Categorie" => "option_tuning",
            "Filename_Shema_Description" => "somtehing to do with this",
            "Filename_Shema_Link" => "https://modthesims.info/",
            "Filename_Shema_Installation_Date" => "2020-10-29",
            "Sub_Data_Flag_Depends_On_Expansion" => ["ep01", "sp01", "ep08"],
            "Filename_Shema_Patch_Level" => "1.67",
            "Filename_Shema_Flag" => [
              "option_depends_on_content",
              "option_depends_on_expansion"
            ],
            "Sub_Data_Flag_Depends_On_Content" => "https://modthesims.info/",
            "Filename_Shema_Long_Description" => "A Longer Description",
            "Filename_Shema_Creator" => "Nraas",
          ],
          [
            "path_source" => "\\path\\to\\another\\dir\\FIX__a_little_description__167__12Nov20__V__q3vcX__f0XFQ__zd5tW.package",
            "Filename_Shema_Categorie" => "option_fix",
            "Filename_Shema_Description" => "a little description",
            "Filename_Shema_Link" => "https://modthesims.info/",
            "Filename_Shema_Installation_Date" => "2020-11-12",
            "Filename_Shema_Patch_Level" => "1.67",
            "Filename_Shema_Flag" => [
              "option_is_essential"
            ],
            "Filename_Shema_Long_Description" => "A Longer Description",
            "Filename_Shema_Creator" => "Nraas",
          ]
        ]
      ]
    ];

    $this->wrong_filename1 = "TUN__somtehing_to_do_with_this__167__29Oct20__Czd5tW_Eep01__zd5tW.sims3pack";

    $this->test_read_data_from_filename_list_by_shema_wrong_data = [
      "\\path\\to\\a\\dir" => [
        "TUN__somtehing_to_do_with_this__167__29Oct20__Czd5tW_Eep01__q3vcX__f0XFQ__zd5tW.sims3pack",
        "TUN__somtehing_to_do_with_this__167__29Oct20__Czd5tW_Eep99__q3vcX__f0XFQ__zd5tW__2.sims3pack"
      ],
      "\\path\\to\\another\\dir" => [
        "FIX__a_little_description__167__12Nov20__V__q3vcX__f0XFQ__zd5tW.package"
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