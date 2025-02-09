<?php 

$text = "<Allahuakbar123>";

$filtered = filter_var($text, FILTER_SANITIZE_SPECIAL_CHARS);
echo "Filter <> : " . $filtered . "\n";

$num = 1000;

if(filter_var($num, FILTER_VALIDATE_INT) === false){
    echo $num . " is Not Number";
} else {
    echo $num . " is a Number";
}

echo "\n \n";

echo "Email Validation \n";

$email = array("email 1" => "x3mnaufalnabilramadhan@gmail.com", "email 2" => "ryohariyono@gmail.com", "email 3" => "errrrr", "email 4" => "aaaaa");
foreach ($email as $key => $value) {
    echo $key . "\n";
    echo $value;
    if (filter_var($value, FILTER_VALIDATE_EMAIL)){
        echo " is Valid Email! \n";
    } else {
        echo " is not Valid Email! \n";
    }
    echo "\n";
}
echo "\n \n";

$domain1 = "https://www.youtube.com";
$domain2 = "dcwvew";

if(filter_var($domain1, FILTER_VALIDATE_URL)){
    echo $domain1 ." is valid url!";
} else {
    echo $domain1 ." is not valid url!";
}
echo "\n \n";

$int = 122;
$min = 1;
$max = 200;

if (filter_var($int, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max))) === false) {
  echo("Variable value is not within the legal range");
} else {
  echo("Variable value is within the legal range");
}

?>