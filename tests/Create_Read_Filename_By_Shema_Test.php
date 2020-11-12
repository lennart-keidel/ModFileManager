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

  # set up ui data with realistic data
  public function setUp() : void {

    $this->ui_data_for_one_file1 = [
      "select_shema_categorie" => "option_tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
      "date_shema_installation_date" => "2020-10-29",
      "url_shema_flag_option_depends_on_mod_data" => "https://www.php.net/manual/en/function.printf",
      "select_flag_data_depends_on_expansion" => "ep01",
      "select_shema_patch_level" => "1.67",
      "checkbox_shema_flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion"
      ],
      "url_flag_data_depends_on_content" => "https://modthesims.info/d/638203/broadcaster-a-custom-stereo-music-utility-updated-27-march-2020.html"
    ];
  }


  # set up ui data with realistic data
  public static function tearDownAfterClass(): void {


  }


  public function test_create_filename_by_shema_from_ui_data() : void {
    $filename = Create_Read_Filename_By_Shema::create_filename_by_shema_from_ui_data($this->ui_data_for_one_file1);
    var_dump($filename);
    assertIsString($filename);
    assertNotEmpty($filename);
    assertTrue(strpos($filename, Create_Read_Filename_By_Shema::filename_shema_seperator) !== false);
    assertEquals(substr_count($filename, Create_Read_Filename_By_Shema::filename_shema_seperator), 5);
  }

}

?>