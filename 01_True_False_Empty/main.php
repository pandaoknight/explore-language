<?php
require_once(__DIR__ . '/../lib/php-cli-tools/vendor/autoload.php');

$exps = ["True == %s", "False == %s", "empty(%s)", "isset(%s)", "NULL == %s"];
$exps_name = array_map(function($s){return str_replace("%s", "", $s);}, $exps);// %s 会引起的 php-cli-tools 画表格时的Bug。

#$var_exps = ['empty($var)', 'isset($var)'];
$var_exps = ['empty($var)', '!isset($var)'];
$var_exps_name = array_map(function($s){return str_replace("%s", "", $s);}, $var_exps);

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
  'null',
  'Null',
  'nUll',
];


$rows = [];
$i = 0;
foreach($cases as $case){
  $rows[$i] = [$case];

  # 我们发现empty()，isset()不能处理非变量的情况。会直接报语法错。
  foreach($exps as $exp){
    $cmd =  "return var_export( " . sprintf($exp, $case) . ", True );";
    $val = eval($cmd);
    print $cmd . " : " . $val . "\n";

    $rows[$i][] = $val;
  }

  #增加专门测试empty()，isset()行为的测试。
  foreach($var_exps as $exp){
    $cmd =  '$var=' . $case . ';' . "return var_export( " . $exp . ", True );";
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
$headers = array_merge($exps_name, $var_exps_name);
array_unshift($headers, "Cases");

$t = new \cli\Table();
$t->setHeaders($headers);
$t->setRows($rows);
$t->display();
?>
