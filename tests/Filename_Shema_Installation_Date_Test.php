<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertIsNumeric;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertNotEquals;
use function PHPUnit\Framework\assertTrue;

# test class
class Filename_Shema_Installation_Date_Test extends TestCase {

  protected $ui_data = [];
  protected $wrong_ui_data1 = [];
  protected $wrong_ui_data2 = [];
  protected $wrong_ui_data3 = [];
  protected $wrong_ui_data4 = [];
  protected $filename = "";
  protected $wrong_filename1 = "";
  protected $wrong_filename2 = "";

  # set up ui data with realistic data
  protected function setUp() : void {



    ## ---------------- DISABLE TESTS IN THIS FILE -----------------------
    $this->markTestSkipped("Dieser Test ist deaktiviert.");



    $this->ui_data1 = [
      "select_shema_categorie" => "Tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
      "select_shema_flag" => "muss in Packages-Ordner installiert werden",
      "date_shema_installation_date" => "2020-11-03",
      "select_shema_patch_level" => "1.69"
    ];

    $this->ui_data2 = [
      "select_shema_categorie" => "Tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
      "select_shema_flag" => "muss in Packages-Ordner installiert werden",
      "date_shema_installation_date" => "2080-11-03",
      "select_shema_patch_level" => "1.69"
    ];

    $this->wrong_ui_data1 = [
      "select_shema_categorie" => "Tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_lin" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
      "select_shema_flag" => "muss in Packages-Ordner installiert werden",
      "date_shema_installation_dat" => "2020-11-03",
      "select_shema_patch_leve" => "1.69"
    ];


    $this->wrong_ui_data2 = [
      "select_shema_categorie" => "Tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "",
      "select_shema_flag" => "muss in Packages-Ordner installiert werden",
      "date_shema_installation_date" => "2020-13-03",
      "select_shema_patch_level" => "1.609"
    ];


    $this->wrong_ui_data3 = [
      "select_shema_categorie" => "Tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/61757973",
      "select_shema_flag" => "muss in Packages-Ordner installiert werden",
      "date_shema_installation_date" => "2020-11-31",
      "select_shema_patch_level" => "16.9"
    ];


    $this->wrong_ui_data4 = [
      "select_shema_categorie" => "Tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/61757973",
      "select_shema_flag" => "muss in Packages-Ordner installiert werden",
      "date_shema_installation_date" => "",
      "select_shema_patch_level" => "16.9"
    ];

    $this->filename = "03Nov20";

    $this->wrong_filename1 = "03Nov2020";

    $this->wrong_filename2 = "31Nov20";

    $this->wrong_filename3 = "03Aaa20";

    $this->wrong_filename4 = "";

  }


  public function test_convert_ui_data_to_data() : void {
    $converted_ui_data = Filename_Shema_Installation_Date::convert_ui_data_to_data($this->ui_data1);
    assertIsArray($converted_ui_data);
    assertCount(1, $converted_ui_data);
    assertIsString(current($converted_ui_data));
    assertEquals(key($converted_ui_data),0);
  }


  public function test_convert_ui_data_to_data_with_wrong_ui_data1() : void {
    $this->expectException(Shema_Exception::class);
    Filename_Shema_Installation_Date::convert_ui_data_to_data($this->wrong_ui_data1);
  }


  public function test_convert_data_to_filename1() : void {
    $converted_ui_data = Filename_Shema_Installation_Date::convert_ui_data_to_data($this->ui_data1);
    $filename = Filename_Shema_Installation_Date::convert_data_to_filename($converted_ui_data);
    assertIsString($filename);
    assertNotEmpty($filename);
    assertEquals(7, strlen($filename));
    assertTrue(preg_match("/^([0][1-9]|[12][0-9]|3[01])(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[1-9][0-9]$/",$filename) === 1);
    $date_time_object = DateTime::createFromFormat("dMy",$filename);
    assertTrue($date_time_object->format("dMy") === $filename);
    $date_time_object = DateTime::createFromFormat("Y-m-d",$this->ui_data1["date_shema_installation_date"]);
    assertTrue($date_time_object->format("dMy") === $filename);
  }


  public function test_convert_data_to_filename2() : void {
    $converted_ui_data = Filename_Shema_Installation_Date::convert_ui_data_to_data($this->ui_data2);
    $filename = Filename_Shema_Installation_Date::convert_data_to_filename($converted_ui_data);
    assertIsString($filename);
    assertNotEmpty($filename);
    assertEquals(7, strlen($filename));
    assertTrue(preg_match("/^([0][1-9]|[12][0-9]|3[01])(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[1-9][0-9]$/",$filename) === 1);
    $date_time_object = DateTime::createFromFormat("dMy",$filename);
    assertTrue($date_time_object->format("dMy") === $filename);
    $date_time_object = DateTime::createFromFormat("Y-m-d",$this->ui_data2["date_shema_installation_date"]);
    assertTrue($date_time_object->format("dMy") === $filename);
  }


  public function test_convert_data_to_filename_with_wrong_ui_data1() : void {
    $converted_ui_data = Filename_Shema_Installation_Date::convert_ui_data_to_data($this->wrong_ui_data2);
    $this->expectException(Shema_Exception::class);
    Filename_Shema_Installation_Date::convert_data_to_filename($converted_ui_data);
  }


  public function test_convert_data_to_filename_with_wrong_ui_data2() : void {
    $converted_ui_data = Filename_Shema_Installation_Date::convert_ui_data_to_data($this->wrong_ui_data3);
    $this->expectException(Shema_Exception::class);
    Filename_Shema_Installation_Date::convert_data_to_filename($converted_ui_data);
  }


  public function test_convert_data_to_filename_with_wrong_ui_data3() : void {
    $converted_ui_data = Filename_Shema_Installation_Date::convert_ui_data_to_data($this->wrong_ui_data4);
    $this->expectException(Shema_Exception::class);
    Filename_Shema_Installation_Date::convert_data_to_filename($converted_ui_data);
  }


  public function test_convert_filename_to_data1() : void {
    $converted_ui_data = Filename_Shema_Installation_Date::convert_ui_data_to_data($this->ui_data1);
    $filename = Filename_Shema_Installation_Date::convert_data_to_filename($converted_ui_data);
    $data_from_filename = Filename_Shema_Installation_Date::convert_filename_to_data($filename);
    assertIsArray($data_from_filename);
    assertCount(1,$data_from_filename);
    assertIsString(key($data_from_filename));
    assertIsString(current($data_from_filename));
    $key = current(Filename_Shema_Installation_Date::array_ui_data_key);
    assertEquals($this->ui_data1[$key],$data_from_filename[$key]);
  }


  public function test_convert_filename_to_data2() : void {
    $data_from_filename = Filename_Shema_Installation_Date::convert_filename_to_data($this->filename);
    assertIsArray($data_from_filename);
    assertCount(1,$data_from_filename);
    assertIsString(key($data_from_filename));
    assertIsString(current($data_from_filename));
  }


  public function test_convert_filename_to_data_with_wrong_data1() : void {
    $this->expectException(Shema_Exception::class);
    Filename_Shema_Installation_Date::convert_filename_to_data($this->wrong_filename1);
  }


  public function test_convert_filename_to_data_with_wrong_data2() : void {
    $this->expectException(Shema_Exception::class);
    Filename_Shema_Installation_Date::convert_filename_to_data($this->wrong_filename2);
  }


  public function test_convert_filename_to_data_with_wrong_data3() : void {
    $this->expectException(Shema_Exception::class);
    Filename_Shema_Installation_Date::convert_filename_to_data($this->wrong_filename3);
  }


  public function test_convert_filename_to_data_with_wrong_data4() : void {
    $this->expectException(Shema_Exception::class);
    Filename_Shema_Installation_Date::convert_filename_to_data($this->wrong_filename3);
  }


  public function test_print_filename_data_for_ui() : void {
    $converted_ui_data = Filename_Shema_Installation_Date::convert_ui_data_to_data($this->ui_data1);
    $filename = Filename_Shema_Installation_Date::convert_data_to_filename($converted_ui_data);
    $data_from_filename = Filename_Shema_Installation_Date::convert_filename_to_data($filename);
    Filename_Shema_Installation_Date::print_filename_data_for_ui($data_from_filename);
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEquals("", $output);
  }


  public function test_print_filename_shema_input_for_ui() : void {
    Filename_Shema_Installation_Date::print_filename_shema_input_for_ui(0);
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEmpty($output);
  }

  public function test_print_filneame_shema_search_input_for_ui() : void {
    Filename_Shema_Installation_Date::print_filneame_shema_search_input_for_ui();
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEmpty($output);
  }

}

?>