<?php 

class Destructor
{
    public $name;
    public $age;
    public function __construct($name, $age){
        $this->name = $name;
        $this->age = $age;
    }
    public function __destruct(){
        echo "Hello, my name is {$this->name}, i'm {$this->age} years old";
    }
}

try {
   $data = new Destructor("Naufal Nabil Ramadhan", 17);
} catch (\Throwable $e) {
    throw new Exception($e);
}
?>