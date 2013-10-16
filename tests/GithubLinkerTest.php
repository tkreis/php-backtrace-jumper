<?php

require_once('src/Linker/Github.php');

use \Linker\Github;

class GithubTest extends PHPUnit_Framework_TestCase{
  private $analyzer;

  protected function setUp(){
    $this->gh =  new Github(array( 'repoUrl' => 'QueryAnalyzer', 'branch' => 'master', 'workingDirectory' => '/local', 'identifier' => 'zend/vendor' ));
  }

  public function testCanCreateInstance(){
    $this->assertInstanceOf('\Linker\Github', $this->gh);
  }

  public function testStripsOutLocalDirectoryFromGenerateLink(){
    $this->assertEquals('QueryAnalyzer/tree/master/', $this->gh->generateLink('/local') );
  }

  public function testIncludesBranchInGenerateLink(){
    $this->assertEquals('QueryAnalyzer/tree/master/', $this->gh->generateLink('/') );
  }

  public function testIncludesRepoInGenerateLink(){
    $this->assertEquals('QueryAnalyzer/tree/master/', $this->gh->generateLink('/') );
  }

  public function testReturnsTrueIfFileBelongsToRepository(){
    $this->assertTrue($this->gh->belongsToRepository('/zend/vendor/auto.php'));
  }

  public function testReturnsFalseIfFileDoesNotBelongToRepository(){
    $this->assertFalse($this->gh->belongsToRepository('/other/vendor/auto.php'));
  }
}
