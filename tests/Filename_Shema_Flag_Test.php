<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertContains;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertEquals;
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
  protected $wrong_ui_data1 = [];
  protected $wrong_ui_data2 = [];
  protected $wrong_ui_data3 = [];
  protected $wrong_ui_data4 = [];
  protected $wrong_ui_data5 = [];
  protected $wrong_ui_data6 = [];
  protected $wrong_ui_data7 = [];
  protected $filename1 = "";
  protected $filename2 = "";
  protected $filename3 = "";
  protected $filename4 = "";
  protected $filename5 = "";
  protected $wrong_filename1 = "";
  protected $wrong_filename2 = "";
  protected $wrong_filename3 = "";
  protected $wrong_filename4 = "";

  # set up ui data with realistic data
  protected function setUp() : void {




    ## ---------------- DISABLE TESTS IN THIS FILE -----------------------
    // $this->markTestSkipped("Dieser Test ist deaktiviert.");


    $this->ui_data1 = [
      "select_shema_categorie" => "Tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
      "date_shema_installation_date" => "2020-10-29",
      "url_shema_flag_option_depends_on_mod_data" => "https://www.php.net/manual/en/function.printf",
      "select_flag_data_depends_on_expansion" => "ep01",
      "checkbox_shema_flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion"
      ],
      "url_flag_data_depends_on_content" => "https://modthesims.info/d/638203/broadcaster-a-custom-stereo-music-utility-updated-27-march-2020.html"
    ];

    $this->ui_data2 = [
      "select_shema_categorie" => "Tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
      "date_shema_installation_date" => "2020-10-29",
      "url_shema_flag_option_depends_on_mod_data" => "https://www.php.net/manual/en/function.printf",
      "select_flag_data_depends_on_expansion" => "ep11",
      "checkbox_shema_flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion",
        "option_install_in_packages",
        "option_is_essential"
      ],
      "url_flag_data_depends_on_content" => "https://modthesims.info/d/638203/broadcaster-a-custom-stereo-music-utility-updated-27-march-2020.html"
    ];

    $this->ui_data3 = [
      "select_shema_categorie" => "Tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
      "date_shema_installation_date" => "2020-10-29",
      "url_shema_flag_option_depends_on_mod_data" => "https://www.php.net/manual/en/function.printf",
      "select_flag_data_depends_on_expansion" => "sp09",
      "checkbox_shema_flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion",
        "option_install_in_overrides",
        "option_is_essential"
      ],
      "url_flag_data_depends_on_content" => "https://modthesims.info/d/638203/broadcaster-a-custom-stereo-music-utility-updated-27-march-2020.html"
    ];

    $this->ui_data4 = [
      "select_shema_categorie" => "Tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
      "date_shema_installation_date" => "2020-10-29",
      "url_shema_flag_option_depends_on_mod_data" => "https://www.php.net/manual/en/function.printf",
      "checkbox_shema_flag" => [

      ]
    ];

    # "option_install_in_overrides" and "option_install_in_packages" are selected, which is restricted
    $this->wrong_ui_data1 = [
      "select_shema_categorie" => "Tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
      "date_shema_installation_date" => "2020-10-29",
      "url_shema_flag_option_depends_on_mod_data" => "https://www.php.net/manual/en/function.printf",
      "select_flag_data_depends_on_expansion" => "ep01",
      "checkbox_shema_flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion",
        "option_install_in_overrides",
        "option_install_in_packages",
        "option_is_essential"
      ],
      "url_flag_data_depends_on_content" => "https://modthesims.info/d/638203/broadcaster-a-custom-stereo-music-utility-updated-27-march-2020.html"
    ];


    # "option_depends_on_content" misses data
    $this->wrong_ui_data2 = [
      "select_shema_categorie" => "Tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
      "date_shema_installation_date" => "2020-10-29",
      "url_shema_flag_option_depends_on_mod_data" => "https://www.php.net/manual/en/function.printf",
      "select_flag_data_depends_on_expansion" => "ep01",
      "checkbox_shema_flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion",
        "option_install_in_packages",
        "option_is_essential"
      ]
    ];


    # "option_depends_on_expansion" misses data
    $this->wrong_ui_data3 = [
      "select_shema_categorie" => "Tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
      "date_shema_installation_date" => "2020-10-29",
      "url_shema_flag_option_depends_on_mod_data" => "https://www.php.net/manual/en/function.printf",
      "checkbox_shema_flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion",
        "option_install_in_packages",
        "option_is_essential"
      ],
      "url_flag_data_depends_on_content" => "https://modthesims.info/d/638203/broadcaster-a-custom-stereo-music-utility-updated-27-march-2020.html"
    ];


    # "option_depends_on_expansion" wrong data
    $this->wrong_ui_data4 = [
      "select_shema_categorie" => "Tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
      "date_shema_installation_date" => "2020-10-29",
      "url_shema_flag_option_depends_on_mod_data" => "https://www.php.net/manual/en/function.printf",
      "select_flag_data_depends_on_expansion" => "sp99",
      "checkbox_shema_flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion",
        "option_install_in_packages",
        "option_is_essential"
      ],
      "url_flag_data_depends_on_content" => "https://modthesims.info/d/638203/broadcaster-a-custom-stereo-music-utility-updated-27-march-2020.html"
    ];


    # "url_flag_data_depends_on_content" not existing website
    $this->wrong_ui_data5 = [
      "select_shema_categorie" => "Tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
      "date_shema_installation_date" => "2020-10-29",
      "url_shema_flag_option_depends_on_mod_data" => "https://www.php.net/manual/en/function.printf",
      "select_flag_data_depends_on_expansion" => "sp02",
      "checkbox_shema_flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion",
        "option_install_in_packages",
        "option_is_essential"
      ],
      "url_flag_data_depends_on_content" => "https://potato-ballad-sims.tumblr.com/post/6175797327"
    ];


    # "checkbox_shema_flag" contains invalid flag
    $this->wrong_ui_data6 = [
      "select_shema_categorie" => "Tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
      "date_shema_installation_date" => "2020-10-29",
      "url_shema_flag_option_depends_on_mod_data" => "https://www.php.net/manual/en/function.printf",
      "checkbox_shema_flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion",
        "option_install_in_packages",
        "option_is_e"
      ],
      "url_flag_data_depends_on_content" => "https://modthesims.info/d/638203/broadcaster-a-custom-stereo-music-utility-updated-27-march-2020.html"
    ];


    # "checkbox_shema_flag" contains double flag
    $this->wrong_ui_data7 = [
      "select_shema_categorie" => "Tuning",
      "text_shema_description" => "somtehing to do with this",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/617579732777795584",
      "date_shema_installation_date" => "2020-10-29",
      "url_shema_flag_option_depends_on_mod_data" => "https://www.php.net/manual/en/function.printf",
      "checkbox_shema_flag" => [
        "option_depends_on_content",
        "option_depends_on_expansion",
        "option_install_in_packages",
        "option_install_in_packages",
      ],
      "url_flag_data_depends_on_content" => "https://modthesims.info/d/638203/broadcaster-a-custom-stereo-music-utility-updated-27-march-2020.html"
    ];


    $this->filename1 = "I";

    $this->filename2 = "O_D7qcvl_Eep11_V";

    $this->filename3 = "O";

    $this->filename4 = "D7qcvl";

    $this->filename5 = "Esp09";


    # empty flag, that only is valid if it's the only flag
    $this->wrong_filename1 = "P_D7qcvl_Eep11_I";

    # double flag
    $this->wrong_filename2 = "Esp07_Eep01";

    # data for Flag that should have no data
    $this->wrong_filename3 = "P_D7qcvl_Eep11_Va";

    # not existing short link
    $this->wrong_filename4 = "P_D7qcva_Eep11_V";

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


  public function test_convert_data_to_filename_with_wrong_ui_data1() : void {
    $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->wrong_ui_data4);
    $this->expectException(Shema_Exception::class);
    Filename_Shema_Flag::convert_data_to_filename($converted_ui_data);
  }


  public function test_convert_data_to_filename_with_wrong_ui_data2() : void {
    $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->wrong_ui_data5);
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
          assertIsString($data_from_filename[$key_sub]);
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
  }



  public function test_convert_filename_to_data_with_wrong_data1() : void {
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->wrong_filename1);
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEquals("", $output);
    assertNotEmpty($data_from_filename);
  }


  public function test_convert_filename_to_data_with_wrong_data2() : void {
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->wrong_filename2);
    assertIsArray($data_from_filename);
    assertCount(2, $data_from_filename);
    $main_key = current(Filename_Shema_Flag::array_ui_data_key);
    assertIsArray($data_from_filename[$main_key]);
    assertCount(1, $data_from_filename[$main_key]);
    assertContains("option_depends_on_expansion",$data_from_filename[$main_key]);
  }


  public function test_convert_filename_to_data_with_wrong_data3() : void {
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->wrong_filename3);
    $output = $this->getActualOutput();
    assertIsString($output);
    assertNotEquals("", $output);
  }


  public function test_convert_filename_to_data_with_wrong_data4() : void {
    $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->wrong_filename4);
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
    var_dump($output);
    assertIsString($output);
    assertNotEquals("", $output);
  }

}

?>