<?php

require_once('src/PrettyBacktrace.php');
require_once('src/Linker/Github.php');

use Linker\Github; 

class PrettyBacktraceTest extends PHPUnit_Framework_TestCase{

  public function testBacktaceItReturnsAnArray(){
    $this->assertInternalType('array', PrettyBacktrace::backtraceIt());
  }

  public function testBacktaceItReturnsPHPBacktrace(){
    $backtrace =  PrettyBacktrace::backtraceIt();
    $firstBacktrace = $backtrace[0];

    $this->assertArrayHasKey('function', $firstBacktrace);
    $this->assertArrayHasKey('line', $firstBacktrace);
    $this->assertArrayHasKey('file', $firstBacktrace);
    $this->assertArrayHasKey('class', $firstBacktrace);
    $this->assertArrayHasKey('type', $firstBacktrace);
    $this->assertArrayHasKey('args', $firstBacktrace);
  }

  public function testBacktaceItReturnsADecoratedBacktrace(){
    $backtrace =  PrettyBacktrace::backtraceIt();

    $this->assertArrayHasKey('linkageToRepo', $backtrace[0]);
  }

  public function testBacktaceItReturnsDirectionToFileOnSystem(){
    $backtrace =  PrettyBacktrace::backtraceIt();

    $this->assertContains('php-backtrace-jumper/tests/PrettyBacktraceTest.php', $backtrace[0]['file']);
  }

  public function testBacktaceItReturnsDirectionOnLinkedSource(){
    $gh = new Github(array( 'repoUrl' => 'https://github.com/tkreis/php-backtrace-jumper',
      'branch' => 'master',
      'workingDirectory' => getcwd().'/',
      'identifier' => 'php-backtrace-jumper'
    ));
    $backtrace =  PrettyBacktrace::backtraceIt(array($gh));

    $this->assertEquals('https://github.com/tkreis/php-backtrace-jumper/tree/master/tests/PrettyBacktraceTest.php', $backtrace[0]['linkageToRepo']);
  }

  public function testBacktaceItReturnsDirectionOnLinkedSourceEvenWithManyLinkers(){
    $gh = new Github(array( 'repoUrl' => 'https://github.com/tkreis/php-backtrace-jumper',
      'branch' => 'master',
      'workingDirectory' => getcwd().'/',
      'identifier' => 'php-backtrace-jumper'
    ));

    $failLinker = new Github(array( 'repoUrl' => 'https://github.com/tkreis/php-backtrace-jumper',
      'branch' => 'master',
      'workingDirectory' => getcwd().'/',
      'identifier' => 'fail'
    ));

    $backtrace =  PrettyBacktrace::backtraceIt(array($gh));

    $this->assertEquals('https://github.com/tkreis/php-backtrace-jumper/tree/master/tests/PrettyBacktraceTest.php', $backtrace[0]['linkageToRepo']);
  }
}
