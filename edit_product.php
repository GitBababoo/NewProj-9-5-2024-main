
<?php
// รวมไฟล์การเชื่อมต่อฐานข้อมูล
include 'db_connect.php';

// เชื่อมต่อกับฐานข้อมูล
$conn = db_connect();

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die("ไม่สามารถเชื่อมต่อฐานข้อมูล: " . mysqli_connect_error());
}

// ตรวจสอบว่ามี id สินค้าที่ต้องการแก้ไขหรือไม่
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // ดึงข้อมูลสินค้าจากฐานข้อมูล
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        // ไม่พบสินค้า
        echo "ไม่พบสินค้า";
        exit;
    }
} else {
    // ไม่มี id สินค้า
    echo "กรุณาระบุ id สินค้า";
    exit;
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขสินค้า</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h1>แก้ไขสินค้า</h1>
    <form id="editProductForm" action="update_product_action.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

        <div class="form-group">
            <label for="name">ชื่อสินค้า:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>" required>
        </div>

        <div class="form-group">
            <label for="description">คำอธิบาย:</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?php echo $product['description']; ?></textarea>
        </div>

        <div class="form-group">
            <label for="price">ราคา:</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>
        </div>

        <div class="form-group">
            <label for="image">อัปโหลดรูปภาพ:</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <?php if (isset($product['image']) && $product['image'] != "") { ?>
                <img src="uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="max-width: 200px; margin-top: 10px;">
            <?php } ?>
        </div>

        <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
    </form>
    <div id="responseMessage" class="mt-3"></div>
</div>

<script>
    $(document).ready(function() {
        $('#editProductForm').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#responseMessage').html(response);
                    // กรณีการอัปเดตสำเร็จ redirect ไปยังหน้าแสดงสินค้า
                    window.location.href = "show_products.php";
                },
                error: function(response) {
                    $('#responseMessage').html(response.responseText);
                }
            });
        });
    });
</script>
</body>
</html>

