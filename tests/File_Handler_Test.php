<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertTrue;

# test class
class File_Handler_Test extends TestCase {

  private const path_temp_test_dir_root = "./temp_test_files";
  private const array_filename = [ "normal_file1.package", "normal_file2.Sims3Pack", "normal_file3.sims3pack", "wrong_file1.packag", "wrong_file2.sims3pac" ];
  private const array_path_temp_test_sub_dir = [
    File_Handler_Test::path_temp_test_dir_root."/sub_dir1",
    File_Handler_Test::path_temp_test_dir_root."/sub_dir2",
    File_Handler_Test::path_temp_test_dir_root."/sub_dir3",
    File_Handler_Test::path_temp_test_dir_root."/empty_dir"
  ];

  # set up ui data with realistic data
  public static function setUpBeforeClass() : void {

    # create test-directory root
    if(!is_dir(File_Handler_Test::path_temp_test_dir_root)){
      mkdir(File_Handler_Test::path_temp_test_dir_root);
    }

    # create test-sub-directory
    foreach(File_Handler_Test::array_path_temp_test_sub_dir as $path_sub_dir){
      if(!is_dir($path_sub_dir)){
        mkdir($path_sub_dir);
      }
    }

    # create test-files in sub directorys
    # not in directory "empty_dir"
    $iterator_directory = new RecursiveDirectoryIterator(File_Handler_Test::path_temp_test_dir_root, RecursiveDirectoryIterator::SKIP_DOTS);
    foreach($iterator_directory as $directory){
      if($directory->isDir() && strpos($directory->getPathname(), "empty_dir") === false){
        foreach(File_Handler_Test::array_filename as $filename){
          $path = $directory->getPathname()."/$filename";
          file_put_contents($path, "");
        }
      }
    }

    # create test-files in root directorys
    foreach(File_Handler_Test::array_filename as $filename){
      $path = File_Handler_Test::path_temp_test_dir_root."/$filename";
      file_put_contents($path, "");
    }
  }


  # set up ui data with realistic data
  public static function tearDownAfterClass(): void {

    # delete test files
    $it = new RecursiveDirectoryIterator(File_Handler_Test::path_temp_test_dir_root, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
    foreach($files as $file) {
        if ($file->isDir()){
            rmdir($file->getRealPath());
        } else {
            unlink($file->getRealPath());
        }
    }
    rmdir(File_Handler_Test::path_temp_test_dir_root);
  }


  public function test_get_filename_list_from_path() : void {
    $result = File_Handler::get_filename_list_from_path(File_Handler_Test::path_temp_test_dir_root);
    assertIsArray($result);
    assertCount(1, $result);

    $path = key($result);
    assertIsString($path);
    assertNotEmpty($path);
    assertTrue(is_dir($path));

    $array_filenames = current($result);
    assertIsArray($array_filenames);

    # test if only files with allowed fileextensions are contained
    # test if all files that should be contained are contained
    foreach (new DirectoryIterator(File_Handler_Test::path_temp_test_dir_root) as $file) {
      if($file->isDot()){
        continue;
      }
      $fileextension_filter = array_map("strtolower", File_Handler::fileextension_filter);
      if(array_search(strtolower($file->getExtension()), $fileextension_filter) === false){
        assertTrue(array_search($file->getFilename(), $array_filenames) === false);
      }
      else {
        assertTrue(array_search($file->getFilename(), $array_filenames) !== false);
      }
    }
  }



  public function test_get_filename_list_from_path_with_empty_dir() : void {
    $result = File_Handler::get_filename_list_from_path(File_Handler_Test::path_temp_test_dir_root."/empty_dir");
    assertIsArray($result);
    assertEmpty($result);
  }


  public function test_get_filename_list_from_path_recursive() : void {
    $result = File_Handler::get_filename_list_from_path_recursive(File_Handler_Test::path_temp_test_dir_root);
    assertIsArray($result);

    foreach($result as $path => $array_filenames){
      assertIsString($path);
      assertNotEmpty($path);
      assertTrue(is_dir($path));
      assertIsArray($array_filenames);

      # test if only files with allowed fileextensions are contained
      # test if all files that should be contained are contained
      foreach (new DirectoryIterator(File_Handler_Test::path_temp_test_dir_root) as $file) {
        if($file->isDot()){
          continue;
        }
        $fileextension_filter = array_map("strtolower", File_Handler::fileextension_filter);
        if(array_search(strtolower($file->getExtension()), $fileextension_filter) === false){
          assertTrue(array_search($file->getFilename(), $array_filenames) === false);
        }
        else {
          assertTrue(array_search($file->getFilename(), $array_filenames) !== false);
        }
      }
    }
  }


  public function test_get_filename_list_from_path_recursive_with_empty_dir() : void {
    $result = File_Handler::get_filename_list_from_path_recursive(File_Handler_Test::path_temp_test_dir_root."/empty_dir");
    assertIsArray($result);
    assertEmpty($result);
  }


  public function test_get_fileextension_from_path() : void {
    $path1 = "/a/b/a.txt";
    assertEquals(File_Handler::get_fileextension_from_path($path1), "txt");
    $path2 = "filename.a.b.txt";
    assertEquals(File_Handler::get_fileextension_from_path($path2), "txt");
  }


  public function test_get_filename_from_path_without_fileextension() : void {
    $path1 = "/a/b/filename.txt";
    assertEquals(File_Handler::get_filename_from_path_without_fileextension($path1), "filename");
    $path2 = "filename.a.b.txt";
    assertEquals(File_Handler::get_filename_from_path_without_fileextension($path2), "filename.a.b");
  }

}

?>