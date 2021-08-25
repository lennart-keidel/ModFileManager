<?php

abstract class Filename_Shema_Installation_Date extends Compareable_Date_Operand implements I_Filename_Shema {

  public const array_ui_data_key = [
    self::class
  ];

  # format-string to use with printf to print in ui
  private const string_ui_format = "<span>%s</span>";

  # input shema template for ui
  private const input_shema_template = '
    <div class="container_label_and_input">
      <label for="'.self::class.'%1$d">Installationsdatum</label>
      <input class="%4$s%1$d" id="'.self::class.'%1$d" type="date" name="%2$s[%1$d]['.self::class.']" value="%3$s" required>
    </div>
  ';

  # input shema template for search ui
  private const search_input_shema_template = '
    <div class="container_label_and_input additional_input_root %4$s_root%1$d">
      <label for="'.self::class.'%1$d">Installationsdatum</label>
      <select class="%4$s_operand%1$d %4$s%1$d" id="'.self::class.'_operand%1$d" name="%2$s[%1$d]['.Ui::ui_search_data_key_operand_root.']['.self::class.'][]">
        %5$s
      </select>
      <input class="%4$s%1$d" id="'.self::class.'%1$d" type="date" name="%2$s[%1$d]['.Ui::ui_search_data_key_value_root.']['.self::class.'][]" value="%3$s" required>
      %6$s
    </div>
  ';

  # regex format for input/output date
  private const regex_date_io = "/^(20[1-9][0-9]-(0[1-9]|1[0-2])-([0][1-9]|[12][0-9]|3[01]))$/";

  # regex format for filename date
  private const regex_date_filename = "/^([0][1-9]|[12][0-9]|3[01])(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[1-9][0-9]$/";

  # date format string for input date
  private const date_format_io = "Y-m-d";

  # date format string for filename date
  private const date_format_filename = "dMy";


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

    $installation_date = current($data_converted);

    # error if patch level not matching regex input format
    if(preg_match(self::regex_date_io,$installation_date) !== 1){
      throw new Shema_Exception("Fehler beim Einlesen der Daten. Das eingegebene Installationsdatum ist nicht gültig.\\nDatum Eingabe-String: '".$installation_date."'");
    }

    # create datetime-object from input date
    # use datetime-object to be unix-epoch error safe
    $date_time_object = @DateTime::createFromFormat(self::date_format_io, $installation_date);

    # format date
    $formated_date = @$date_time_object->format(self::date_format_filename);

    # error if
    # datetime-object is false
    # or formated date is not matching the regex output format
    # or formating datetime-object back to original date format is not equal to the original date
    if($date_time_object === false || preg_match(self::regex_date_filename, $formated_date) !== 1 || $date_time_object->format(self::date_format_io) !== $installation_date){
      throw new Shema_Exception("Fehler beim Verarbeiten der Daten. Das eingegebene Installationsdatum konnte nicht ohne Fehler umformatiert werden.\\nDatum Eingabe-String: '".$installation_date."'");
    }

    return $formated_date;
  }


  # reverse process: converting filename back to data
  public static function convert_filename_to_data(string $filename_part) : array {

    # error if patch level not matching regex pattern
    if(preg_match(self::regex_date_filename,$filename_part) !== 1){
      throw new Shema_Exception("Fehler beim Auslesen der Daten. Das ausgelesene Installationsdatum ist nicht gültig.\\nDatum Eingabe-String: '".$filename_part."'");
    }

    # create datetime-object from filename date
    # use datetime-object to be unix-epoch error safe
    $date_time_object = DateTime::createFromFormat(self::date_format_filename, $filename_part);

    # format date
    $formated_date = @$date_time_object->format(self::date_format_io);

    # error if
    # datetime-object is false
    # or formated date is not matching the regex output format
    # or formating datetime-object back to original date format is not equal to the original date
    if($date_time_object === false || preg_match(self::regex_date_io, $formated_date) !== 1 || $date_time_object->format(self::date_format_filename) !== $filename_part){
      throw new Shema_Exception("Fehler beim Auslesen der Daten. Das ausgelesene Installationsdatum ist nicht gültig.\\nDatum Eingabe-String: '".$filename_part."'");
    }

    # return array in format of original ui data
    return [ current(self::array_ui_data_key) => $formated_date ];
  }


  # print converted data from filename to ui
  public static function print_filename_data_for_ui(array $filename_data) : void {
    # print data from filename to ui by formated string
    printf(self::string_ui_format, current($filename_data));
  }


  # print filename shema input to ui
  public static function print_filename_shema_input_for_ui(int $index) : void {
    printf(self::input_shema_template, $index, Ui::ui_data_key_root, (new DateTime())->format('Y-m-d'), self::class);
  }


  # print filename shema search input to ui
  public static function print_filename_shema_search_input_for_ui(int $index) : void {
    $operand_select_option_html = Ui::generate_search_operand_select_options_ui(self::class);
    $additional_search_buttons = Ui::generate_additional_search_buttons_ui(self::class);
    printf(self::search_input_shema_template, $index, Ui::ui_search_data_key_root, (new DateTime())->format('Y-m-d'), self::class, $operand_select_option_html, $additional_search_buttons);
  }


  # get target path considering the conditions of this shema input
  public static function get_target_path_by_condition(array $data_for_one_filename, string $source_path) : array {
    $path_result = "";
    $success_heading = "";
    $error_heading = "";
    return [$path_result, $success_heading, $error_heading];
  }

}

?>