<?php 

class Constructor {
    protected $name;
    protected $place;
    protected $ticket;
    
    public function __construct($name, $place, $ticket)
    {
        $this->name = $name;
        $this->place = $place;
        $this->ticket = $ticket;
    }

    function get_name(){
        return $this->name;
    }
    function get_place(){
        return $this->place;
    }
    function get_ticket(){
        return $this->ticket;
    }
}

try {
    $data_user = [
        "name" => "Naufal Nabil Ramadhan",
        "Place" => "Abdurrahman Saleh",
        "Ticket" => "Airplane"
    ];
    $data1 = new Constructor($data_user["name"], $data_user["Place"], $data_user["Ticket"]);
    if(!$data1){
        throw new Exception("Error to load data!");
    }
    echo "User 1 \n" . "Name: " . $data1->get_name() . "\nPlace: " . $data1->get_place() . "\nTicket: " . $data1->get_ticket();

} catch (\Throwable $e) {
   throw new Exception($e);
}

?>