<?php
require_once(__DIR__ . '/../../lib/php-cli-tools/vendor/autoload.php');


$exps = [
  "intval(%s)",
  //"(int)%s",
  //"floatval(%s)",
  //"(float)%s",
  "is_numeric(%s)",
  //"is_float(%s)",
  "is_int(%s)",
  //"is_integer(%s)",
  "is_string(%s)",
  "is_bool(%s)",
  //"is_object(%s)",
  //"is_array(%s)",
];
/*$exps = [
  "ceil(%s)",
  "floor(%s)",
  "round(%s)",
  "round(%s, -3)",
  "round(%s, -2)",
  "round(%s, -1)",
  "round(%s, 0)",
  "round(%s, 1)",
  "round(%s, 2)",
  "round(%s, 3)",
  "round(%s, 4)",
  "round(%s, 5)",
];*/

$exps_name = array_map(function($s){return str_replace("%s", "", $s);}, $exps);// %s 会引起的 php-cli-tools 画表格时的Bug。
$cases = [
  '1',
  '0',
  '-1',
  '"1"',
  '"0"',
  '"-1"',
  '""',
  '12,300.2', // 异常 注释：PHP 默认不能正确处理类似 "12,300.2" 的字符串。
  '"12,300.2"',
  '32.4',  // 四舍五入
  '"32.4"',
  '32.5',  // 多种浮点型
  '"32.5"',
  '3.1415926',
  '"3.1415926"',
  '-062.5926',
  '"-062.5926"',
  '20.0',
  '"20.0"',
  '40.00',
  '"40.00"',
  '076', // 前导0（其实是8进制，0开头的都是8进制，0x开头的则是16进制）
  '"076"', // 前导0
  '"0076"',
  '"00076"',
  '"0-0076"',
  '"-0076"',
  '7.70',
  '"7.70"',
  '"aaa187"', // 带字符的异常情况
  '"45bc89"',
  '"e-70.5"',
  '"60.a1"',
  '"3.40x"',
  '0xAF', // 16进制
  '0X100',
  '0x0abc', // 前导0
  '0x000abc', // 前导0
  '0x0ax',
  'af',
  '"af"',
  '"0xabc"',
  '"0X12A"',
  '"0x0ax"', // 后置异常
  '"0x0.a"',
  '"10x0a"', // 前置异常
  '"a0x0a"',
  '00000101', // 8进制
  '"00000101"',
  '0101',
  '00101',
  '000101',
  '000108',
  '000109',
  '',
  'NULL', // 其他常见情况测试
  '"NULL"',
  'True',
  '"True"',
  'False',
  'array()',
  '[]',
];

$rows = [];
$i = 0;
foreach($cases as $case){
  $rows[$i] = [$case];
  foreach($exps as $exp){
    $cmd =  "return var_export( " . sprintf($exp, $case) . ", True );";
    $val = eval($cmd);
    print $cmd . " : " . $val . "\n";

    $rows[$i][] = $val;
  }
  $i++;
}

// 期望的输出：
// 顶部Header是测试的表达式
// 第一列是测试用例的值
// 中间部分则是boolean(true)和boolean(false)
$headers = $exps_name;
array_unshift($headers, "Cases");

$t = new \cli\Table();
$t->setHeaders($headers);
$t->setRows($rows);
$t->display();
?>
