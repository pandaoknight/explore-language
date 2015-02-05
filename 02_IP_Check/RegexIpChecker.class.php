<?php
class RegexIpChecker{
  public function check($s){
    $z255 = "(25[0-5]|2[0-4]\d|1\d{2}|[1-9]?\d)";
    //$z255 = "(25[0-5]|2[0-4]\d|[0,1]?\d{1,2})";  // 前导0
    $pattern = "($z255\.){3}$z255";
    return True == preg_match("/^$pattern$/", $s, $match);
  }
}

//$r = new RegexIpChecker();
//var_dump( $r->check("0.0.0.0") );
//var_dump( $r->check("255.0.0.0") );
//var_dump( $r->check("0.256.0.0") );
//var_dump( $r->check("0.0.0.0.0") );
?>
