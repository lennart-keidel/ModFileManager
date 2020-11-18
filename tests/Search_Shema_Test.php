<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertIsNotResource;
use function PHPUnit\Framework\assertTrue;

# test class
class Search_Shema_Test extends TestCase {

  private static $search_input1, $search_input2, $filename_data_for_one_file1, $filename_data_for_one_file2, $filename_data_for_one_file3, $filename_data_for_one_file4 = [];

  public static function setUpBeforeClass() : void {
    self::$search_input1 = [
      "search_shema_connector" => "or",
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

    self::$search_input2 = [
      "search_shema_connector" => "and",
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

    # every data matches search_input1 and search_input2
    self::$filename_data_for_one_file1 = [
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

    # two data match search_input1 and search_input2
    self::$filename_data_for_one_file2 = [
      "select_shema_categorie" => "option_tuning",
      "text_shema_description" => "some other description",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/asd",
      "date_shema_installation_date" => "2020-10-29",
      "select_flag_data_depends_on_expansion" => "ep09",
      "checkbox_shema_flag" => [
        "option_install_in_packages",
        "option_is_essential"
      ]
    ];

    # only one data matches search_input1 and search_input2
    self::$filename_data_for_one_file3 = [
      "select_shema_categorie" => "option_cc_buy",
      "text_shema_description" => "some other description",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/asd",
      "date_shema_installation_date" => "2020-11-12",
      "select_flag_data_depends_on_expansion" => "ep01",
      "checkbox_shema_flag" => [
        "option_install_in_packages",
        "option_is_essential"
      ]
    ];

    # no data matches search_input1 and search_input2
    self::$filename_data_for_one_file4 = [
      "select_shema_categorie" => "option_cc_buy",
      "text_shema_description" => "some other description",
      "url_shema_link" => "https://potato-ballad-sims.tumblr.com/post/asd",
      "date_shema_installation_date" => "2020-11-12",
      "select_flag_data_depends_on_expansion" => "ep11",
      "checkbox_shema_flag" => [
        "option_install_in_packages",
        "option_is_essential"
      ]
    ];
  }


  public function test_check_if_filename_data_for_one_file_matches_search_input_with_or_connector() : void {
    Search_Shema::set_search_ui_data(self::$search_input1);
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

  public function test_check_if_filename_data_for_one_file_matches_search_input_with_and_connector() : void {
    Search_Shema::set_search_ui_data(self::$search_input2);
    assertTrue(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file1));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file2));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file3));
    assertFalse(Search_Shema::check_if_filename_data_for_one_file_matches_search_input(self::$filename_data_for_one_file4));
  }

}

?>