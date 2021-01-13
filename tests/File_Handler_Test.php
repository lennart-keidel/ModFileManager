<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertDirectoryExists;
use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFileDoesNotExist;
use function PHPUnit\Framework\assertFileExists;
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
  private $get_fileextension_from_path_input_and_expected_output = [
    "/a/b/filename.txt" => "txt",
    "filename.txt" => "txt",
    "a.txt" => "txt",
    ".hidden_filename.txt" => "txt",
    ".hidden_filename_wihout_filextension" => "",
    "no_filextension" => "",
    "b" => "",
    "" => "",
    "/" => "",
    "a.b.c" => "c",
    ".a.b.c" => "c"
  ];
  private $get_filename_from_path_without_fileextension_input_and_expected_output = [
    "/a/b/filename.txt" => "filename",
    "filename.txt" => "filename",
    "a.txt" => "a",
    ".hidden_filename.txt" => ".hidden_filename",
    ".hidden_filename_wihout_filextension" => ".hidden_filename_wihout_filextension",
    "no_filextension" => "no_filextension",
    "b" => "b",
    "" => "",
    "/" => "",
    "a.b.c" => "a.b",
    ".a.b.c" => ".a.b"
  ];
  private $remove_trailing_slash_from_path_input_and_expected_output = [
    "/path/to/dir/" => "/path/to/dir",
    "/path/to/dir" => "/path/to/dir",
    "\\path\\to\\dir\\" => "\\path\\to\\dir",
    "a/" => "a",
    "a" => "a",
    "./" => ".",
    "." => ".",
    "../" => "..",
    ".." => "..",
    "/" => "/",
    "" => "",
    "a//" => "a",
    "a//////" => "a",
  ];

  public function setUp() : void {





    ## ---------------- DISABLE TESTS IN THIS FILE -----------------------
    // $this->markTestSkipped("Dieser Test ist deaktiviert.");


  }

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
      assertDirectoryExists($path);
      assertIsArray($array_filenames);

      # test if only files with allowed fileextensions are contained
      # test if all files that should be contained are contained
      foreach (new DirectoryIterator($path) as $file) {
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
    foreach($this->get_fileextension_from_path_input_and_expected_output as $input => $expected_output){
      assertEquals($expected_output, File_Handler::get_fileextension_from_path($input));
    }
  }


  public function test_get_filename_from_path_without_fileextension() : void {
    foreach($this->get_filename_from_path_without_fileextension_input_and_expected_output as $input => $expected_output){
      assertEquals($expected_output, File_Handler::get_filename_from_path_without_fileextension($input));
    }
  }


  public function test_rename_file() : void {

    # get two files
    $path_original_filename = "";
    foreach (new DirectoryIterator(File_Handler_Test::path_temp_test_dir_root) as $file) {
      if($file->isFile() && !$file->isDot()){
        if($path_original_filename===""){
          $path_original_filename = $file->getPathname();
        }
        else {
          $path_second_original_filename = $file->getPathname();
          break;
        }
      }
    }

    # rename first file
    $path_new_filename = dirname($path_original_filename)."/new_filename.package";
    assertFileExists($path_original_filename);
    File_Handler::rename_file($path_original_filename, $path_new_filename);
    assertFileDoesNotExist($path_original_filename);
    assertFileExists($path_new_filename);

    # rename second file to same name as first file
    # assert Exception
    assertFileExists($path_second_original_filename);
    $this->expectException(File_Handler_Exception::class);
    File_Handler::rename_file($path_second_original_filename, $path_new_filename);
    assertFileExists($path_second_original_filename);
    assertFileExists($path_new_filename);
  }


  public function test_rename_file_with_wrong_data() : void {
    while(is_file($not_existing_path = md5(rand()."a")));
    $this->expectException(File_Handler_Exception::class);
    File_Handler::rename_file($not_existing_path.".txt","abc.txt");
  }


  public function test_rename_file_from_filename_list() : void {

    # create filename list
    # store new filename in filename list
    $filename_list = File_Handler::get_filename_list_from_path_recursive(File_Handler_Test::path_temp_test_dir_root);
    $new_filename_list = [];
    foreach($filename_list as $path => $array_filename){
      foreach($array_filename as $old_filename){
        $new_filename_list[$path][$old_filename] = $old_filename.".new";
      }
    }

    # test if old file not existing and new file existing
    File_Handler::rename_file_from_filename_list($new_filename_list);
    foreach($new_filename_list as $path => $array_filename){
      foreach($array_filename as $old_filename => $new_filename){
        assertFileDoesNotExist($path."/".$old_filename);
        assertFileExists($path."/".$new_filename);
      }
    }
  }


  public function test_remove_trailing_slash_from_path() : void {
    foreach($this->remove_trailing_slash_from_path_input_and_expected_output as $input => $expected_output){
      assertEquals($expected_output, File_Handler::remove_trailing_slash_from_path($input));
    }
  }

}

?>