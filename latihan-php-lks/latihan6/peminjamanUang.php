<?php 
class Loan{
    public string $name; // nama peminjam
    public float $amount; // total pinjaman
    public float $interestRate; //suku bunga tahunan (persen)
    public int $tenor; // lama pinjaman

    public function __construct(string $name, float $amount,float $interestRate, int $tenor){
        $this->name = $name;
        $this->amount = $amount;
        $this->interestRate = $interestRate;
        $this->tenor = $tenor;
    }

    public function calculateMonthlyInstallment(){
        $value = ($this->amount * ($this->interestRate/12)) / (1 - (1 + $this->interestRate / 12)**(-$this->tenor));
        return "   Cicilan Bulanan: " . numberToRupiah($value) . PHP_EOL;
    }

    public function getLoanDetails(){
        return "Nama: " . $this->name . PHP_EOL . "   Jumlah Pinjaman: " . numberToRupiah($this->amount) . PHP_EOL . "   Suku Bunga Tahunan: " . $this->interestRate . "%" . PHP_EOL . "   Tenor: " . $this->tenor . " bulan" . PHP_EOL;
    }
}
class LoanManager{
    public array $loans = [];
    public function addLoan(Loan $loan){
        $this->loans[] = $loan;
    }
    public function displayAllItems(){
        echo "Daftar Peminjam: \n";
        foreach($this->loans as $index => $loan){
            echo ($index + 1 ). ". " . $loan->getLoanDetails() . $loan->calculateMonthlyInstallment();
        }
    }
}   

function numberToRupiah($num){
    $format = "Rp. " . number_format($num, 0, ",", ".");
    return $format;
}


$loanManager = new LoanManager();
$loanManager->addLoan(new Loan("Alice", 10000000, 12, 12));
$loanManager->addLoan(new Loan("Bob", 5000000, 10, 6));
$loanManager->displayAllItems();

?>