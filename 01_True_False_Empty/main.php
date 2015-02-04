<?php
require_once(__DIR__ . '/../lib/php-cli-tools/vendor/autoload.php');

$exps = ["True == %s", "False == %s", "empty(%s)", "NULL == %s"];
$exps_name = ["True == ", "False == ", "empty()", "NULL == "];  // %s 会引起的 php-cli-tools 画表格时的Bug。
$cases = [
  '1',
  '0',
  '-1',
  '"1"',
  '"0"',
  '"-1"',
  '""',
  'array()',
  '[]',
  '',
  'NULL',
  '"NULL"',
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
