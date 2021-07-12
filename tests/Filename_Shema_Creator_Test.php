<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertNotEquals;

# test class
class Filename_Shema_Creator_Test extends TestCase {

  protected $ui_data = [];
  protected $wrong_ui_data1 = [];
  protected $filename = "";
  protected $wrong_filename1 = "";

  # set up ui data with realistic data
  protected function setUp() : void {



    ## ---------------- DISABLE TESTS IN THIS FILE -----------------------
    // $this->markTestSkipped("Dieser Test ist deaktiviert.");




    $this->ui_data = [
      "Filename_Shema_Categorie" => "Tuning",
      "Filename_Shema_Description" => "some description",
      "Filename_Shema_Link" => "http://localhost/mod_files_renamer/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Filename_Shema_Flag" => "muss in Packages-Ordner installiert werden",
      "Filename_Shema_Creator" => "asdäasd aösdmasa d$!'\"%&{}[]§²³,.;:-_#+~*´`áà"
    ];

    $this->wrong_ui_data1 = [
      "Filename_Shema_Categorie" => "Tuning",
      "Filename_Shema_Description" => "something descripton",
      "Filename_Shema_Link" => "http://localhost/mod_files_renamer/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Filename_Shema_Flag" => "muss in Packages-Ordner installiert werden",
      "text_shema_creato" => "wrong creator ui-data key"
    ];

    $this->filename = "biTcP";

    $this->wrong_filename1 = "1234567asd";
  }


  public function test_convert_ui_data_to_data() : void {
    $converted_ui_data = Filename_Shema_Creator::convert_ui_data_to_data($this->ui_data);
    assertIsArray($converted_ui_data);
    assertCount(1, $converted_ui_data);
    assertIsString(current($converted_ui_data));
    assertEquals(key($converted_ui_data),0);
  }


  public function test_convert_ui_data_to_data_with_wrong_ui_data1() : void {
    $this->expectException(Shema_Exception::class);
    $converted_ui_data = Filename_Shema_Creator::convert_ui_data_to_data($this->wrong_ui_data1);
  }


  public function test_convert_data_to_filename() : void {
    $converted_ui_data = Filename_Shema_Creator::convert_ui_data_to_data($this->ui_data);
    $filename = Filename_Shema_Creator::convert_data_to_filename($converted_ui_data);
    assertIsString($filename);
    assertNotEquals("", $filename);
  }


  public function test_convert_filename_to_data1() : void {
    $converted_ui_data = Filename_Shema_Creator::convert_ui_data_to_data($this->ui_data);
    $filename = Filename_Shema_Creator::convert_data_to_filename($converted_ui_data);
    $data_from_filename = Filename_Shema_Creator::convert_filename_to_data($filename);
    assertIsArray($data_from_filename);
    assertCount(1,$data_from_filename);
    assertIsString(key($data_from_filename));
  }


  public function test_convert_filename_to_data2() : void {
    $data_from_filename = Filename_Shema_Creator::convert_filename_to_data($this->filename);
    assertIsArray($data_from_filename);
    assertCount(1,$data_from_filename);
    assertIsString(key($data_from_filename));
  }


  public function test_convert_filename_to_data_with_wrong_filename1() : void {
    $this->expectException(Shema_Exception::class);
    $data_from_filename = Filename_Shema_Creator::convert_filename_to_data($this->wrong_filename1);
  }


  public function test_print_filename_data_for_ui() : void {
    $converted_ui_data = Filename_Shema_Creator::convert_ui_data_to_data($this->ui_data);
    $filename = Filename_Shema_Creator::convert_data_to_filename($converted_ui_data);
    $data_from_filename = Filename_Shema_Creator::convert_filename_to_data($filename);
    Filename_Shema_Creator::print_filename_data_for_ui($data_from_filename);
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEquals("", $output);
  }

  public function test_print_filename_shema_input_for_ui() : void {
    Filename_Shema_Creator::print_filename_shema_input_for_ui(0);
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEmpty($output);
  }

  public function test_print_filename_shema_search_input_for_ui() : void {
    Filename_Shema_Creator::print_filename_shema_search_input_for_ui(0);
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEmpty($output);
  }

}

?>