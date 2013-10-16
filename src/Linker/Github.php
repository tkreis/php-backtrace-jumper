<?php 

namespace Linker;

class Github {
  private $repoUrl;
  private $branch;
  private $workingDirectoryLength;

  public function __construct($options){
    $this->repoUrl = $options['repoUrl'];
    $this->branch = $options['branch'];
    $this->workingDirectoryLength = strlen($options['workingDirectory']);
    $this->repositoryIdentifier = isset($options['identifier']) ? $options['identifier']: '';
  }

  public function generateLink($fileLocation){
    return  $this->repoUrl . '/tree/'.$this->branch .'/'. substr($fileLocation, $this->workingDirectoryLength);
  }

  public function belongsToRepository($fileLocation){
    return !(strpos($fileLocation, $this->repositoryIdentifier ) === false );
  }
}

