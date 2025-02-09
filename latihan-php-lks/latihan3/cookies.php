<?php 
$cookie_name = "Name";
$cookie_value = "Naufal Nabil Ramadhan";
$cookie_expiresIn = 60 * 60 * 24;
setcookie($cookie_name, $cookie_value, $cookie_expiresIn, "/", "localhost", false, false);
?>

<html>

<body>
    <?php 
        if(isset($_COOKIE[$cookie_name])){
            echo "Cookie ".$cookie_name." is not set!";
        } else{
            echo "Cookie ".$cookie_name." now is set!";
            echo "Value ".$_COOKIE[$cookie_name];
            echo "\n Expires in ".$cookie_expiresIn;
        }
        ?>
</body>

</html>