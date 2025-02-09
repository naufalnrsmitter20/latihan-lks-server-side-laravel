<?php 

class staticExample {
    public static array $namespace = ["ClassName", "index", "values"];
    public static $name = "Naufal";
}

foreach (staticExample::$namespace as $item) {
    echo $item . " - ";
}

// echo staticExample::$name;




?>