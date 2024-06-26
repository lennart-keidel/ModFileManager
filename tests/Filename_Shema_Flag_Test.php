<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertContains;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertNotEquals;
use function PHPUnit\Framework\assertTrue;

# test class
class Filename_Shema_Flag_Test extends TestCase {

  protected $ui_data1 = [];
  protected $ui_data2 = [];
  protected $ui_data3 = [];
  protected $ui_data4 = [];
  protected $ui_data5 = [];
  protected $wrong_ui_data1 = [];
  protected $wrong_ui_data2 = [];
  protected $wrong_ui_data3 = [];
  protected $wrong_ui_data4 = [];
  protected $wrong_ui_data6 = [];
  protected $wrong_ui_data7 = [];
  protected $wrong_ui_data8 = [];
  protected $filename1 = "";
  protected $filename2 = "";
  protected $filename3 = "";
  protected $filename4 = "";
  protected $filename5 = "";
  protected $filename6 = "";
  protected $wrong_filename1 = "";
  protected $wrong_filename2 = "";
  protected $wrong_filename3 = "";
  protected $wrong_filename4 = "";
  protected $wrong_filename5 = "";
  protected $wrong_filename6 = "";
  protected $wrong_filename7 = "";
  protected $wrong_filename8 = "";

  # set up ui data with realistic data
  protected function setUp() : void {




    ## ---------------- DISABLE TESTS IN THIS FILE -----------------------
    // $this->markTestSkipped("Dieser Test ist deaktiviert.");




    $this->ui_data1 = [
      "Filename_Shema_Categorie" => "Tuning",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "https://modthesims.info/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Sub_Data_Flag_Depends_On_Expansion" => ["ep01"],
      "Filename_Shema_Flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion"
      ],
      "Sub_Data_Flag_Depends_On_Content" => [ "https://modthesims.info/d/526207/more-traits-for-all-ages.html", ],
      "Filename_Shema_Long_Description" => "A Longer Description",
      "Filename_Shema_Creator" => "Nraas",
    ];

    $this->ui_data2 = [
      "Filename_Shema_Categorie" => "Tuning",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "https://modthesims.info/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Sub_Data_Flag_Depends_On_Expansion" => ["ep11"],
      "Filename_Shema_Flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion",
        // "option_install_in_packages",
        "option_is_essential"
      ],
      "Sub_Data_Flag_Depends_On_Content" => [ "https://modthesims.info/", ],
      "Filename_Shema_Long_Description" => "A Longer Description",
      "Filename_Shema_Creator" => "Nraas",
    ];

    $this->ui_data3 = [
      "Filename_Shema_Categorie" => "Tuning",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "https://modthesims.info/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Sub_Data_Flag_Depends_On_Expansion" => ["sp09"],
      "Filename_Shema_Flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion",
        "option_install_in_overrides",
        "option_is_essential"
      ],
      "Sub_Data_Flag_Depends_On_Content" => [ "https://modthesims.info/", ],
      "Filename_Shema_Long_Description" => "A Longer Description",
      "Filename_Shema_Creator" => "Nraas",
    ];

    $this->ui_data4 = [
      "Filename_Shema_Categorie" => "Tuning",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "https://modthesims.info/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Filename_Shema_Flag" => [

      ]
    ];

    $this->ui_data5 = [
      "Filename_Shema_Categorie" => "Tuning",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "https://modthesims.info/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Filename_Shema_Flag" => [
        "option_depends_on_content",
      ],
      "Sub_Data_Flag_Depends_On_Content" => [
        "https://modthesims.info/d/673996/instant-transformations.html",
        "https://modthesims.info/d/647088/base-game-expansion-pack-and-stuff-pack-loading-screens-with-the-base-game-logo.html",
      ],
    ];

    # "no_flag_option_selected" and any else flag are selected, which is restricted
    $this->wrong_ui_data1 = [
      "Filename_Shema_Categorie" => "Tuning",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "https://modthesims.info/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Sub_Data_Flag_Depends_On_Expansion" => ["ep01"],
      "Filename_Shema_Flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion",
        "option_install_in_overrides",
        "no_flag_option_selected",
        "option_is_essential"
      ],
      "Sub_Data_Flag_Depends_On_Content" => [ "https://modthesims.info/", ],
      "Filename_Shema_Long_Description" => "A Longer Description",
      "Filename_Shema_Creator" => "Nraas",
    ];


    # "option_depends_on_content" misses data
    $this->wrong_ui_data2 = [
      "Filename_Shema_Categorie" => "Tuning",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "https://modthesims.info/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Sub_Data_Flag_Depends_On_Expansion" => ["ep01"],
      "Filename_Shema_Flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion",
        // "option_install_in_packages",
        "option_is_essential"
      ]
    ];


    # "option_depends_on_expansion" misses data
    $this->wrong_ui_data3 = [
      "Filename_Shema_Categorie" => "Tuning",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "https://modthesims.info/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Filename_Shema_Flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion",
        // "option_install_in_packages",
        "option_is_essential"
      ],
      "Sub_Data_Flag_Depends_On_Content" => [ "https://modthesims.info/", ],
      "Filename_Shema_Long_Description" => "A Longer Description",
      "Filename_Shema_Creator" => "Nraas",
    ];


    # "option_depends_on_expansion" wrong data
    $this->wrong_ui_data4 = [
      "Filename_Shema_Categorie" => "Tuning",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "https://modthesims.info/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Sub_Data_Flag_Depends_On_Expansion" => ["sp99"],
      "Filename_Shema_Flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion",
        // "option_install_in_packages",
        "option_is_essential"
      ],
      "Sub_Data_Flag_Depends_On_Content" => [ "https://modthesims.info/", ],
      "Filename_Shema_Long_Description" => "A Longer Description",
      "Filename_Shema_Creator" => "Nraas",
    ];


    # "Filename_Shema_Flag" contains invalid flag
    $this->wrong_ui_data6 = [
      "Filename_Shema_Categorie" => "Tuning",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "https://modthesims.info/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Filename_Shema_Flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion",
        // "option_install_in_packages",
        "option_is_e"
      ],
      "Sub_Data_Flag_Depends_On_Content" => [ "https://modthesims.info/", ],
      "Filename_Shema_Long_Description" => "A Longer Description",
      "Filename_Shema_Creator" => "Nraas",
    ];


    # "Filename_Shema_Flag" contains double flag
    $this->wrong_ui_data7 = [
      "Filename_Shema_Categorie" => "Tuning",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "https://modthesims.info/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Filename_Shema_Flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion",
        "option_install_in_overrides",
        "option_install_in_overrides",
      ],
      "Sub_Data_Flag_Depends_On_Content" => [ "https://modthesims.info/", ],
      "Filename_Shema_Long_Description" => "A Longer Description",
      "Filename_Shema_Creator" => "Nraas",
    ];


    # "Sub_Data_Flag_Depends_On_Content" has no data
    $this->wrong_ui_data8 = [
      "Filename_Shema_Categorie" => "Tuning",
      "Filename_Shema_Description" => "somtehing to do with this",
      "Filename_Shema_Link" => "https://modthesims.info/",
      "Filename_Shema_Installation_Date" => "2020-10-29",
      "Filename_Shema_Flag" => [
        "option_depends_on_content",
      ],
      "Sub_Data_Flag_Depends_On_Content" => [ "", ],
      "Filename_Shema_Long_Description" => "A Longer Description",
      "Filename_Shema_Creator" => "Nraas",
    ];


    $this->filename1 = "I";

    $this->filename2 = "O_Czd5tW_Eep11_V";

    $this->filename3 = "O";

    $this->filename4 = "Czd5tW";

    # expansion id is uppercase, assume it's converted to lowercase
    $this->filename5 = "ESP09";

    $this->filename6 = "CvdVDM";


    # empty flag, that only is valid if it's the only flag
    $this->wrong_filename1 = "Czd5tW_Eep11_I";

    # double flag
    $this->wrong_filename2 = "Esp07_Eep01";

    # data for Flag that should have no data
    $this->wrong_filename3 = "Czd5tW_Eep11_Va";

    # not existing short link
    $this->wrong_filename4 = "C7qcva123asd_Eep11_V";

    # not existing expansion id
    $this->wrong_filename5 = "Czd5tW_Eep99_V";

    # no flag selected and any other flag are not combinable
    $this->wrong_filename6 = "I_Czd5tW_Eep01_O_V";

    # flag that requires sub data has no data
    $this->wrong_filename7 = "C_Eep07_V";

    # no flag selected and any other flag are not combinable, but in different order
    $this->wrong_filename8 = "O_Czd5tW_Eep01_I_V";
  }


  public function test_convert_ui_data_to_data1() : void {
    $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->ui_data1);
    assertIsArray($converted_ui_data);
    assertIsArray($converted_ui_data["keys"]);
    assertIsArray($converted_ui_data["sub_data"]);
    assertCount(2, $converted_ui_data);

    # assert amount of options in ui-data and options in result data are equal
    $key = current(Filename_Shema_Flag::array_ui_data_key);
    assertEquals(count($this->ui_data1[$key]), count($converted_ui_data["keys"]));

    # check if all required sub-data-elements are contained
    foreach(Filename_Shema_Flag::array_ui_data_key_sub_data as $key => $array_keys_sub){
      if(array_search($key,$converted_ui_data["keys"])!==false){
        foreach($array_keys_sub as $key_sub){
          assertTrue(isset($converted_ui_data["sub_data"][$key]));
          assertTrue(array_key_exists($key_sub, $converted_ui_data["sub_data"][$key]) !== false);
        }
      }
    }
  }


  public function test_convert_ui_data_to_data2() : void {
    $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->ui_data4);
    assertIsArray($converted_ui_data);
    assertIsArray($converted_ui_data["keys"]);
    assertIsArray($converted_ui_data["sub_data"]);
    assertCount(2, $converted_ui_data);
    assertCount(1, $converted_ui_data["keys"]);
    assertEquals(Filename_Shema_Flag::default_flag_if_no_options_selected, current($converted_ui_data["keys"]));
    assertCount(0, $converted_ui_data["sub_data"]);
  }


  public function test_convert_ui_data_to_data_with_wrong_ui_data1() : void {
    $this->expectException(Shema_Exception::class);
    Filename_Shema_Flag::convert_ui_data_to_data($this->wrong_ui_data1);
  }


  public function test_convert_ui_data_to_data_with_wrong_ui_data2() : void {
    $this->expectException(Shema_Exception::class);
    Filename_Shema_Flag::convert_ui_data_to_data($this->wrong_ui_data2);
  }


  public function test_convert_ui_data_to_data_with_wrong_ui_data3() : void {
    $this->expectException(Shema_Exception::class);
    Filename_Shema_Flag::convert_ui_data_to_data($this->wrong_ui_data3);
  }


  public function test_convert_ui_data_to_data_with_wrong_ui_data4() : void {
    $this->expectException(Shema_Exception::class);
    Filename_Shema_Flag::convert_ui_data_to_data($this->wrong_ui_data6);
  }


  public function test_convert_ui_data_to_data_with_wrong_ui_data5() : void {
    $this->expectException(Shema_Exception::class);
    Filename_Shema_Flag::convert_ui_data_to_data($this->wrong_ui_data7);
  }


  public function test_convert_data_to_filename1() : void {
    $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->ui_data1);
    $filename = Filename_Shema_Flag::convert_data_to_filename($converted_ui_data);
    assertIsString($filename);
    assertNotEquals("", $filename);

    # split file name by the flag delimeter and iterate over it
    $filename_as_array = explode(Filename_Shema_Flag::filename_flag_delimiter,$filename);
    foreach($filename_as_array as $filename_part){

      # test if short id of filenamepart is valid
      $short_id = substr($filename_part,0,1);
      $option = array_search($short_id, Filename_Shema_Flag::array_option_short_id);
      assertTrue($option !== false);

      # test if filenamepart contains data if sub-data is required
      if(array_key_exists($option,Filename_Shema_Flag::array_ui_data_key_sub_data) === true){
        assertTrue(strlen($filename_part) > strlen($short_id));
      }
    }
  }


  public function test_convert_data_to_filename2() : void {
    $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->ui_data2);
    $filename = Filename_Shema_Flag::convert_data_to_filename($converted_ui_data);
    assertIsString($filename);
    assertNotEquals("", $filename);

    # split file name by the flag delimeter and iterate over it
    $filename_as_array = explode(Filename_Shema_Flag::filename_flag_delimiter,$filename);
    foreach($filename_as_array as $filename_part){

      # test if short id of filenamepart is valid
      $short_id = substr($filename_part,0,1);
      $option = array_search($short_id, Filename_Shema_Flag::array_option_short_id);
      assertTrue($option !== false);

      # test if filenamepart contains data if sub-data is required
      if(array_key_exists($option,Filename_Shema_Flag::array_ui_data_key_sub_data) === true){
        assertTrue(strlen($filename_part) > strlen($short_id));
      }
    }
  }


  public function test_convert_data_to_filename3() : void {
    $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->ui_data4);
    $filename = Filename_Shema_Flag::convert_data_to_filename($converted_ui_data);
    assertIsString($filename);
    assertNotEquals("", $filename);
    assertTrue(strlen($filename) === 1);
    assertEquals(Filename_Shema_Flag::array_option_short_id[Filename_Shema_Flag::default_flag_if_no_options_selected], $filename);
  }


  public function test_convert_data_to_filename4() : void {
    $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->ui_data5);
    $filename = Filename_Shema_Flag::convert_data_to_filename($converted_ui_data);
    assertIsString($filename);
    assertNotEquals("", $filename);
  }


  public function test_convert_data_to_filename_with_wrong_ui_data1() : void {
    $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->wrong_ui_data4);
    $this->expectException(Shema_Exception::class);
    Filename_Shema_Flag::convert_data_to_filename($converted_ui_data);
  }


  public function test_convert_data_to_filename_with_wrong_ui_data2() : void {
    $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->wrong_ui_data8);
    $this->expectException(Shema_Exception::class);
    Filename_Shema_Flag::convert_data_to_filename($converted_ui_data);
  }


  public function test_convert_filename_to_data1() : void {
    $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->ui_data1);
    $filename = Filename_Shema_Flag::convert_data_to_filename($converted_ui_data);
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($filename);
    assertIsArray($data_from_filename);
    $key = current(Filename_Shema_Flag::array_ui_data_key);
    assertTrue(isset($data_from_filename[$key]));
    assertIsArray($data_from_filename[$key]);

    # assert amount of options in ui-data and options in result data are equal
    assertTrue(count($this->ui_data1[$key]) >= count($data_from_filename[$key]));

    # check if all required sub-data-elements are contained
    foreach(Filename_Shema_Flag::array_ui_data_key_sub_data as $key => $array_keys_sub){
      if(array_search($key,$data_from_filename)!==false){
        foreach($array_keys_sub as $key_sub){
          assertTrue(array_key_exists($key_sub, $data_from_filename) !== false);
          assertNotEmpty($data_from_filename[$key_sub]);
        }
      }
    }

    # compare data from filename with source ui data
    foreach($data_from_filename as $key => $value){
      $found_key_for_value = array_search($value, $this->ui_data1);
      assertTrue($found_key_for_value!==false);
      assertEquals($found_key_for_value,$key);
    }
  }


  public function test_convert_filename_to_data2() : void {
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->filename1);
    assertIsArray($data_from_filename);
    $key = current(Filename_Shema_Flag::array_ui_data_key);
    assertIsArray($data_from_filename[$key]);
    assertEmpty($data_from_filename[$key]);
  }


  public function test_convert_filename_to_data3() : void {
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->filename2);
    assertIsArray($data_from_filename);
    $main_key = current(Filename_Shema_Flag::array_ui_data_key);
    assertCount(3, $data_from_filename);
    assertCount(4, $data_from_filename[$main_key]);

    # check if all required sub-data-elements are contained
    foreach(Filename_Shema_Flag::array_ui_data_key_sub_data as $key => $array_keys_sub){
      if(array_search($key,$data_from_filename[$main_key])!==false){
        foreach($array_keys_sub as $key_sub){
          assertTrue(array_key_exists($key_sub, $data_from_filename) !== false);
          if($key_sub==="Sub_Data_Flag_Depends_On_Expansion" || $key_sub==="Sub_Data_Flag_Depends_On_Content"){
            assertIsArray($data_from_filename[$key_sub]);
          }
          else {
            assertIsString($data_from_filename[$key_sub]);
          }
          assertNotEmpty($data_from_filename[$key_sub]);
        }
      }
    }
  }


  public function test_convert_filename_to_data4() : void {
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->filename3);
    assertIsArray($data_from_filename);
    assertCount(1, $data_from_filename);
    $main_key = current(Filename_Shema_Flag::array_ui_data_key);
    assertIsArray($data_from_filename[$main_key]);
    assertCount(1, $data_from_filename[$main_key]);
    assertTrue(current($data_from_filename[$main_key]) === "option_install_in_overrides");
  }


  public function test_convert_filename_to_data5() : void {
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->filename4);
    assertIsArray($data_from_filename);
    assertCount(2, $data_from_filename);
    $main_key = current(Filename_Shema_Flag::array_ui_data_key);
    assertIsArray($data_from_filename[$main_key]);
    assertCount(1, $data_from_filename[$main_key]);
    assertContains("option_depends_on_content",$data_from_filename[$main_key]);
  }


  public function test_convert_filename_to_data6() : void {
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->filename5);
    assertIsArray($data_from_filename);
    assertCount(2, $data_from_filename);
    $main_key = current(Filename_Shema_Flag::array_ui_data_key);
    assertIsArray($data_from_filename[$main_key]);
    assertCount(1, $data_from_filename[$main_key]);
    assertContains("option_depends_on_expansion",$data_from_filename[$main_key]);
    assertEquals($data_from_filename["Sub_Data_Flag_Depends_On_Expansion"], ["sp09"]);
  }


  public function test_convert_filename_to_data7() : void {
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->filename6);
    assertIsArray($data_from_filename);
    assertCount(2, $data_from_filename);
    $main_key = current(Filename_Shema_Flag::array_ui_data_key);
    assertIsArray($data_from_filename[$main_key]);
    assertCount(1, $data_from_filename[$main_key]);
    assertContains("option_depends_on_content",$data_from_filename[$main_key]);
    assertEquals($data_from_filename["Sub_Data_Flag_Depends_On_Content"], $this->ui_data5["Sub_Data_Flag_Depends_On_Content"]);
  }


  public function test_convert_filename_to_data_with_wrong_data1() : void {
    $this->expectException(Shema_Exception::class);
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->wrong_filename1);
    $main_key = current(Filename_Shema_Flag::array_ui_data_key);
    assertCount(3,$data_from_filename);
    assertCount(2,$data_from_filename[$main_key]);
    assertFalse(in_array("no_flag_option_selected", $data_from_filename[$main_key]));
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEquals("", $output);
    assertNotEmpty($data_from_filename);
  }


  public function test_convert_filename_to_data_with_wrong_data2() : void {
    $this->expectException(Shema_Exception::class);
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->wrong_filename2);
    assertIsArray($data_from_filename);
    assertCount(2, $data_from_filename);
    $main_key = current(Filename_Shema_Flag::array_ui_data_key);
    assertIsArray($data_from_filename[$main_key]);
    assertCount(1, $data_from_filename[$main_key]);
    assertContains("option_depends_on_expansion",$data_from_filename[$main_key]);
    assertTrue($data_from_filename["Sub_Data_Flag_Depends_On_Expansion"] === "sp07");
  }


  public function test_convert_filename_to_data_with_wrong_data3() : void {
    $this->expectException(Shema_Exception::class);
    $result = Filename_Shema_Flag::convert_filename_to_data($this->wrong_filename3);
    $main_key = current(Filename_Shema_Flag::array_ui_data_key);
    assertCount(3, $result);
    assertCount(3, $result[$main_key]);
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEquals("", $output);
  }


  public function test_convert_filename_to_data_with_wrong_data4() : void {
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->wrong_filename4);
    $main_key = current(Filename_Shema_Flag::array_ui_data_key);
    assertCount(2, $data_from_filename);
    assertCount(2, $data_from_filename[current(Filename_Shema_Flag::array_ui_data_key)]);
    assertFalse(in_array("option_depends_on_content", $data_from_filename[$main_key]));
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEquals("", $output);
    assertNotEmpty($data_from_filename);
  }


  public function test_convert_filename_to_data_with_wrong_data5() : void {
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->wrong_filename5);
    $main_key = current(Filename_Shema_Flag::array_ui_data_key);
    assertCount(2, $data_from_filename);
    assertCount(2, $data_from_filename[current(Filename_Shema_Flag::array_ui_data_key)]);
    assertFalse(in_array("option_depends_on_expansion", $data_from_filename[$main_key]));
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEquals("", $output);
    assertNotEmpty($data_from_filename);
  }


  public function test_convert_filename_to_data_with_wrong_data6() : void {
    $this->expectException(Shema_Exception::class);
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->wrong_filename6);
    $main_key = current(Filename_Shema_Flag::array_ui_data_key);
    assertCount(3, $data_from_filename);
    assertCount(4, $data_from_filename[$main_key]);
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEquals("", $output);
    assertNotEmpty($data_from_filename);
  }


  public function test_convert_filename_to_data_with_wrong_data7() : void {
    $this->expectException(Shema_Exception::class);
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->wrong_filename7);
    $main_key = current(Filename_Shema_Flag::array_ui_data_key);
    assertCount(2, $data_from_filename);
    assertCount(2, $data_from_filename[$main_key]);
    assertFalse(in_array("option_depends_on_content", $data_from_filename[$main_key]));
    assertFalse(in_array("Sub_Data_Flag_Depends_On_Content", $data_from_filename));
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEquals("", $output);
    assertNotEmpty($data_from_filename);
  }


  public function test_convert_filename_to_data_with_wrong_data8() : void {
    $this->expectException(Shema_Exception::class);
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->wrong_filename8);
    $main_key = current(Filename_Shema_Flag::array_ui_data_key);
    assertCount(3, $data_from_filename);
    assertCount(4, $data_from_filename[$main_key]);
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEquals("", $output);
    assertNotEmpty($data_from_filename);
  }


  public function test_print_filename_data_for_ui() : void {
    $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->ui_data1);
    $filename = Filename_Shema_Flag::convert_data_to_filename($converted_ui_data);
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($filename);
    Filename_Shema_Flag::print_filename_data_for_ui($data_from_filename);
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEquals("", $output);
  }


  public function test_print_filename_shema_input_for_ui() : void {
    Filename_Shema_Flag::print_filename_shema_input_for_ui(0);
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEmpty($output);
  }

  public function test_print_filename_shema_search_input_for_ui() : void {
    Filename_Shema_Flag::print_filename_shema_search_input_for_ui(0);
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEmpty($output);
  }

}

?>