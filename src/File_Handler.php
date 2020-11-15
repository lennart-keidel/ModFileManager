<?php

class File_Handler {

  public const fileextension_filter = ["sims3pack", "package"];

  # get list of filenames and filter for fileextensions
  # return array in format: [path => [filename1, filename2]]
  public static function get_filename_list_from_path(string $path) : array {
    $result = [];
    $fileextension_filter = array_map("strtolower", File_Handler::fileextension_filter);

    foreach (new DirectoryIterator($path) as $file) {
      if(array_search(strtolower($file->getExtension()), $fileextension_filter) === false
      || $file->isDot()
      || $file->isDir()){
        continue;
      }
      $path = File_Handler::remove_trailing_slash_from_path($path);
      $result[$path][] = $file->getFilename();
    }
    return $result;
  }


  # get list of filenames and filter for fileextensions
  # return array in format: [path => [filename1, filename2]]
  public static function get_filename_list_from_path_recursive(string $path_root) : array {
    $result = [];
    $fileextension_filter = array_map("strtolower", File_Handler::fileextension_filter);

    $directory_iteartor = new RecursiveDirectoryIterator($path_root, RecursiveDirectoryIterator::SKIP_DOTS);
    $file_iterator = new RecursiveIteratorIterator($directory_iteartor, RecursiveIteratorIterator::CHILD_FIRST);

    foreach ($file_iterator as $file) {
      if(array_search(strtolower($file->getExtension()), $fileextension_filter) === false || $file->isDir()){
        continue;
      }
      $path_directory = File_Handler::remove_trailing_slash_from_path(dirname($file->getPathname()));
      $result[$path_directory][] = $file->getFilename();
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


  # rename a file
  public static function rename_file(string $path_original_filename, string $path_new_filename) : void {
    if($path_original_filename===$path_new_filename){
      return;
    }
    if(is_file($path_new_filename)){
      File_Handler_Exception::append_source_path($path_new_filename);
      throw new File_Handler_Exception("Fehler beim umbenennen der Dateien. Der Dateiname unter dem Pfad existiert bereits und wird nicht umbennant, um die Datei nicht zu überschreiben.");
      return;
    }
    try {
      rename($path_original_filename, $path_new_filename);
    }
    catch(Exception $e){
      File_Handler_Exception::append_source_path($path_original_filename);
      throw new File_Handler_Exception($e->getMessage());
      return;
    }
  }


  # rename files form filename list
  # in format [ path => [ old_filename => new_filename ] ]
  public static function rename_file_from_filename_list(array $filename_list) : void {
    foreach($filename_list as $path => $array_filename){
      foreach($array_filename as $old_filename => $new_filename){
        File_Handler_Exception::set_source_path($path);
        File_Handler::rename_file($path."/".$old_filename, $path."/".$new_filename);
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