<?php
// 测一点，写一点！
// Test A Little, Write A Little.
require_once(__DIR__ . "/IpCheckerTest.class.php");
require_once(__DIR__ . "/SplitIpChecker.class.php");


class SplitIpCheckTest extends IpCheckTest{
  protected $_test_object;

  public function setUp(){
    $this->_test_object = new SplitIpChecker();
  }
}
?>
