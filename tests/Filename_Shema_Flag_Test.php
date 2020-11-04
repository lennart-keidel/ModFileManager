<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertNotEquals;

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
  protected $wrong_filename1 = "";
  protected $wrong_filename2 = "";

  # set up ui data with realistic data
  protected function setUp() : void {
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

    $this->filename1 = "I";

    $this->filename2 = "O_D7qcvl_Aep11_E";

    $this->filename3 = "O";

    $this->filename4 = "D7qcvl";

    $this->filename5 = "Asp09";

    # empty flag, that only is valid if it's the only flag
    $this->wrong_filename1 = "P_D7qcvl_Aep11_I";

    # data for Flag that should have no data
    $this->wrong_filename2 = "P_D7qcvl_Aep11_Ea";

    # not existing short link
    $this->wrong_filename2 = "P_D7qcva_Aep11_Ea";

  }


  public function test_convert_ui_data_to_data1() : void {
    $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->ui_data1);
    assertIsArray($converted_ui_data);
    assertIsArray($converted_ui_data[0]);
    assertIsArray($converted_ui_data["sub_data"]);
    assertCount(2, $converted_ui_data);
    $key = current(Filename_Shema_Flag::array_ui_data_key);
    assertEquals(count($this->ui_data1[$key]), count($converted_ui_data[0]));
    assertCount(2, $converted_ui_data["sub_data"]);
  }


  public function test_convert_ui_data_to_data2() : void {
    $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->ui_data4);
    assertIsArray($converted_ui_data);
    assertIsArray($converted_ui_data[0]);
    assertIsArray($converted_ui_data["sub_data"]);
    assertCount(2, $converted_ui_data);
    $key = current(Filename_Shema_Flag::array_ui_data_key);
    assertEquals(count($this->ui_data4[$key]), count($converted_ui_data[0]));
    assertCount(0, $converted_ui_data["sub_data"]);
  }

  // public function test_convert_ui_data_to_data_with_wrong_ui_data1() : void {
  //   $this->expectException(Shema_Exception::class);
  //   $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->wrong_ui_data1);
  // }


  // public function test_convert_data_to_filename() : void {
  //   $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->ui_data);
  //   $filename = Filename_Shema_Flag::convert_data_to_filename($converted_ui_data);
  //   assertIsString($filename);
  //   assertNotEquals("", $filename);
  // }


  // public function test_convert_data_to_filename_with_wrong_ui_data1() : void {
  //   $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->wrong_ui_data2);
  //   $this->expectException(Shema_Exception::class);
  //   Filename_Shema_Flag::convert_data_to_filename($converted_ui_data);
  // }


  // public function test_convert_data_to_filename_with_wrong_ui_data2() : void {
  //   $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->wrong_ui_data3);
  //   $this->expectException(Shema_Exception::class);
  //   Filename_Shema_Flag::convert_data_to_filename($converted_ui_data);
  // }


  // public function test_convert_filename_to_data() : void {
  //   $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->ui_data);
  //   $filename = Filename_Shema_Flag::convert_data_to_filename($converted_ui_data);
  //   $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($filename);
  //   assertIsArray($data_from_filename);
  //   assertCount(1,$data_from_filename);
  //   assertIsString(key($data_from_filename));
  //   assertIsString(current($data_from_filename));
  // }


  // public function test_convert_filename_to_data_with_wrong_data1() : void {
  //   $this->expectException(Shema_Exception::class);
  //   $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->wrong_filename1);
  // }


  // public function test_convert_filename_to_data_with_wrong_data2() : void {
  //   $this->expectException(Shema_Exception::class);
  //   $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($this->wrong_filename2);
  // }


  // public function test_print_filename_data_for_ui() : void {
  //   $converted_ui_data = Filename_Shema_Flag::convert_ui_data_to_data($this->ui_data);
  //   $filename = Filename_Shema_Flag::convert_data_to_filename($converted_ui_data);
  //   $data_from_filename = Filename_Shema_Flag::convert_filename_to_data($filename);
  //   Filename_Shema_Flag::print_filename_data_for_ui($data_from_filename);
  //   $output = $this->getActualOutput();
  //   assertIsString($output);
  //   assertNotEquals("", $output);
  // }

}

?>