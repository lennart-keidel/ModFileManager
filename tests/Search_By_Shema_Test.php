<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

# test class
class Search_Shema_Test extends TestCase {

  private static $search_input1 = [];

  public static function setUpBeforeClass() : void {
    self::$search_input1 = [
      "search_shema_connector" => "or",
      "select_shema_categorie" => "Tuning",
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
  }

  # test something
  public function test_check_if_filename_data_for_one_file_matches_search_input() : void {

  }

}

?>