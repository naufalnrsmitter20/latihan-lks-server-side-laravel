<?php 
$fruits = array("Apple", "Banana", "Cherry");
array_push($fruits, "Orange", "Kiwi", "Lemon");
foreach ($fruits as $key => $value) {
    echo ($key + 1)." => ".$value." , ";
};
?>