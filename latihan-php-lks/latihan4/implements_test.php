<?php 

interface Delivery {
   public function CostEstimation(float $berat,string $destination): float;
   public function DeliveryEstimation($destination): string;
}   




class RegularShipping implements Delivery{
    public function CostEstimation(float $berat, string $destination): float {
        $destination;
        $ongkir = 8000;
        $admin = 2000;
        $total = $ongkir + $admin + $berat;
        echo "Estimasi Harga: {$total}\n Destinasi: {$destination}\n";
        return $total;
    }
    public function DeliveryEstimation($destination): string {
        echo "Destinasi Tujuan: {$destination}\n";
        return "Destinasi Tujuan: {$destination}\n";
    }
}
class ExpressShipping implements Delivery{
    public function CostEstimation(float $berat, string $destination): float {
        $destination;
        $ongkir = 5000;
        $admin = 2000;
        $total = $ongkir + $admin + $berat;
        echo "Estimasi Harga: {$total}\n Destinasi: {$destination}\n";
        return $total;
    }
    public function DeliveryEstimation($destination): string {
        echo "Destinasi Tujuan: {$destination}\n";
        return "Destinasi Tujuan: {$destination}\n";
    }
}
class InstantShipping implements Delivery{
    public function CostEstimation(float $berat, string $destination): float {
        $destination;
        $ongkir = 2500;
        $admin = 2000;
        $total = $ongkir + $admin + $berat;
        echo "Estimasi Harga: {$total}\n Destinasi: {$destination}\n";
        return $total;
    }
    public function DeliveryEstimation($destination): string {
        echo "Destinasi Tujuan: {$destination}\n";
        return "Destinasi Tujuan: {$destination}\n";
    }
}


function ShowData(){
    $weight = 2.5;
    $destination = "Malang";
    
    echo "=== Regular Shipping === \n";
    $regular = new RegularShipping();
    $regular->CostEstimation($weight, $destination);
    echo "\n";
    $regular->DeliveryEstimation($weight);
    echo "\n \n";
    echo "=== Express Shipping === \n";
    $regular = new ExpressShipping();
    $regular->CostEstimation($weight, $destination);
    echo "\n";
    $regular->DeliveryEstimation($weight);
    echo "\n \n";
    echo "=== Instant Shipping === \n";
    $regular = new InstantShipping();
    $regular->CostEstimation($weight, $destination);
    echo "\n";
    $regular->DeliveryEstimation($weight);
    echo "\n \n";
}

ShowData()

?>