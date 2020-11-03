<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertTrue;

# test class
class Url_Shortener_API_Handler_Test extends TestCase {

  private $array_url = [];
  private $array_wrong_url = [];

  # set up ui data with realistic data
  protected function setUp() : void {



    ## ---------------- DISABLE TESTS IN THIS FILE -----------------------
    $this->markTestSkipped("Dieser Test ist deaktiviert.");



    $this->array_url[] = "https://modthesims.info/d/638203/broadcaster-a-custom-stereo-music-utility-updated-27-march-2020.html";
    $this->array_url[] = "https://www.nraas.net/community/Overwatch";
    $this->array_url[] = "https://potato-ballad-sims.tumblr.com/post/617579732777795584";

    $this->array_wrong_url[] = ""; # only empty string is invalid for url-api

    $this->array_short_url[] = "1godx";
    $this->array_short_url[] = "https://lennart-keidel.de/url/3rfhp";
    $this->array_short_url[] = "https://lennart-keidel.de/url/ytrlb";

  }

  # test short url creation
  public function test_short_url() : void {
    foreach($this->array_url as $fe_url){
      $result_short_id = Url_Shortener_API_Handler::short_url($fe_url);
      $result_short_url = Url_Shortener_API_Handler::$short_id_base_url."/".$result_short_id;
      assertIsString($result_short_id);
      assertEquals(5, strlen($result_short_id));
      $response_code = Url_Shortener_API_Handler::get_http_response_code($result_short_url);
      assertTrue($response_code < 300 && $response_code > 100);
    }
  }


  # test short url creation with wrong data
  public function test_short_url_with_wrong_data1() : void {
    $this->expectException(Shema_Exception::class);
    Url_Shortener_API_Handler::short_url($this->array_wrong_url[0]);
  }


  # test short url expantion
  public function test_expand_url() : void {
    foreach($this->array_short_url as $key => $fe_url){
      $original_url = $this->array_url[$key];
      $result_url = Url_Shortener_API_Handler::expand_url($fe_url);
      assertEquals($original_url, $result_url);
    }
  }


  # test short url expantion with wrong data
  public function test_expand_url_with_wrong_data1() : void {
    $this->expectException(Shema_Exception::class);
    Url_Shortener_API_Handler::expand_url($this->array_wrong_url[0]);
  }


  # test get http response code
  public function test_get_http_response_code() : void {
    $url = "google.com";
    $response_code = Url_Shortener_API_Handler::get_http_response_code($url);
    assertTrue($response_code < 300 && $response_code > 100);
  }


  # test get http response code with wrong data
  public function test_get_http_response_code_with_wrong_data1() : void {
    $url = ""; # empty string
    $response_code = Url_Shortener_API_Handler::get_http_response_code($url);
    assertTrue($response_code > 300 || $response_code < 100);

    $url = "https://potato-ballad-sims.tumblr.com/post/61757973"; # not existing website
    $response_code = Url_Shortener_API_Handler::get_http_response_code($url);
    assertTrue($response_code > 300 || $response_code < 100);
  }

}

?>