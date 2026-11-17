<?php 
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "school_db_basic";
try{
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4",$user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "اتصال موفق";
} catch (PDOException $e) {
    die("اتصال ناموفق : " . $e->getMessage());
}
?>