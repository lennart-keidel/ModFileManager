<?php

abstract class File_Handler {

  public const fileextension_filter = ["sims3pack", "package"];
  public const path_seperator = "\\"; # path seperator, different in windows than in macOs or linux

  # get list of filenames and filter for fileextensions
  # return array in format: [path => [filename1, filename2]]
  public static function get_filename_list_from_path(string $path) : array {
    if(is_dir($path) === false){
      File_Handler_Exception::set_source_path($path);
      throw new File_Handler_Exception("Der angegebene Pfad ist kein Ordner. Der Pfad muss ein Ordner sein.");
      return [];
    }

    $result = [];
    $fileextension_filter = array_map("strtolower", File_Handler::fileextension_filter);

    # foreach file in directory
    foreach (new DirectoryIterator($path) as $file) {
      if(array_search(strtolower($file->getExtension()), $fileextension_filter) === false || $file->isDot() || $file->isDir()){
        continue;
      }

      $path = File_Handler::remove_trailing_slash_from_path($path);
      $result[$path][] = $file->getFilename();
    }

    # if result not empty
    # sort result
    if(empty($result) === false){
      sort($result[$path], SORT_NATURAL);
    }
    return $result;
  }


  # get list of filenames and filter for fileextensions
  # return array in format: [path => [filename1, filename2]]
  public static function get_filename_list_from_path_recursive(string $path_root) : array {
    if(is_dir($path_root) === false){
      File_Handler_Exception::set_source_path($path_root);
      throw new File_Handler_Exception("Der angegebene Pfad ist kein Ordner. Der Pfad muss ein Ordner sein.");
      return [];
    }

    $result = [];
    $fileextension_filter = array_map("strtolower", File_Handler::fileextension_filter);

    $directory_iteartor = new RecursiveDirectoryIterator($path_root, RecursiveDirectoryIterator::SKIP_DOTS);
    $file_iterator = new RecursiveIteratorIterator($directory_iteartor, RecursiveIteratorIterator::CHILD_FIRST);
    $previous_path_directory = $path_directory = "";

    # foreach file in directory recursive
    foreach ($file_iterator as $file) {

      # skip files not matching the file extension
      # skip directorys
      if(array_search(strtolower($file->getExtension()), $fileextension_filter) === false || $file->isDir()){
        continue;
      }

      $path_directory = File_Handler::remove_trailing_slash_from_path(dirname($file->getPathname()));
      $result[$path_directory][] = $file->getFilename();

      # if result not empty and current path is not previous path, to sort only if all files of this directory are done
      # sort result
      if($path_directory !== $previous_path_directory &&
      isset($result[$previous_path_directory]) &&
      empty($result[$previous_path_directory]) === false){
        sort($result[$previous_path_directory], SORT_NATURAL);
      }
      $previous_path_directory = $path_directory;
    }

    return $result;
  }


  # get fileextension from path without filename
  public static function get_fileextension_from_path(string $path) : string {
    $filename = basename($path);
    $pos_dot = strrpos($filename,".");
    if($pos_dot === 0 || $pos_dot === false){
      return "";
    }
    return substr($filename, $pos_dot+1);
  }


  # get filename from path without fileextension
  public static function get_filename_from_path_without_fileextension(string $path) : string {
    $filename = basename($path);
    $pos_dot = strrpos($filename,".");
    if($pos_dot === 0 || $pos_dot === false){
      return $filename;
    }
    return substr($filename, 0, $pos_dot);
  }


  # add an index to a filename
  public static function add_index_to_filename(string $path_filename, int $index) : string {
    if(strlen($path_filename) < 1 || (substr($path_filename,-1)==="/" || substr($path_filename,-1)==="\\")){
      return $path_filename;
    }
    if($file_extension = self::get_fileextension_from_path($path_filename)){
      $path_filename = preg_replace("/\.$file_extension$/", "", $path_filename);
    }
    return self::remove_index_from_filename($path_filename) . Create_Read_Filename_By_Shema::filename_shema_seperator . $index . (empty($file_extension) === false ? "." . $file_extension : "");
  }


  # remove an index from a filename
  public static function remove_index_from_filename(string $path_filename) : string {
    if(strlen($path_filename) < 1 || (substr($path_filename,-1)==="/" || substr($path_filename,-1)==="\\")){
      return $path_filename;
    }
    if($file_extension = self::get_fileextension_from_path($path_filename)){
      $path_filename = preg_replace("/\.$file_extension$/", "", $path_filename);
    }
    return preg_replace("/" . Create_Read_Filename_By_Shema::filename_shema_seperator . "[0-9]+$/","",$path_filename) . (empty($file_extension) === false ? "." . $file_extension : "");
  }


  # rename a file
  public static function rename_file(string $path_original_filename, string $path_new_filename) : void {

    # if original path is equal to the new path, skip the process
    if($path_original_filename===$path_new_filename){
      return;
    }

    # if new filename already exists
    # add failed filenames to global storage
    # throw custom exception
    $file_index = 2;
    while(is_file($path_new_filename)){

      # if original path is equal to the new path, skip the process
      if($path_original_filename===$path_new_filename){
        return;
      }

      # if file is identical to already existing file under this path
      # if original filename and new filename are equal
      if (filesize($path_new_filename) === filesize($path_original_filename) && md5_file($path_new_filename) === md5_file($path_original_filename)){
        Ui_Failed_Files::add_failed_filename_list([dirname($path_original_filename) => [basename($path_original_filename)]]);
        File_Handler_Exception::set_source_path($path_new_filename);
        throw new File_Handler_Exception("Fehler beim umbenennen der Dateien. Der Dateiname unter dem Pfad existiert bereits und ist identisch mit der bereits existierenden Datei. Die Datei wird daher nicht umbenannt.");
        return;
      }

      $path_new_filename = self::add_index_to_filename($path_new_filename,$file_index++);
    }

    # if original filename does not exist
    # add failed filenames to global storage
    # throw custom exception
    if(is_file($path_original_filename) === false){
      Ui_Failed_Files::add_failed_filename_list([dirname($path_original_filename) => [basename($path_original_filename)]]);
      File_Handler_Exception::set_source_path($path_original_filename);
      throw new File_Handler_Exception("Fehler beim umbenennen der Dateien. Die Datei existiert nicht oder ist keine gültige Datei.");
      return;
    }

    try {
      rename($path_original_filename, $path_new_filename);
    }

    catch(Exception $e){

      # add failed filenames to global storage
      Ui_Failed_Files::add_failed_filename_list([dirname($path_original_filename) => [basename($path_original_filename)]]);

      # if catched exception was not a custom exception
      # throw a custom exception
      if(($e instanceof File_Handler_Exception) === false){
        File_Handler_Exception::set_source_path($path_original_filename);
        throw new File_Handler_Exception("Fehler beim umbenennen der Dateien.\\nHier die PHP-Fehlermeldung: ".$e->getMessage());
      }
      return;
    }
  }


  # rename files form filename list
  # in format [ path => [ old_filename => new_filename ] ]
  public static function rename_file_from_filename_list(array $filename_list) : void {
    foreach($filename_list as $path => $array_filename){
      foreach($array_filename as $old_filename => $new_filename){
        File_Handler_Exception::set_source_path($path);
        File_Handler::rename_file($path.self::path_seperator.$old_filename, $path.self::path_seperator.$new_filename);
      }
    }
  }


  # remove trailing slash from path
  # works for backslash and slash
  public static function remove_trailing_slash_from_path(string $path) : string {
    while(strlen($path) > 1 && (substr($path,-1)==="/" || substr($path,-1)==="\\")){
      $path = substr($path, 0, strlen($path)-1);
    }
    return $path;
  }


}

?>