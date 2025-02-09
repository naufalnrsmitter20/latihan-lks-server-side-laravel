<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php 
$name = $email = $gender = $website = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $gender = test_input($_POST["gender"]);
    $website = test_input($_POST["website"]);
}

function test_input($data) {
    // $data = trim($data);
    // $data = stripslashes($data);
    // $data = htmlspecialchars($data);
    return $data;
}
?>
    <form style="margin-bottom: 40px;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
        <div>
            <label for="name">Nama</label>
            <input type="text" name="name" id="name">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="text" name="email" id="email">
        </div>
        <div>
            <label for="gender">Gender</label>
            <input type="text" name="gender" id="gender">
        </div>
        <div>
            <label for="website">Website</label>
            <input type="text" name="website" id="website">
        </div>
        <input type="submit" name="submit" value="submit" />
    </form>

    <?php 
    echo "<h1>Your Input </h1>";
    echo "Nama : ".$name;
    echo "<br/>";
    echo "Email : ".$email;
    echo "<br/>";
    echo "Gender : ".$gender;
    echo "<br/>";
    echo "Websites : ".$website;
    echo "<br/>";
    ?>
</body>

</html>