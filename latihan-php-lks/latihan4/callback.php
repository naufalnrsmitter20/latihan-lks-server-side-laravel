<?php 

function mycall ($items){
    return  "length: ". strlen($items);
}

$str = ["apple", "banana"];
$length = array_map("mycall", $str);
print_r($length);

// count total items of array
print_r(count($str));

$arr_vechile = ["lamborghini", "ferrari", "avanza"];
$length_test = array_map(function($value){return strlen($value);}, $arr_vechile);
print_r($length_test)

?>