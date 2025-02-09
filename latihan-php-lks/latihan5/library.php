<?php 

class Book{
    protected string $title;
    protected string $author;
    protected bool $isAvailable;

    public function __construct($title, $author){
        $this->title = $title;
        $this->author = $author;
        $this->isAvailable = true;
    }

    public function get_title(){
        return $this->title;
    }

    public function get_author(){
        return $this->author;
    }

    public function getAvailable(){
        return $this->isAvailable;
    }

    public function borrow(){
        if($this->isAvailable == true){
            $this->isAvailable = false;
            return true;
        }
        return false;
    }

    public function returns(){
         if($this->isAvailable == false){
            $this->isAvailable = true;
            return true;
         }
         return false;
    }

}

class Library{
    private array $books = [];

    public function addBook(Book $books){
        $this->books[] = $books;
    }
    public function ListAllBooks(){
        echo "List buku di perpustakaan" . PHP_EOL;
        foreach ($this->books as $index => $book) {
            $status = $book->getAvailable() ? "Tersedia" : "Tidak Tersedia";
            echo ($index + 1) . ". {$book->get_title()}, dibuat oleh {$book->get_author()}, status: {$status}" . PHP_EOL;
        }
    }

    public function borrowBook(string $title){
        foreach ($this->books as $book) {
            if($book->get_title() === $title){
                if($book->borrow()){
                    echo "Buku {$title} berhasil dipinjam!" . PHP_EOL;
                } else {
                    echo "Buku {$title} sedang dipinjam, tunggu seseorang mengembalikan!" . PHP_EOL;
                }
                return;
            } 
        }
        echo "Buku " . $title . " tidak ditemukan" . PHP_EOL;
    }
    
    
    public function returnBook(string $title){
        foreach ($this->books as $book) {
            if($book->get_title() === $title){
                $returned = $book->returns();
                if($returned){
                    echo "Buku {$title} berhasil dikembalikan!" . PHP_EOL;
                } else{
                    echo "Buku {$title} sudah dikembalikan!" . PHP_EOL;
                }
                return;
            } 
        }
        echo "Buku " . $title . " tidak ditemukan" . PHP_EOL;            

    }
    // public function collectBook(){
    //     "Koleksi Buku" . PHP_EOL;
    //     $this->collection[] =  
    //     foreach ($this->collection as $index => $item) {
    //         echo ($index + 1) . "{$item}";
    //     }
    // }
}

$library = new Library();

$library->addBook(new Book("Pemrograman Dasar", "Joe Biden"));
$library->addBook(new Book("Javascript Pemula", "Samir Expander"));
$library->addBook(new Book("OOP Pekan 1", "NH. Idul"));
$library->ListAllBooks();
echo PHP_EOL;

$library->borrowBook("Pemrograman Dasar");
$library->ListAllBooks();
echo PHP_EOL;

$library->borrowBook("Javascript Pemula");
$library->ListAllBooks();
echo PHP_EOL;

$library->returnBook("Javascript Pemula");
$library->returnBook("Javascript Pemula");
$library->ListAllBooks();
echo PHP_EOL;
?>