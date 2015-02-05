<?php
class SplitIpChecker{
  public function check($s){
    $sectors = explode('.', $s);
    if(4 != count($sectors))
      return False;
    foreach($sectors as $sector){
      if(!is_numeric($sector))
        return False;
      // 前导0排除
      if("0" !== $sector && $sector !== ltrim($sector, '0'))  // 注意！：这里一定要用 !==
        return False;
      if(intval($sector) < 0 || intval($sector) > 255)
        return False;
    }
    return True;
  }
}

/*$r = new SplitIpChecker();
var_dump( $r->check("0.0.0.0") );
var_dump( $r->check("0.0.00.0") );
var_dump( $r->check("0.0.077.0") );
var_dump( $r->check("0.0.0.000") );
var_dump( $r->check("255.0.0.0") );
var_dump( $r->check("0.256.0.0") );
var_dump( $r->check("0.0.0.0.0") );*/
?>
