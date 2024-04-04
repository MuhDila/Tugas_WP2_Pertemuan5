<?php

// Kelas yang merepresentasikan sebuah Buku
class Book {
    protected $title; // Enkapsulasi: Judul buku
    protected $author; // Enkapsulasi: Penulis buku
    protected $year; // Enkapsulasi: Tahun terbit buku
    protected $status; // Enkapsulasi: Status buku (tersedia atau dipinjam)

    // Konstruktor untuk menginisialisasi objek buku
    public function __construct($title, $author, $year) {
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
        $this->status = 'tersedia';
    }

    // Metode getter
    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getYear() {
        return $this->year;
    }

    public function getStatus() {
        return $this->status;
    }

    // Metode setter untuk status
    public function setStatus($status) {
        $this->status = $status;
    }
}

// Kelas yang merepresentasikan sebuah Perpustakaan
class Library {
    protected $books; // Enkapsulasi: Koleksi buku

    // Konstruktor untuk menginisialisasi objek perpustakaan
    public function __construct() {
        $this->books = [];
    }

    // Metode untuk menambahkan buku ke perpustakaan
    public function addBook(Book $book) {
        $this->books[] = $book;
    }

    // Metode untuk meminjam buku dari perpustakaan
    public function borrowBook($title) {
        foreach ($this->books as $book) {
            if ($book->getTitle() == $title && $book->getStatus() == 'tersedia') {
                $book->setStatus('dipinjam');
                return "Buku \"$title\" telah dipinjam.";
            }
        }
        return "Buku \"$title\" tidak tersedia untuk dipinjam.";
    }

    // Metode untuk mengembalikan buku yang dipinjam ke perpustakaan
    public function returnBook($title) {
        foreach ($this->books as $book) {
            if ($book->getTitle() == $title && $book->getStatus() == 'dipinjam') {
                $book->setStatus('tersedia');
                return "Buku \"$title\" telah dikembalikan.";
            }
        }
        return "Buku \"$title\" tidak dipinjam atau tidak ditemukan.";
    }

    // Metode untuk mencetak daftar buku yang tersedia di perpustakaan
    public function printAvailableBooks() {
        echo "Buku yang Tersedia:\n";
        foreach ($this->books as $book) {
            if ($book->getStatus() == 'tersedia') {
                echo "- {$book->getTitle()} oleh {$book->getAuthor()} ({$book->getYear()})\n";
            }
        }
    }
}

// Fungsi CLI untuk berinteraksi dengan sistem perpustakaan
function libraryCLI(Library $library) {
    while (true) {
        echo "\nSistem Perpustakaan\n";
        echo "1. Tampilkan buku yang tersedia\n";
        echo "2. Tambahkan buku\n";
        echo "3. Pinjam buku\n";
        echo "4. Kembalikan buku\n";
        echo "5. Keluar\n";

        $choice = readline("Masukkan pilihan Anda: ");

        switch ($choice) {
            case '1':
                $library->printAvailableBooks();
                break;
            case '2':
                $title = readline("Masukkan judul: ");
                $author = readline("Masukkan penulis: ");
                $year = readline("Masukkan tahun: ");
                $book = new Book($title, $author, $year);
                $library->addBook($book);
                echo "Buku \"$title\" telah ditambahkan.\n";
                break;
            case '3':
                $title = readline("Masukkan judul buku yang ingin dipinjam: ");
                echo $library->borrowBook($title) . "\n";
                break;
            case '4':
                $title = readline("Masukkan judul buku yang ingin dikembalikan: ");
                echo $library->returnBook($title) . "\n";
                break;
            case '5':
                echo "Keluar...\n";
                exit();
            default:
                echo "Pilihan tidak valid. Silakan coba lagi.\n";
        }
    }
}

// Penggunaan
$library = new Library();

// Tambahkan satu buku secara otomatis ke perpustakaan
$defaultBook = new Book("Harry Potter", "J.K. Rowling", 1997);
$library->addBook($defaultBook);

libraryCLI($library);

?>