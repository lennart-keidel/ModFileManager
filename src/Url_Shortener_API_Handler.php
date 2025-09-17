<?php

use function PHPUnit\Framework\isEmpty;

abstract class Url_Shortener_API_Handler
{

  private const signature = 'f13712add9';
  public const api_url =  'https://lennart-keidel.de/url/yourls-api.php';
  public const short_id_base_url = 'https://lennart-keidel.de/url';

  # create short of url via own hosted url shortener
  public static function short_url(string $ipt_long_url): string
  {

    if (empty($ipt_long_url)) {
      throw new Shema_Exception("Fehler beim Erstellen der Short-Url.\\nDie eingegebene URL oder Text ist leer.\\n");
    }

    // Init the CURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, self::api_url);
    curl_setopt($ch, CURLOPT_HEADER, 0);            // No header in the result
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return, do not echo result
    curl_setopt($ch, CURLOPT_POST, 1);              // This is a POST request
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(     // Data to POST
      'signature' => self::signature,
      'action'   => 'shorturl',
      'format'   => 'json',
      'url'      => "$ipt_long_url"
    ));

    // Fetch and return content
    $response = curl_exec($ch);
    curl_close($ch);

    # deocode json respone
    $data = @json_decode($response);

    # error if empty response and not valid
    if (empty($response)) {
      if ($response_code = self::get_http_response_code(self::api_url)) {
        throw new Shema_Exception("Fehler beim Erstellen der Short-Url.\\nUrl-Shortener API unter: '" . self::api_url . "' gibt HTTP-Response-Code $response_code zurück. Die Url zum Url-Shortener API funktioniert nicht mehr.\\n");
      } else {
        throw new Shema_Exception("Fehler beim Erstellen der Short-Url.\\nUrl-Shortener API unter: '" . self::api_url . "' gibt keinen eine leere Antwort zurück. Die Url zum Url-Shortener API funktioniert nicht mehr.\\n");
      }
    }

    # error if url-API response contains error
    if (isset($data->errorCode)) {
      $message = "Fehler beim Erstellen der Short-Url.\\nEingegebene Url: '" . $ipt_long_url . "'\\nError-Code von Url-Api: " . $data->errorCode;
      if (isset($data->message)) {
        $message .= "\\nNachricht von Url-API: '" . $data->message . "'";
      }
      throw new Shema_Exception($message);
    }

    # error if not object or required key not existing or empty
    if (!is_object($data) || !isset($data->url->keyword) || empty($data->url->keyword)) {
      throw new Shema_Exception("Fehler beim Erstellen der Short-Url. Keine gültige Antwort von Url-Api erhalten.\\nEingegebene Url: '" . $ipt_long_url . "'\\nServer-Response: '" . $response . "'");
    }

    # cache short url with long url in session
    self::cache_result_in_session($data->url->keyword, $ipt_long_url);

    # return url short id
    return $data->url->keyword;
  }


  # get long version of url via short url from own hosted url shortener
  # reverse process of short_url
  public static function expand_url(string $ipt_short_url): string
  {

    # return cached value if existing
    $cached_result = self::get_cached_result_from_session($ipt_short_url);
    if (empty($cached_result) === false) {
      return $cached_result;
    }

    // Init the CURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, self::api_url);
    curl_setopt($ch, CURLOPT_HEADER, 0);            // No header in the result
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return, do not echo result
    curl_setopt($ch, CURLOPT_POST, 1);              // This is a POST request
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(     // Data to POST
      'signature' => self::signature,
      'action'   => 'expand',
      'format'   => 'json',
      'shorturl' => "$ipt_short_url"
    ));

    // Fetch and return content
    $response = curl_exec($ch);
    curl_close($ch);

    // Do something with the result. Here, we echo the long URL
    $data = @json_decode($response);

    # error if empty response and not valid
    if (empty($response)) {
      if ($response_code = self::get_http_response_code(self::api_url)) {
        throw new Shema_Exception("Fehler beim Erstellen der Short-Url.\\nUrl-Shortener API unter: '" . self::api_url . "' gibt HTTP-Response-Code $response_code zurück. Die Url zum Url-Shortener API funktioniert nicht mehr.\\n");
      } else {
        throw new Shema_Exception("Fehler beim Erstellen der Short-Url.\\nUrl-Shortener API unter: '" . self::api_url . "' gibt eine leere Antwort ohne HTTP-Response-Code zurück. Die Url zum Url-Shortener API funktioniert nicht mehr.\\n");
      }
    }

    # error if url-API response contains error
    if (isset($data->errorCode)) {
      $message = "Fehler beim Abrufen der originalen-Url durch die Short-Url-ID. Der Link ist nicht gültig. \\nShort-Url: '" . $ipt_short_url . "'\\nError-Code von Url-Api: " . $data->errorCode;
      if (isset($data->message)) {
        $message .= "\\nNachricht von Url-API: '" . $data->message . "'";
      }
      throw new Shema_Exception($message);
    }

    # error if not object or required key not existing or empty
    if (!is_object($data) || !isset($data->longurl) || empty($data->longurl)) {
      throw new Shema_Exception("Fehler beim Abrufen der Short-Url durch die Short-Url-ID. Der Link ist nicht gültig. Keine gültige Antwort von Url-Api erhalten.\\nShort-Url: '" . $ipt_short_url . "'\\nServer-Response: '" . $response . "'");
    }

    # cache short url and value in session
    self::cache_result_in_session($ipt_short_url, $data->longurl);

    return $data->longurl;
  }


  # store a text in a url shortener
  # url encodes the text
  public static function short_text(string $original_text): string
  {
    $short_url = "";
    if (!empty($original_text)) {
      $encode = rawurlencode($original_text);
      $short_url = self::short_url($encode);
    }
    return $short_url;
  }


  # expand a text previously stored in url shortener
  # decodes the urlencoded text
  public static function expand_text(string $short_url): string
  {
    $decode = "";
    if (!empty($short_url)) {
      $expand = self::expand_url($short_url);
      $decode = rawurldecode($expand);
    }
    return $decode;
  }


  # store a result in session as cache
  public static function cache_result_in_session(string $short_url, string $value): void
  {
    $_SESSION[Ui::ui_url_api_cache_data_key_root][$short_url] = $value;
  }


  # get a cached result from session
  public static function get_cached_result_from_session(string $short_url): string
  {
    return array_key_exists(Ui::ui_url_api_cache_data_key_root, $_SESSION) && array_key_exists($short_url, $_SESSION[Ui::ui_url_api_cache_data_key_root]) === true ? $_SESSION[Ui::ui_url_api_cache_data_key_root][$short_url] : "";
  }


  # get http response code via curl
  # works with redirects
  public static function get_http_response_code(string $url, bool $followredirects = true): int
  {
    // returns int responsecode, or false (if url does not exist or connection timeout occurs)
    // NOTE: could potentially take up to 0-30 seconds , blocking further code execution (more or less depending on connection, target site, and local timeout settings))
    // if $followredirects == false: return the FIRST known httpcode (ignore redirects)
    // if $followredirects == true : return the LAST  known httpcode (when redirected)
    if (! $url || ! is_string($url)) {
      return 404;
    }
    $ch = @curl_init($url);
    if ($ch === false) {
      return 404;
    }
    @curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
    @curl_setopt($ch, CURLOPT_NOBODY, true);    // dont need body
    @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    // catch output (do NOT print!)
    if ($followredirects) {
      @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      @curl_setopt($ch, CURLOPT_MAXREDIRS, 10);  // fairly random number, but could prevent unwanted endless redirects with followlocation=true
    } else {
      @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    }
    //      @curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,5);   // fairly random number (seconds)... but could prevent waiting forever to get a result
    //      @curl_setopt($ch, CURLOPT_TIMEOUT        ,6);   // fairly random number (seconds)... but could prevent waiting forever to get a result
    //      @curl_setopt($ch, CURLOPT_USERAGENT      ,"Mozilla/5.0 (Windows NT 6.0) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1");   // pretend we're a regular browser
    @curl_exec($ch);
    if (@curl_errno($ch)) {   // should be 0
      @curl_close($ch);
      return 404;
    }
    $code = @curl_getinfo($ch, CURLINFO_HTTP_CODE); // note: php.net documentation shows this returns a string, but really it returns an int
    @curl_close($ch);
    return $code;
  }


  # test if website exists by checking the http-response-code
  public static function test_if_url_is_valid(string $url): bool
  {
    $response_code = self::get_http_response_code($url);
    return $response_code > 100 && $response_code < 300;
  }
}
