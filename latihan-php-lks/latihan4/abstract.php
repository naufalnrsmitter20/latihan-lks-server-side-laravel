<?php 

abstract class Product
{
    protected $product_name;
    protected $price;
    protected $stock;
    public function __construct($product_name, $price, $stock) {
        $this->product_name = $product_name;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function reduce_stock($qty){
        if($qty > $this->stock){
            echo "not enough stock of {$this->product_name} \n";
        } else{
            $this->stock -= $qty;
            echo "success to pay, stock remaining {$this->stock} \n";
        }
    }
    abstract public function views();

    public function set_price($price){
        $this->price = $price;
    }

    public function delete_product(){
        echo "Product {$this->product_name} has been deleted! \n";
    }

 
} 

class ElectronicsProduct extends Product {
    private $warranty;

    public function __construct($product_name, $price, $stock, $warranty){
        parent::__construct($product_name, $price, $stock);
        $this->warranty = $warranty;
    }
    public function views()  {
        echo "Electronics Product \n product name: {$this->product_name} \n product price: {$this->price} \n product stock: {$this->stock} \n warranty: {$this->warranty}\n";
    }
}

class FoodAndBeveragesProduct extends Product {
    private $discount;
    private $pay;
    private $return;
    public function __construct($product_name, $price, $stock, $discount, $pay, $return){
        parent::__construct($product_name, $price, $stock);
        $this->discount = $discount;
        $this->pay = $pay;
        $this->return = $return;
    }
    public function user_pay($pay, $price){
        $this->pay = $pay;
        if($pay != 0){
            echo "money not enough \n";
        } else {
            if($pay < $price){
                echo "you not yet pay! \n";
            } else {
                echo "success to pay! \n";
            }
        }
    }
    public function set_discount($discount, $price){
        $this->discount = $discount;
        $total_discount =  $price * ($discount/100);
        $total_amount = floor($price -= $total_discount);
        echo "This product is getting {$discount}% and you pay {$total_amount} \n";
    }

    public function views(){
        echo "Food and Beverages Product \n product name: {$this->product_name} \n product price: {$this->price} \n product stock: {$this->stock} \n discount: {$this->discount} \n pay: {$this->pay}\n return: {$this->return} \n \n";
    }
}

class ClothesProduct extends Product {
    private $size;
    public function __construct($product_name, $price, $stock, $size){
        parent::__construct($product_name, $price, $stock);
        $this->size = $size;
    }
    public function views(){
        echo "Clothes Product \n product name: {$this->product_name} \n product price: {$this->price} \n product stock: {$this->stock} \n size: {$this->size}\n";
    }
}

function Electronics(){
    $smartphone = new ElectronicsProduct("Asus", 0, 10, 2);
    echo $smartphone->views() . "\n";
    $smartphone->set_price(8000000);
    $smartphone->reduce_stock(6);
    echo $smartphone->views() . "\n";
    $smartphone->delete_product();
    echo $smartphone->views() . "\n";
}

function FoodAndBeverages(){
    $steak = new FoodAndBeveragesProduct("steak", 0, 20, 0, 0, 0);
    $steak->set_price(35000);
    $steak->set_discount(30, 35000);
    $steak->user_pay(34000);
    echo $steak->views();
}

FoodAndBeverages()
?>