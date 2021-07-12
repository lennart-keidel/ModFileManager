<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertNotEquals;

# test class
class Filename_Shema_Categorie_Test extends TestCase {

  protected $ui_data = [];
  protected $wrong_ui_data1 = [];
  protected $wrong_ui_data2 = [];
  protected $filename = "";
  protected $wrong_filename1 = "";
  protected $wrong_filename2 = "";

  # set up ui data with realistic data
  protected function setUp() : void {



    ## ---------------- DISABLE TESTS IN THIS FILE -----------------------
    // $this->markTestSkipped("Dieser Test ist deaktiviert.");





    $this->ui_data = [
      "Filename_Shema_Categorie" => "option_tuning",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "http://localhost/mod_files_renamer/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Filename_Shema_Flag" => "muss in Packages-Ordner installiert werden",
    ];

    $this->wrong_ui_data1 = [
      "Filename_Shema_Categorie" => "!wrong!",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "http://localhost/mod_files_renamer/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Filename_Shema_Flag" => "muss in Packages-Ordner installiert werden",
    ];

    $this->wrong_ui_data2 = [
      "!wrong!" => "option_tuning",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "http://localhost/mod_files_renamer/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Filename_Shema_Flag" => "muss in Packages-Ordner installiert werden",
    ];

    $this->filename = "COR";

    $this->wrong_filename1 = "CORE";

    $this->wrong_filename2 = "_";
  }

  public function test_convert_ui_data_to_data() : void {
    $converted_ui_data = Filename_Shema_Categorie::convert_ui_data_to_data($this->ui_data);
    assertIsArray($converted_ui_data);
    assertCount(1, $converted_ui_data);
    assertIsString(current($converted_ui_data));
    assertEquals(key($converted_ui_data),0);
  }

  public function test_convert_ui_data_to_data_with_wrong_ui_data1() : void {
    $converted_ui_data = Filename_Shema_Categorie::convert_ui_data_to_data($this->wrong_ui_data1);
    assertIsArray($converted_ui_data);
    assertCount(1, $converted_ui_data);
    assertIsString(current($converted_ui_data));
    assertEquals(key($converted_ui_data),0);
  }


  public function test_convert_data_to_filename() : void {
    $converted_ui_data = Filename_Shema_Categorie::convert_ui_data_to_data($this->ui_data);
    $filename = Filename_Shema_Categorie::convert_data_to_filename($converted_ui_data);
    assertIsString($filename);
    assertNotEquals("", $filename);
  }


  public function test_convert_data_to_filename_with_wrong_ui_data1() : void {
    $this->expectException(Shema_Exception::class);
    $converted_ui_data = Filename_Shema_Categorie::convert_ui_data_to_data($this->wrong_ui_data1);
    $filename = Filename_Shema_Categorie::convert_data_to_filename($converted_ui_data);
  }

  public function test_convert_filename_to_data1() : void {
    $converted_ui_data = Filename_Shema_Categorie::convert_ui_data_to_data($this->ui_data);
    $filename = Filename_Shema_Categorie::convert_data_to_filename($converted_ui_data);
    $data_from_filename = Filename_Shema_Categorie::convert_filename_to_data($filename);
    assertIsArray($data_from_filename);
    assertCount(1,$data_from_filename);
    assertIsString(key($data_from_filename));
  }

  public function test_convert_filename_to_data2() : void {
    $data_from_filename = Filename_Shema_Categorie::convert_filename_to_data($this->filename);
    assertIsArray($data_from_filename);
    assertCount(1,$data_from_filename);
    assertIsString(key($data_from_filename));
  }

  public function test_convert_filename_to_data_with_wrong_filename1() : void {
    $this->expectException(Shema_Exception::class);
    $data_from_filename = Filename_Shema_Categorie::convert_filename_to_data($this->wrong_filename1);
  }

  public function test_convert_filename_to_data_with_wrong_filename2() : void {
    $this->expectException(Shema_Exception::class);
    $data_from_filename = Filename_Shema_Categorie::convert_filename_to_data($this->wrong_filename2);
  }

  public function test_print_filename_data_for_ui() : void {
    $converted_ui_data = Filename_Shema_Categorie::convert_ui_data_to_data($this->ui_data);
    $filename = Filename_Shema_Categorie::convert_data_to_filename($converted_ui_data);
    $data_from_filename = Filename_Shema_Categorie::convert_filename_to_data($filename);
    Filename_Shema_Categorie::print_filename_data_for_ui($data_from_filename);
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEmpty($output);
  }

  public function test_print_filename_shema_input_for_ui() : void {
    Filename_Shema_Categorie::print_filename_shema_input_for_ui(0);
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEmpty($output);
  }

  public function test_print_filename_shema_search_input_for_ui() : void {
    Filename_Shema_Categorie::print_filename_shema_search_input_for_ui(0);
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEmpty($output);
  }

}

?>