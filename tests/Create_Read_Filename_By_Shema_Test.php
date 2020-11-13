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


  # set up ui data with realistic data
  public function setUp() : void {

    $this->ui_data_for_one_file1 = [
      "select_shema_categorie" => "option_tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
      "date_shema_installation_date" => "2020-10-29",

      "select_flag_data_depends_on_expansion" => "ep01",
      "select_shema_patch_level" => "1.67",
      "checkbox_shema_flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion"
      ],
      "url_flag_data_depends_on_content" => "https://modthesims.info/d/638203/broadcaster-a-custom-stereo-music-utility-updated-27-march-2020.html"
    ];

    $this->wrong_ui_data_for_one_file1 = [
      "select_shema_categorie" => "option_tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
      "date_shema_installation_date" => "2020-10-29",

      "select_flag_data_depends_on_expansion" => "ep01",
      "checkbox_shema_flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion"
      ],
      "url_flag_data_depends_on_content" => "https://modthesims.info/d/638203/broadcaster-a-custom-stereo-music-utility-updated-27-march-2020.html"
    ];

    $this->filename_list_for_add_index_to_double_filenames_input = [
      "./first_path" => [
        "abc" => "duplicate_name",
        "def" => "name",
        "ghi" => "duplicate_name",
        "jkl" => "duplicate_name",
        "mno" => "second_duplicate_name",
        "pqr" => "",
        "stu" => "second_duplicate_name",
        "vwx" => ""
      ],
      "./second_path" => [
        "abc" => "a_name",
        "def" => "ab_name",
        "ghi" => "abc_name"
      ],
      "./third_path" => [

      ]
    ];

    $this->filename_list_for_add_index_to_double_filenames_expected_result = [
      "./first_path" => [
        "abc" => "duplicate_name",
        "def" => "name",
        "ghi" => "duplicate_name__2",
        "jkl" => "duplicate_name__3",
        "mno" => "second_duplicate_name",
        "pqr" => "",
        "stu" => "second_duplicate_name__2",
        "vwx" => ""
      ],
      "./second_path" => [
        "abc" => "a_name",
        "def" => "ab_name",
        "ghi" => "abc_name"
      ],
      "./third_path" => [

      ]
    ];

    $this->test_create_filename_list_by_shema_from_ui_data_input = [
      "files" => [
        [
          "path_source_dir" => "/path/to/a/dir/",
          "original_filename" => "abc.package",
          "select_shema_categorie" => "option_tuning",
          "text_shema_description" => "somtehing to do with this",
          "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
          "date_shema_installation_date" => "2020-10-29",

          "select_flag_data_depends_on_expansion" => "ep01",
          "select_shema_patch_level" => "1.67",
          "checkbox_shema_flag" => [
            "option_depends_on_content",
            "option_depends_on_expansion"
          ],
          "url_flag_data_depends_on_content" => "https://modthesims.info/d/638203/broadcaster-a-custom-stereo-music-utility-updated-27-march-2020.html"
        ],
        [
          "path_source_dir" => "/path/to/a/dir/",
          "original_filename" => "def.package",
          "select_shema_categorie" => "option_tuning",
          "text_shema_description" => "somtehing to do with this",
          "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
          "date_shema_installation_date" => "2020-10-29",

          "select_flag_data_depends_on_expansion" => "ep01",
          "select_shema_patch_level" => "1.67",
          "checkbox_shema_flag" => [
            "option_depends_on_content",
            "option_depends_on_expansion"
          ],
          "url_flag_data_depends_on_content" => "https://modthesims.info/d/638203/broadcaster-a-custom-stereo-music-utility-updated-27-march-2020.html"
        ],
        [
          "path_source_dir" => "/path/to/another/dir/",
          "original_filename" => "def.package",
          "select_shema_categorie" => "option_default_replacemant",
          "text_shema_description" => "a little description",
          "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
          "date_shema_installation_date" => "2020-11-12",
          "select_shema_patch_level" => "1.67",
          "checkbox_shema_flag" => [
            "option_is_essential"
          ],
        ]
      ]
    ];


    $this->test_create_filename_list_by_shema_from_ui_data_expected_result = [
      "/path/to/a/dir/" => [
        "abc.package" => "TUN__somtehing_to_do_with_this__ytrlb__167__29Oct20__D1godx_Eep01",
        "def.package" => "TUN__somtehing_to_do_with_this__ytrlb__167__29Oct20__D1godx_Eep01__2"
      ],
      "/path/to/another/dir/" => [
        "def.package" => "DR__a_little_description__ytrlb__167__12Nov20__V"
      ]
    ];
  }


  # set up ui data with realistic data
  public static function tearDownAfterClass(): void {


  }


  public function test_create_filename_by_shema_from_ui_data() : void {
    $filename = Create_Read_Filename_By_Shema::create_filename_by_shema_from_ui_data($this->ui_data_for_one_file1);
    assertIsString($filename);
    assertNotEmpty($filename);
    assertTrue(strpos($filename, Create_Read_Filename_By_Shema::filename_shema_seperator) !== false);
    assertEquals(substr_count($filename, Create_Read_Filename_By_Shema::filename_shema_seperator), 5);
  }


  public function test_create_filename_by_shema_from_ui_data_with_wrong_ui_data() : void {
    $this->expectException(Shema_Exception::class);
    Create_Read_Filename_By_Shema::create_filename_by_shema_from_ui_data($this->wrong_ui_data_for_one_file1);
  }


  public function test_add_index_to_double_filenames_in_filename_list() : void {
    $result = Create_Read_Filename_By_Shema::add_index_to_double_filenames_in_filename_list($this->filename_list_for_add_index_to_double_filenames_input);
    assertisArray($result);
    assertEquals($this->filename_list_for_add_index_to_double_filenames_expected_result, $result);
  }


  public function test_create_filename_list_by_shema_from_ui_data() : void {
    $result = Create_Read_Filename_By_Shema::create_filename_list_by_shema_from_ui_data($this->test_create_filename_list_by_shema_from_ui_data_input);
    assertIsArray($result);
    assertEquals($this->test_create_filename_list_by_shema_from_ui_data_expected_result, $result);
  }

}

?>