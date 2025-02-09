<?php 
$cars = array("Volvo", "BMW", "Toyota");
$card = array("asd", "fgh", "hjk");
foreach ($cars as &$x) {
  $x = $card[1];
}

$x = "ice cream";

var_dump($cars);

?>