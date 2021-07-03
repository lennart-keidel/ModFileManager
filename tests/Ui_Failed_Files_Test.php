<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertTrue;

# test class
class Ui_Failed_Files_Test extends TestCase {

  private static $filename_data1, $filename_data2, $filename_list1, $filename_list2;

  public function setUp() : void {




    ## ---------------- DISABLE TESTS IN THIS FILE -----------------------
    // $this->markTestSkipped("Dieser Test ist deaktiviert.");




  }

  public static function setUpBeforeClass(): void {
    self::$filename_data1 = [
      "path_source" => "mods/abc/def.package",
      "select_shema_categorie" => "Tuning",
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

    self::$filename_data2 = [
      "path_source" => "mods/abc/def.package",
      "select_shema_categorie" => "Tuning",
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

    self::$filename_list1 = [
      "mods/abc" => [
        "abc.package",
        "def.sims3pack"
      ]
    ];

    self::$filename_list2 = [
      "mods/def" => [
        "abc.package",
        "def.sims3pack"
      ]
    ];
  }

  public function test_add_failed_filename_data() : void {
    Ui_Failed_Files::add_failed_filename_data(self::$filename_data1);
    Ui_Failed_Files::add_failed_filename_data(self::$filename_data2);
    $failed_filename_data = Ui_Failed_Files::get_failed_filename_data();
    assertIsArray($failed_filename_data);
    assertTrue(isset($failed_filename_data[Ui::ui_data_key_root]));
    assertIsArray($failed_filename_data[Ui::ui_data_key_root]);
    assertIsArray(current($failed_filename_data[Ui::ui_data_key_root]));
  }


  public function test_add_failed_filename_list() : void {
    Ui_Failed_Files::reset_failed_filename_list();
    Ui_Failed_Files::add_failed_filename_list(self::$filename_list1);
    Ui_Failed_Files::add_failed_filename_list(self::$filename_list2);
    $failed_filename_list = Ui_Failed_Files::get_failed_filename_list();
    assertIsArray($failed_filename_list);
    foreach($failed_filename_list as $path => $array_filenames){
      assertIsString($path);
      foreach($array_filenames as $filename){
        assertIsString($filename);
      }
    }
  }


  public function test_print_input_shema_for_failed_filename_list() : void {
    Ui_Failed_Files::reset_failed_filename_list();
    Ui_Failed_Files::add_failed_filename_list(self::$filename_list1);
    Ui_Failed_Files::get_failed_filename_list(self::$filename_list1);
    Ui_Failed_Files::print_input_shema_for_failed_filename_list();
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEmpty($output);
  }


  public function test_print_input_shema_for_failed_filename_data() : void {
    Ui_Failed_Files::reset_failed_filename_data();
    Ui_Failed_Files::add_failed_filename_data(self::$filename_data1);
    Ui_Failed_Files::print_input_shema_for_failed_filename_data();
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEmpty($output);
  }

}

?>