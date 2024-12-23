<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


$servername = "localhost";
$username = "root";  
$password = "";  
$dbname = "iletisim_formu";  


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}


date_default_timezone_set('Europe/Istanbul');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    echo "<pre>";
    print_r($_POST); 
    echo "</pre>";


    if (!empty($_POST['ad']) && !empty($_POST['email']) && !empty($_POST['mesaj'])) {
        $ad = $_POST['ad'];
        $email = $_POST['email'];
        $mesaj = $_POST['mesaj'];
        $tarih = date('Y-m-d H:i:s');  

     
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Geçersiz e-posta adresi.";
        } else {
          
            $stmt = $conn->prepare("INSERT INTO form (ad, email, mesaj, tarih) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $ad, $email, $mesaj, $tarih);  // Parametreleri bağla

       
            if ($stmt->execute()) {
                echo "Mesajınız başarıyla gönderildi!";
            } else {
                echo "Hata: " . $stmt->error;
            }

            // Prepared statement'i kapat
            $stmt->close();
        }
    } else {
        echo "Lütfen tüm alanları doldurduğunuzdan emin olun.";
    }
}

// veritbn Baglantisi kapat
$conn->close();
?>