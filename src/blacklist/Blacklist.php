<?php

abstract class Blacklist {

  public const json_key_link = "link";
  public const json_key_description = "description";

  private const ui_key_blacklist_save = "blacklist_save";
  private const ui_key_blacklist_mod_link = "blacklist_mod_link";
  private const ui_key_blacklist_description_text = "blacklist_description_text";

  private const template_blacklist_success_message = "<br><br><b style='color:green;'>Mod wurde erfolgreich auf die Blacklist gesetzt.</b>";
  private const template_blacklist_duplicate_link_message = "<br><br><b style='color:red;'>Es existiert bereits ein Eintrag mit diesem Link.</b>";

  private const template_blacklist_input = '
  <h3>Mod-Blacklisting</h3>
  <form class="" method="post" action="./blacklist.php">
    <div class="container_label_and_input">
    <label>Link zum Mod</label>
    <input type="link" class="%1$s" name="%1$s" required>
    <br>
    <br>
    <label>Begründung für Blacklisting, optional</label>
    <textarea class="%2$s" name="%2$s" cols="40" rows="5"></textarea>
    <br>
    <br>
    <button type="submit" class="%3$s" name="%3$s" value="Blacklisting speichern">Blacklisting speichern</button>
    </div>
  </form>
  <br>
  <br>
  <br>
  <br>
  <a href="./index.php"><button>Zurück zur Startseite</button></a>
  ';

  private const path_blacklist_json_file = "src/blacklist/mod_blacklist.json";


  # handle post input from blacklist site
  public static function handle_input() : void {
    if(empty($_POST) === false){
      $ret = self::set_blacklist_entry($_POST[self::ui_key_blacklist_mod_link], $_POST[self::ui_key_blacklist_description_text]);
      if($ret === true){
        self::print_blacklist_success_message();
      }
    }
  }


  # set blacklist entry in json file
  # error if blacklist file not existing, not readable or not valid
  # push changes to github
  public static function set_blacklist_entry(string $link, string $description) : bool {
    if(self::test_if_entry_exists($link) === true){
      self::print_blacklist_duplicate_link_message();
      return false;
    }
    $description = "\r\n".$description;
    $description = str_replace("\"", "\\\"", $description);
    $description = str_replace("\r", "\\r", $description);
    $description = str_replace("\n", "\\n", $description);
    $data = [[self::json_key_link => $link, self::json_key_description => $description]];
    $content = self::get_all_blacklist_entries();
    if(is_array($content) === false){
      Ui::print_error("Blacklisting-Datei konnte nicht gelesen werden.");
      return false;
    }
    file_put_contents(self::path_blacklist_json_file, json_encode(array_merge($content,$data)));
    Git_Auto_Pull_Push::push_blacklist_file();
    return true;
  }


  # get all blacklist entries
  # error if blacklist file not existing, not readable or not valid
  public static function get_all_blacklist_entries() : array {
    $content = @json_decode(@file_get_contents(self::path_blacklist_json_file), true);
    if(is_array($content) === false){
      Ui::print_error("Blacklisting-Datei konnte nicht gelesen werden.");
      return [];
    }
    return $content;
  }


  # if entry with same link exists
  # return true
  public static function test_if_entry_exists(string $link) : bool {
    $black_list = self::get_all_blacklist_entries();
    foreach($black_list as $key_current => $array_current){
      if($array_current["link"] == $link){
        return true;
      }
    }
    return false;
  }


  # print blacklist input html
  public static function print_blacklist_input() : void {
    printf(self::template_blacklist_input, self::ui_key_blacklist_mod_link, self::ui_key_blacklist_description_text, self::ui_key_blacklist_save);
  }


  # print blacklist success message
  public static function print_blacklist_success_message() : void {
    echo self::template_blacklist_success_message;
  }


  # print duplicate link message
  public static function print_blacklist_duplicate_link_message() : void {
    echo self::template_blacklist_duplicate_link_message;
  }





}

?>