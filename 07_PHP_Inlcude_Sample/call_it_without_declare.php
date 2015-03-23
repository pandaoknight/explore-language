<?php
print "When I am included, I will the function g() directly.\n";
g();

function f(){
    print "I will call a function named: g(). Which never declare in this file[".__FILE__."]\n";
    g();
}

?>
