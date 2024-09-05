<?php
// รวมไฟล์การเชื่อมต่อฐานข้อมูล
include 'db_connect.php';

// เชื่อมต่อกับฐานข้อมูล
$conn = db_connect();

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die("ไม่สามารถเชื่อมต่อฐานข้อมูล: " . mysqli_connect_error());
}

// ตรวจสอบว่ามีข้อมูล POST หรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจากฟอร์ม
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // ตรวจสอบว่ามีรูปภาพใหม่หรือไม่
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // ข้อมูลเกี่ยวกับรูปภาพที่อัปโหลด
        $imageFileType = strtolower(pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION));
        $imageName = uniqid() . "." . $imageFileType;
        $targetDir = "uploads/"; // กำหนดโฟลเดอร์สำหรับเก็บรูปภาพ
        $targetFile = $targetDir . $imageName;

        // อัปโหลดรูปภาพ
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // อัปเดตข้อมูลสินค้าในฐานข้อมูล
            $sql = "UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssd", $name, $description, $price, $imageName, $id);

            if ($stmt->execute()) {
                echo "แก้ไขสินค้าสำเร็จ";
            } else {
                echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ: " . $_FILES['image']['error'];
        }
    } else {
        // ไม่ได้อัปโหลดรูปภาพใหม่ อัปเดตข้อมูลสินค้าในฐานข้อมูลโดยไม่เปลี่ยนรูปภาพ
        $sql = "UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdi", $name, $description, $price, $id);

        if ($stmt->execute()) {
            echo "แก้ไขสินค้าสำเร็จ";
        } else {
            echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    echo "กรุณาใช้ POST method";
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>