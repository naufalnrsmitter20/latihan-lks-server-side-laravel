<?php 

interface PaymentProcessing{
    public function processPayment($amount);
    public function validateTransaction($payment_id);
}



class TransferBank implements PaymentProcessing  {
    public function processPayment($amount){
        echo "Memproses pembayaran senilai {$amount}... \n";
        return true;
    }
    public function validateTransaction($payment_id){
        echo "Memproses validasi pembayaran dengan id {$payment_id}... \n";
        return true;
    }
}

function processOnlinePayment(PaymentProcessing $paymentProcessing, float $amount, string $transaction_id){
if($paymentProcessing->processPayment($amount)){
    echo "Proses Pembayaran dengan nilai {$amount} telah berhasil! \n";
    if($paymentProcessing->validateTransaction($transaction_id)){
        echo "Validasi Pembayaran dengan id {$transaction_id} telah berhasil! \n";
        return true;
    }else{
        echo "Validasi Pembayaran Gagal! \n";
        
    }
} else{
    echo "Proses Pembayaran Gagal! \n";

}
}


$transfer = new TransferBank();
processOnlinePayment($transfer, 100000, "IDK112")

?>