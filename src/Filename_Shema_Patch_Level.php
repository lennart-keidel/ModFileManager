<?php

abstract class Filename_Shema_Patch_Level extends Compareable_Number_Operand implements I_Filename_Shema {

  public const array_ui_data_key = [
    self::class
  ];

  # format-string to use with printf to print in ui
  private const string_ui_format = "<span>%s</span>";

    # input shema template for ui
    private const input_shema_template = '
    <div class="container_label_and_input">
      <label for="'.self::class.'%1$d">Patch-Level</label>
      <select class="%3$s%1$d" id="'.self::class.'%1$d" name="%2$s[%1$d]['.self::class.']" required>
        <option value="1.70">1.70</option>
        <option value="1.69" selected>1.69</option>
        <option value="1.67">1.67</option>
        <option value="1.66">1.66</option>
        <option value="1.63">1.63</option>
        <option value="1.57">1.57</option>
        <option value="1.55">1.55</option>
        <option value="1.50">1.50</option>
        <option value="1.48">1.48</option>
        <option value="1.47">1.47</option>
        <option value="1.42">1.42</option>
        <option value="1.39">1.39</option>
        <option value="1.38">1.38</option>
        <option value="1.36">1.36</option>
        <option value="1.34">1.34</option>
        <option value="1.33">1.33</option>
        <option value="1.32">1.32</option>
        <option value="1.31">1.31</option>
        <option value="1.29">1.29</option>
        <option value="1.27">1.27</option>
        <option value="1.26">1.26</option>
        <option value="1.25">1.25</option>
        <option value="1.24">1.24</option>
        <option value="1.22">1.22</option>
        <option value="1.19">1.19</option>
        <option value="1.18">1.18</option>
        <option value="1.17">1.17</option>
        <option value="1.15">1.15</option>
        <option value="1.14">1.14</option>
        <option value="1.12">1.12</option>
        <option value="1.11">1.11</option>
        <option value="1.10">1.10</option>
        <option value="1.09">1.09</option>
        <option value="1.08">1.08</option>
        <option value="1.07">1.07</option>
        <option value="1.06">1.06</option>
        <option value="1.05">1.05</option>
        <option value="1.04">1.04</option>
        <option value="1.03">1.03</option>
        <option value="1.02">1.02</option>
        <option value="1.01">1.01</option>
        <option value="1.00">1.00</option>
      </select>
    </div>
  ';

  # input shema template for search ui
  private const search_input_shema_template = '
    <div class="container_label_and_input additional_input_root">
    <label for="'.self::class.'%1$d">Patch-Level</label>
      <select class="%3$s_operand%1$d %3$s%1$d" id="'.self::class.'%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]">
        %4$s
      </select>
      <select class="%3$s%1$d" id="'.self::class.'%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" required>
        <option value="1.70">1.70</option>
        <option value="1.69" selected>1.69</option>
        <option value="1.67">1.67</option>
        <option value="1.66">1.66</option>
        <option value="1.63">1.63</option>
        <option value="1.57">1.57</option>
        <option value="1.55">1.55</option>
        <option value="1.50">1.50</option>
        <option value="1.48">1.48</option>
        <option value="1.47">1.47</option>
        <option value="1.42">1.42</option>
        <option value="1.39">1.39</option>
        <option value="1.38">1.38</option>
        <option value="1.36">1.36</option>
        <option value="1.34">1.34</option>
        <option value="1.33">1.33</option>
        <option value="1.32">1.32</option>
        <option value="1.31">1.31</option>
        <option value="1.29">1.29</option>
        <option value="1.27">1.27</option>
        <option value="1.26">1.26</option>
        <option value="1.25">1.25</option>
        <option value="1.24">1.24</option>
        <option value="1.22">1.22</option>
        <option value="1.19">1.19</option>
        <option value="1.18">1.18</option>
        <option value="1.17">1.17</option>
        <option value="1.15">1.15</option>
        <option value="1.14">1.14</option>
        <option value="1.12">1.12</option>
        <option value="1.11">1.11</option>
        <option value="1.10">1.10</option>
        <option value="1.09">1.09</option>
        <option value="1.08">1.08</option>
        <option value="1.07">1.07</option>
        <option value="1.06">1.06</option>
        <option value="1.05">1.05</option>
        <option value="1.04">1.04</option>
        <option value="1.03">1.03</option>
        <option value="1.02">1.02</option>
        <option value="1.01">1.01</option>
        <option value="1.00">1.00</option>
      </select>
      %5$s
    </div>
  ';

  public const array_valid_patch_level = [
    "1.70",
    "1.69",
    "1.67",
    "1.66",
    "1.63",
    "1.57",
    "1.55",
    "1.50",
    "1.48",
    "1.47",
    "1.42",
    "1.39",
    "1.38",
    "1.36",
    "1.34",
    "1.33",
    "1.32",
    "1.31",
    "1.29",
    "1.27",
    "1.26",
    "1.25",
    "1.24",
    "1.22",
    "1.19",
    "1.18",
    "1.17",
    "1.15",
    "1.14",
    "1.12",
    "1.11",
    "1.10",
    "1.09",
    "1.08",
    "1.07",
    "1.06",
    "1.05",
    "1.04",
    "1.03",
    "1.02",
    "1.01",
    "1.00"
  ];


  # convert data collected from ui to usable data for following process
  public static function convert_ui_data_to_data(array $data_from_ui) : array {
    # filter data for this schema from whole ui data
    $key = current(self::array_ui_data_key);

    if(!isset($data_from_ui[$key])){
      throw new Shema_Exception("Fehler bei Verarbeitung der Daten.\\nFehlender Schlüssel in POST-Request: '$key'");
    }

    return [
      $data_from_ui[$key]
    ];
  }


  # convert data to filename part using this shema
  public static function convert_data_to_filename(array $data_converted) : string {

    $patch_level = current($data_converted);

    # error if patch level not matching patch level
    if(in_array($patch_level, self::array_valid_patch_level) === false){
      throw new Shema_Exception("Fehler beim Einlesen der Daten. Der eingegebene Patch-Level ist nicht gültig.\\nPatch-Level Eingabe-String: '".$patch_level."'");
    }

    return str_replace(".","",$patch_level);
  }


  # reverse process: converting filename back to data
  public static function convert_filename_to_data(string $filename_part) : array {

    # error if patch level not matching regex pattern
    if(in_array(substr($filename_part,0,1).".".substr($filename_part,1), self::array_valid_patch_level) === false){
      throw new Shema_Exception("Fehler beim Auslesen der Daten. Der ausgelesene Patch-Level ist nicht gültig.\\nPatch-Level Eingabe-String: '".$filename_part."'");
    }

    $converted_patch_level = substr($filename_part,0,1).".".substr($filename_part,1);

    # return array in format of original ui data
    return [ current(self::array_ui_data_key) => $converted_patch_level ];
  }


  # print converted data from filename to ui
  public static function print_filename_data_for_ui(array $filename_data) : void {
    # print data from filename to ui by formated string
    printf(self::string_ui_format, current($filename_data));
  }


  # print filename shema input to ui
  public static function print_filename_shema_input_for_ui(int $index) : void {
    printf(self::input_shema_template, $index, Ui::ui_data_key_root, self::class);
  }


  # print filename shema search input to ui
  public static function print_filename_shema_search_input_for_ui(int $index) : void {
    $operand_select_option_html = Ui::generate_search_operand_select_options_ui(self::class);
    $additional_search_buttons = Ui::generate_additional_search_buttons_ui(self::class);
    printf(self::search_input_shema_template, $index, Ui::ui_search_data_key_root, self::class, $operand_select_option_html, $additional_search_buttons);
  }

}

?>