<?php
function db_connect() {
    // ข้อมูลการเชื่อมต่อฐานข้อมูล
    $servername = "127.0.0.1"; // ชื่อเซิร์ฟเวอร์ฐานข้อมูล
    $username = "root";        // ชื่อผู้ใช้ฐานข้อมูล
    $password = "";            // รหัสผ่านฐานข้อมูล
    $dbname = "database";      // ชื่อฐานข้อมูลที่คุณต้องการเชื่อมต่อ

    // สร้างการเชื่อมต่อ
    $conn = new mysqli($servername, $username, $password, $dbname);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
    }

    return $conn;
}
?>
