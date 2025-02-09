<?php 

$countries = array("NAUFAL" => "INDONESIA", "HAZA" => "SINGAPORE", "RYO" => "MALAYSIA");
print_r(array_change_key_case($countries, CASE_LOWER));
?>