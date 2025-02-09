<?php 

$testing = array("name" => "Naufal", "age" => 20, "address" => "Jl. Kebon Jeruk 1 No. 1");


$cars = [
    0 => "Volvo",
    1 => "BMW",
    2 =>"Toyota"
  ];

foreach ($cars as $key => $value) {
    echo ($key + 1)." => ".$value." , ";
};
?>