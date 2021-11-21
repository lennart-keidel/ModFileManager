<?php

use Tmd\AutoGitPull\Deployer;

class Git_Auto_Pull {

  private $deployer;

  function __construct(){
    $path_project_root_dir = dirname(__FILE__).'\..';
    $path_auto_git_pull_script = $path_project_root_dir.'\vendor\tmd\auto-git-pull\scripts\git-pull.sh';
    $path_auto_git_pull_script = str_replace('\\', '/', $path_auto_git_pull_script);
    $path_auto_git_pull_script = str_replace('C:', '/c', $path_auto_git_pull_script);

    $this->deployer = new Deployer([
      // IP addresses that are allowed to trigger the pull
      // (CLI is always allowed)
      'allowedIpRanges' => [
          '131.103.20.160/27', // Bitbucket
          '165.254.145.0/26', // Bitbucket
          '104.192.143.0/24', // Bitbucket
          '104.192.143.192/28', // Bitbucket (Dec 2015)
          '104.192.143.208/28', // Bitbucket (Dec 2015)
          '192.30.252.0/22', // GitHub
      ],

      // These are added to the allowedIpRanges array
      // to avoid having to define the Bitbucket/GitHub IPs in your own code
      'additionalAllowedIpRanges' => [
          '192.168.0.2/24'
      ],

      // Git branch to reset to
      'branch' => 'master',

      // User to run the script as
      'deployUser' => 'lennart-keidel',

      // Directory of the repository
      'directory' => $path_project_root_dir,

      // Path to the pull script
      // (You can provide your own script instead)
      'pullScriptPath' => __DIR__ . '/scripts/git-pull.sh',

      // Git remote to fetch from
      'remote' => 'origin'
  ]);

  }

  public function deploy(){
    $this->deployer->deploy();
  }

}

?>