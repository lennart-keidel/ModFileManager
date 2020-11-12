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
      $path_directory = dirname($file->getPathname());
      $result[$path_directory][] = $file->getFilename();
    }
    return $result;
  }


  # get fileextension from path without filename
  public static function get_fileextension_from_path(string $path) : string {
    $filename = basename($path);
    return substr($filename, strrpos($filename,".")+1);
  }


  # get filename from path without fileextension
  public static function get_filename_from_path_without_fileextension(string $path) : string {
    $filename = basename($path);
    return substr($filename, 0, strrpos($filename,"."));
  }





}

?>