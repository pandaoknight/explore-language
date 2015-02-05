<?php
// 测一点，写一点！
// Test A Little, Write A Little.
require_once(__DIR__ . "/RegexIpChecker.class.php");
require_once(__DIR__ . "/SplitIpChecker.class.php");


class IpCheckTest extends PHPUnit_Framework_TestCase{
  protected $_test_object;

  public function setUp(){
    $this->_test_object = new RegexIpChecker();
    //$this->_test_object = new SplitIpChecker();
  }

  public function testCheck(){
    $this->assertTrue($this->_test_object->check("0.0.0.0"));
    $this->assertTrue($this->_test_object->check("10.77.5.220"));
    $this->assertTrue($this->_test_object->check("255.255.255.255"));
  }

  /**
   * 异常流测试
   */
  public function testCheck_exceptional(){
    $this->assertFalse($this->_test_object->check("0.0.0.0.0"));
    $this->assertFalse($this->_test_object->check("0.0.0.0."));
    $this->assertFalse($this->_test_object->check("0.0.0."));
    $this->assertFalse($this->_test_object->check("0.0.0"));
    $this->assertFalse($this->_test_object->check("0.0."));
    $this->assertFalse($this->_test_object->check(".0.0.0.0"));
    $this->assertFalse($this->_test_object->check("0.0..0"));
    $this->assertFalse($this->_test_object->check("0...0"));
    $this->assertFalse($this->_test_object->check("..."));

    $this->assertFalse($this->_test_object->check("0.0.0.256"));
    $this->assertFalse($this->_test_object->check("0.0.256.0"));
    $this->assertFalse($this->_test_object->check("0.256.0.0"));
    $this->assertFalse($this->_test_object->check("256.0.0.0"));

    $this->assertFalse($this->_test_object->check("108.2.3.-1"));
    $this->assertFalse($this->_test_object->check("108.-1.3.0"));
    $this->assertFalse($this->_test_object->check("-1.2.3.0"));

    $this->assertFalse($this->_test_object->check("abc.2.3.0"));
    $this->assertFalse($this->_test_object->check("0xa.2.3.0"));
    $this->assertFalse($this->_test_object->check("108.0xf.3.0"));
    $this->assertFalse($this->_test_object->check("108.2.3.0xa"));
  }

  public function testCheck_leading_zero(){
    $this->assertTrue($this->_test_object->check("108.2.37.0"));
    // 我们认为前导0是不合法的，因为在Ubuntu下，IP中前导0的数字会被当做8进制来解释。例如：
    // ping xxx.xxx.xxx.077 => PING xxx.xxx.xxx.077 (xxx.xxx.xxx.63)
    $this->assertFalse($this->_test_object->check("0108.2.37.0"));
    $this->assertFalse($this->_test_object->check("108.02.37.0"));
    $this->assertFalse($this->_test_object->check("108.2.037.0"));
    $this->assertFalse($this->_test_object->check("108.2.37.00"));

    $this->assertFalse($this->_test_object->check("108.2.37.000"));
    $this->assertFalse($this->_test_object->check("108.2.37.0000"));
    $this->assertFalse($this->_test_object->check("108.2.0037.0"));
    $this->assertFalse($this->_test_object->check("108.2.00037.0"));
    $this->assertFalse($this->_test_object->check("108.002.37.0"));
    $this->assertFalse($this->_test_object->check("108.0002.37.0"));

    $this->assertTrue($this->_test_object->check("0.0.0.0"));
    $this->assertFalse($this->_test_object->check("00.0.0.0"));
    $this->assertFalse($this->_test_object->check("0.000.0.0"));
    $this->assertFalse($this->_test_object->check("0.0.0.00"));
    $this->assertFalse($this->_test_object->check("0.0.0.0000"));
  }
}
?>
