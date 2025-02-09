<?php 


abstract class Products{
    protected $product_name;
    protected $price;
    protected $stock;
    protected $pay;
    protected $discount;

    public function __construct($product_name, $price, $stock, $pay, $discount){
        $this->product_name = $product_name;
        $this->stock = $stock;
        $this->price = $price;
        $this->pay = $pay;
        $this->discount = $discount;
    }
    abstract public function Display();
    protected function add_stock($qty){
       $qty += $this->stock;
    }

    public function add_discount($price ,$discount, $pay){
        $this->price = $price;
        $this->discount = $discount;
        $this->pay = $pay;

        function format_rupiah($item){
            $format= "Rp. " . number_format($item, 0, ",", ".");
            return $format;
        }

        $total_discount = $this->price * ($this->discount/100);
        $total_amount = floor($total_discount != 0 ? $price - $total_discount : $price);
        $return = floor($pay - $total_amount);

        if($pay < $total_amount){
            echo "not enough money \n";
        } else {
            echo "Transaction Success \n";
            echo "Product Name: {$this->product_name}, Price: ". format_rupiah($this->price) .", Stock: " . $this->stock . ", Discount: {$this->discount}%, Total Discount: ".format_rupiah($total_discount)." Pay: " . format_rupiah($this->pay) . ", Total Amount: " . format_rupiah($total_amount) . ", Return: " . format_rupiah($return) . "\n";
        }
    }
    
    public function reduce_stock($qty){
        if($qty > $this->stock){
            echo "not enough stock \n";
        } else {
            $this->stock -= $qty;
            echo "Transaction Success \n";
        }
    }
    
}

class Electronics extends Products {
    public function __construct($product_name, $price, $stock, $pay, $discount){
        parent::__construct($product_name, $price, $stock, $pay, $discount);
    }

    public function Display()
    {
        echo "Product Name: {$this->product_name}, Price: ". format_rupiah($this->price) .", Stock: " . $this->stock . ", Discount: {$this->discount}%"."  Pay: " . format_rupiah($this->pay) . "\n";
    }
}

$laptop = new Electronics("Lenovo A2234", 0, 10, 0, 0);
echo $laptop->add_discount(9000000, 20, 10000000);
echo $laptop->reduce_stock(10);
echo $laptop->Display()


?>