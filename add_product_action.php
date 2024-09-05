<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // เชื่อมต่อฐานข้อมูล
    $conn = db_connect();

    // รับข้อมูลจากแบบฟอร์ม
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];

    // การอัปโหลดรูปภาพ
    $uploadDir = './uploads/';
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
    $maxFileSize = 5000000; // 5 MB
    $errorMessage = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // ตรวจสอบขนาดไฟล์
        if ($_FILES['image']['size'] > $maxFileSize) {
            $errorMessage = "ขนาดไฟล์ใหญ่เกินไป อนุญาตสูงสุด 5 MB";
        } else {
            $fileInfo = pathinfo($_FILES['image']['name']);
            $fileExtension = strtolower($fileInfo['extension']);

            // ตรวจสอบประเภทไฟล์
            if (!in_array($fileExtension, $allowedTypes)) {
                $errorMessage = "ไฟล์นี้ไม่ถูกต้อง ต้องเป็นไฟล์ประเภท JPG, JPEG, PNG หรือ GIF";
            } else {
                // สร้างชื่อไฟล์แบบสุ่มเพื่อป้องกันการทับซ้อน
                $newFileName = uniqid() . '.' . $fileExtension;
                $targetFilePath = $uploadDir . $newFileName;

                // ตรวจสอบว่าไดเรกทอรีสำหรับอัปโหลดมีอยู่แล้วหรือไม่
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true); // สร้างไดเรกทอรีถ้ายังไม่มี
                }

                // ย้ายไฟล์ที่อัปโหลดไปยังไดเรกทอรีปลายทาง
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    // Insert ข้อมูลลงฐานข้อมูล
                    $sql = "INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);

                    // การจัดการข้อผิดพลาด
                    if ($stmt) {
                        $stmt->bind_param("ssis", $name, $description, $price, $newFileName);

                        if ($stmt->execute()) {
                            // ปิดการเชื่อมต่อฐานข้อมูลและไปที่หน้าแสดงสินค้า
                            $conn->close();
                            header("Location: show_products.php");
                            exit;
                        } else {
                            $errorMessage = "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $stmt->error;
                        }

                        $stmt->close();
                    } else {
                        $errorMessage = "เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error;
                    }
                } else {
                    $errorMessage = "ไม่สามารถอัปโหลดไฟล์ได้";
                }
            }
        }
    } else {
        $errorMessage = "กรุณาเลือกไฟล์รูปภาพ";
    }

    // แสดงข้อผิดพลาดหากมี
    if (!empty($errorMessage)) {
        echo "<div class='alert alert-danger'>{$errorMessage}</div>";
    }

    $conn->close();
}
?>