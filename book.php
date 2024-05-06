<?php
class Book {
    private $code_book;
    private $name;
    private $qty;

    // Constructor dijadikan private agar tidak dapat dipanggil dari luar kelas
    private function __construct($code_book, $qty) {
        $this->setCodeBook($code_book);
        $this->setQty($qty);
    }

    // Setter untuk $code_book
    private function setCodeBook($code_book) {
        // Memeriksa format $code_book
        if (preg_match('/^[A-Z]{2}\d{2}$/', $code_book)) {
            $this->code_book = $code_book;
        } else {
            throw new Exception("Format kode buku tidak valid. Gunakan format 'BB00'.");
        }
    }

    // Setter untuk $qty
    private function setQty($qty) {
        // Mengonversi nilai qty menjadi integer
        $qty = (int) $qty;
        // Memeriksa apakah $qty merupakan integer positif
        if ($qty > 0) {
            $this->qty = $qty;
        } else {
            throw new Exception("Jumlah buku harus berupa angka positif.");
        }
    }

    // Getter untuk $code_book
    public function getCodeBook() {
        return $this->code_book;
    }

    // Getter untuk $qty
    public function getQty() {
        return $this->qty;
    }

    // Metode statis untuk membuat objek Book
    public static function createBook($code_book, $qty) {
        return new self($code_book, $qty);
    }
}

// Inisialisasi variabel untuk pesan error
$errors = [];

// Inisialisasi variabel untuk menampilkan hasil input
$result = '';

// Variable untuk menandai apakah form telah disubmit
$form_submitted = false;

// Form untuk memeriksa dan menginput data buku
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_submitted = true; // Set variable form_submitted menjadi true saat form disubmit
    try {
        // Menerima input dari form
        $code_book = $_POST["code_book"];
        $name = $_POST["name"];
        $qty = $_POST["qty"];

        // Membuat objek Book dengan metode statis createBook
        $book = Book::createBook($code_book, $qty);

        // Menampilkan hasil input
        $result .= '<div style="text-align: center; 
        background-color: #ffc0cb; 
        padding: 20px; 
        border-radius: 10px; 
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1); 
        width: 400px;
        margin: 0 auto;">
            <h2>Detail Buku</h2>
            <p><strong>Kode Buku:</strong> ' . $book->getCodeBook() . '</p>
            <p><strong>Nama Buku:</strong> ' . $name . '</p>
            <p><strong>Jumlah Buku:</strong> ' . $book->getQty() . '</p>
            <p><a href="' . $_SERVER["PHP_SELF"] . '" style="background-color: #4CAF50; color: white; 
            padding: 10px 20px; text-decoration: none; border-radius: 5px;">Cek Buku Lainnya</a> 
            <a href="#" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Selesai</a></p>
    </div>';
    } catch (Exception $e) {
        // Menangkap pesan error dan menyimpannya dalam variabel $errors
        $errors[] = $e->getMessage();
    }
}

// Menampilkan form untuk memeriksa dan menginput data buku hanya jika form belum disubmit atau jika terdapat error
if (!$form_submitted || !empty($errors)) {
    echo '<style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            form {
                background: #ffc0cb;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
                width: 400px;
            }
            input[type="text"],
            input[type="number"],
            input[type="submit"] {
                width: 100%;
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-sizing: border-box;
            }
            input[type="submit"] {
                background-color: #4CAF50;
                color: white;
                cursor: pointer;
            }
            input[type="submit"]:hover {
                background-color: #45a049;
            }
            span.error {
                color: red;
            }
          </style>';

    echo '<form method="post" action="' . $_SERVER["PHP_SELF"] . '">
              <label for="code_book">Kode Buku:</label><br>
              <input type="text" id="code_book" name="code_book"><br>
              <label for="name">Nama Buku:</label><br>
              <input type="text" id="name" name="name"><br>
              <label for="qty">Jumlah Buku:</label><br>
              <input type="number" id="qty" name="qty"><br>';

    // Menampilkan pesan error di bawah input field yang bermasalah
    foreach ($errors as $error) {
        echo '<span class="error">' . $error . '</span><br>';
    }

    echo '<input type="submit" value="Submit">
          </form>';
}

// Menampilkan hasil input jika form telah disubmit
echo $result;
?>

