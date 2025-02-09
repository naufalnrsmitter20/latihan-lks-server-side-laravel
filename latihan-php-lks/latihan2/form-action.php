<?php 
if($_POST){
    $name = $_POST["name"];
    $email = $_POST["email"];
    
    if(empty($name) && empty($email)){
        echo "<script>alert('Nama dan Email tidak boleh kosong');location.href='form-views.php';</script>";
    } else {
        echo "'Nama : ".$name.", Email : ".$email."'";
    }
}

?>