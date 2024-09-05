<?php
// รวมไฟล์การเชื่อมต่อฐานข้อมูล
include 'db_connect.php';

// เชื่อมต่อกับฐานข้อมูล
$conn = db_connect();

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die("ไม่สามารถเชื่อมต่อฐานข้อมูล: " . mysqli_connect_error());
}

// กำหนดจำนวนสินค้าต่อหน้า
$productsPerPage = 6;

// กำหนดหน้าปัจจุบัน
$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;

// กำหนดคำค้นหาเริ่มต้น
$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";

// กำหนดการเรียงลำดับเริ่มต้น
$orderBy = isset($_GET['orderBy']) ? mysqli_real_escape_string($conn, $_GET['orderBy']) : "name";
$orderDir = isset($_GET['orderDir']) ? mysqli_real_escape_string($conn, $_GET['orderDir']) : "ASC";

// คำนวณ offset สำหรับ pagination
$offset = ($currentPage - 1) * $productsPerPage;

// ดึงข้อมูลสินค้าสำหรับหน้าปัจจุบัน
$sql = "SELECT * FROM products";
if ($searchTerm !== "") {
    $sql .= " WHERE name LIKE ? OR description LIKE ?";
}
$sql .= " ORDER BY $orderBy $orderDir LIMIT $offset, $productsPerPage";

$stmt = $conn->prepare($sql);
if ($searchTerm !== "") {
    // ส่งค่าผ่าน reference
    $searchTermRef = &$searchTerm;
    $stmt->bind_param("ss", $searchTermRef, $searchTermRef);
}
$stmt->execute();
$result = $stmt->get_result();

// ดึงข้อมูลทั้งหมดสำหรับ pagination
$allProductsSql = "SELECT * FROM products";
if ($searchTerm !== "") {
    $allProductsSql .= " WHERE name LIKE ? OR description LIKE ?";
}

$allProductsStmt = $conn->prepare($allProductsSql);
if ($searchTerm !== "") {
    // สร้าง reference
    $searchTermRef = &$searchTerm;
    $allProductsStmt->bind_param("ss", $searchTermRef, $searchTermRef);
}
$allProductsStmt->execute();
$allProductsResult = $allProductsStmt->get_result();
$totalProducts = $allProductsResult->num_rows;

// คำนวณจำนวนหน้าทั้งหมด
$totalPages = ceil($totalProducts / $productsPerPage);

// ฟังก์ชั่นสำหรับแสดงข้อความแจ้งเตือน
function showToast($type, $message) {
    echo '<div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" id="'.$type.'Toast" style="display:none;">';
    echo '<div class="toast-header">';
    echo '<strong class="mr-auto">'.($type == 'success' ? 'สำเร็จ' : 'ข้อผิดพลาด').'</strong>';
    echo '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">';
    echo '<span aria-hidden="true">×</span>';
    echo '</button>';
    echo '</div>';
    echo '<div class="toast-body">';
    echo htmlspecialchars($message);
    echo '</div>';
    echo '</div>';
}

// เรียกใช้ฟังก์ชั่น showToast เพื่อแสดง toasts (ต้องเรียกในส่วนของ AJAX สำหรับ add_product_action.php, edit_product_action.php และ delete_product.php)
showToast('success', '');
showToast('error', '');

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หลังร้านค้า</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- jQuery และ Bootstrap JS (แนะนำให้ใส่หลัง Bootstrap CSS) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .container {
            background-color: white;
            padding: 20px;
            margin: 20px auto;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 900px;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .product-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
            position: relative;
            cursor: pointer;
            text-align: center; /* จัดข้อความให้居กลาง */
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .product-image {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
            margin-bottom: 10px; /* เพิ่ม margin ใต้รูปภาพ */
        }
        .product-card:hover .product-image {
            transform: scale(1.1);
        }
        .product-name {
            font-size: 1.4rem; /* เพิ่มขนาด font ของชื่อสินค้า */
            font-weight: bold;
            margin-bottom: 5px;
        }
        .product-price {
            font-size: 1.2rem; /* เพิ่มขนาด font ของราคา */
            color: #007bff;
            margin-bottom: 10px;
        }
        .product-description {
            font-size: 1rem; /* เพิ่มขนาด font ของคำอธิบาย */
            line-height: 1.5;
            margin-bottom: 15px;
        }
        .button {
            padding: 8px 12px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        .toast-body {
            font-size: 14px;
            font-weight: normal;
            line-height: 1.5;
            text-align: left;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            list-style: none;
            padding: 0;
        }
        .pagination li {
            margin: 0 5px;
        }
        .pagination a {
            display: block;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .pagination a:hover {
            background-color: #eee;
        }
        .pagination .active a {
            background-color: #007bff;
            color: white;
        }
        #searchInput {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 8px 12px;
        }
        #searchInput::placeholder {
            color: #999;
        }
        /* ปรับปรุงการจัดวางรูปภาพสำหรับหน้าจอขนาดเล็ก */
        @media (max-width: 768px) {
            .col-md-4 {
                width: 100%;
            }
            .product-image {
                max-height: 150px;
            }
        }
        /* ปรับปรุงรูปลักษณ์ปุ่มสำหรับหน้าจอขนาดเล็ก */
        @media (max-width: 576px) {
            .button {
                display: block;
                width: 100%;
                margin-bottom: 5px;
            }
        }
        /* ปรับปรุงส่วนหัวตารางสำหรับเรียงลำดับ */
        .table th {
            cursor: pointer;
        }
        .table th i {
            float: right;
            margin-left: 5px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        /* ปรับปรุงตารางเพื่อให้สวยงามมากขึ้น */
        .table {
            border-collapse: separate;
            border-spacing: 0 10px; /* เพิ่มระยะห่างระหว่างเซลล์ */
        }
        .table th {
            background-color: #f5f5f5; /* เพิ่มสีพื้นหลังให้หัวตาราง */
            text-align: center; /* จัดตำแหน่งข้อความในหัวตาราง */
        }
        .table td {
            padding: 10px; /* ปรับแต่งระยะห่างในเซลล์ */
        }
        /* เพิ่ม style ให้ปุ่มค้นหาสวยขึ้น */
        #searchForm .form-control {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 8px 12px;
        }
        #searchForm .btn {
            padding: 8px 12px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }
        #searchForm .btn:hover {
            background-color: #0056b3;
        }
        /* เพิ่ม style ให้ปุ่ม เพิ่มสินค้า สวยขึ้น */
        #addProductModal .btn-primary {
            padding: 8px 12px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }
        #addProductModal .btn-primary:hover {
            background-color: #0056b3;
        }
        /* ปรับปรุง style ของ pagination ให้สวยขึ้น */
        .pagination {
            margin-top: 20px;
            justify-content: center;
            align-items: center;
            list-style: none;
            padding: 0;
        }
        .pagination li {
            margin: 0 5px;
        }
        .pagination a {
            display: block;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .pagination a:hover {
            background-color: #eee;
        }
        .pagination .active a {
            background-color: #007bff;
            color: white;
        }
        /* ปรับปรุง style ให้ product card ดูสวยงามมากขึ้น */
        .product-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
            position: relative;
            cursor: pointer;
            text-align: center; /* จัดข้อความให้居กลาง */
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .product-image {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
            margin-bottom: 10px; /* เพิ่ม margin ใต้รูปภาพ */
        }
        .product-card:hover .product-image {
            transform: scale(1.1);
        }
        .product-name {
            font-size: 1.4rem; /* เพิ่มขนาด font ของชื่อสินค้า */
            font-weight: bold;
            margin-bottom: 5px;
        }
        .product-price {
            font-size: 1.2rem; /* เพิ่มขนาด font ของราคา */
            color: #007bff;
            margin-bottom: 10px;
        }
        .product-description {
            font-size: 1rem; /* เพิ่มขนาด font ของคำอธิบาย */
            line-height: 1.5;
            margin-bottom: 15px;
        }
        /* ปรับปรุงส่วน header ของเว็บไซต์ */
        .page-header {
            background-color: #f0f0f0; /* เปลี่ยนสีพื้นหลังของ header */
            padding: 20px 0;
            text-align: center;
            margin-bottom: 20px; /* เพิ่มระยะห่างด้านล่างของ header */
        }
        .page-header h1 {
            margin-bottom: 0; /* ลบระยะห่างด้านล่างของ h1 ใน header */
            font-size: 2rem; /* ปรับขนาด font ของ h1 ใน header */
        }
        /* เพิ่ม style ให้ปุ่ม edit และ delete ดูสวยขึ้น */
        .product-card .btn-warning {
            margin-right: 5px;
            padding: 8px 12px;
            color: white;
            background-color: #ffc107; /* สีเหลืองของ bootstrap */
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .product-card .btn-warning:hover {
            background-color: #e0a800; /* เปลี่ยนสีปุ่มเมื่อ hover */
        }
        .product-card .btn-danger {
            margin-right: 5px;
            padding: 8px 12px;
            color: white;
            background-color: #dc3545; /* สีแดงของ bootstrap */
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .product-card .btn-danger:hover {
            background-color: #c82333; /* เปลี่ยนสีปุ่มเมื่อ hover */
        }
    </style>
</head>
<body>
<header class="page-header">
    <h1>หลังร้านค้า</h1>
</header>
<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">
                <i class="fas fa-plus"></i> เพิ่มสินค้า
            </button>
        </div>
        <div class="col-md-6">
            <form class="form-inline" id="searchForm">
                <div class="form-group mx-sm-3">
                    <input type="text" class="form-control" id="searchInput" placeholder="ค้นหาสินค้า..." value="<?php echo $searchTerm; ?>" autocomplete="off">
                </div>
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-search"></i> ค้นหา
                </button>
            </form>
        </div>
    </div>

    <div class="row" id="productGrid">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // แสดงข้อมูลสินค้าเป็น card
                echo '<div class="col-md-4 product-card" data-product-id="' . $row["id"] . '">';
                // แก้ไขที่นี่: ระบุ path ของรูปภาพ
                echo '<img src="uploads/' . $row["image"] . '" class="product-image" alt="' . $row["name"] . '">';
                echo '<div class="product-details">';
                echo '<h2 class="product-name">' . $row["name"] . '</h2>';
                echo '<p class="product-price">' . $row["price"] . ' บาท</p>';
                echo '<p class="product-description">' . $row["description"] . '</p>';
                echo '<a href="edit_product.php?id=' . $row["id"] . '" class="btn btn-warning">
                    <i class="fas fa-edit"></i> แก้ไข
                </a>';
                echo '<a href="delete_product.php?id=' . $row["id"] . '" class="btn btn-danger">
                    <i class="fas fa-trash"></i> ลบ
                </a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="col-12 text-center">ไม่พบข้อมูลสินค้า</div>';
        }
        ?>
    </div>

    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php
            // ปุ่ม Previous
            if ($currentPage > 1) {
                $queryString = "page=" . ($currentPage - 1) . "&search=" . $searchTerm . "&orderBy=" . $orderBy . "&orderDir=" . $orderDir;
                echo '<li class="page-item"><a class="page-link" href="?' . $queryString . '">Previous</a></li>';
            }

            // แสดงหมายเลขหน้า
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $currentPage) {
                    $queryString = "page=" . $i . "&search=" . $searchTerm . "&orderBy=" . $orderBy . "&orderDir=" . $orderDir;
                    echo '<li class="page-item active"><a class="page-link" href="?' . $queryString . '">' . $i . '</a></li>';
                } else {
                    $queryString = "page=" . $i . "&search=" . $searchTerm . "&orderBy=" . $orderBy . "&orderDir=" . $orderDir;
                    echo '<li class="page-item"><a class="page-link" href="?' . $queryString . '">' . $i . '</a></li>';
                }
            }

            // ปุ่ม Next
            if ($currentPage < $totalPages) {
                $queryString = "page=" . ($currentPage + 1) . "&search=" . $searchTerm . "&orderBy=" . $orderBy . "&orderDir=" . $orderDir;
                echo '<li class="page-item"><a class="page-link" href="?' . $queryString . '">Next</a></li>';
            }
            ?>
        </ul>
    </nav>
</div>

<!-- Modal สำหรับเพิ่มสินค้าใหม่ -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">เพิ่มสินค้าใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" action="add_product_action.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">ชื่อสินค้า:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">คำอธิบาย:</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">ราคา:</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="image">อัปโหลดรูปภาพ:</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">เพิ่มสินค้า</button>
                </form>
                <div id="responseMessage" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // ส่งแบบฟอร์มไปยัง add_product_action.php ผ่าน AJAX
        $('#addProductForm').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#responseMessage').html(response);
                    $('#addProductForm')[0].reset();
                    $('#successToast .toast-body').text('เพิ่มสินค้าสำเร็จ');
                    $('#successToast').toast('show');
                    setTimeout(function() {
                        $('#addProductModal').modal('hide');
                        // โหลดข้อมูลสินค้าใหม่โดยใช้ AJAX
                        $.ajax({
                            url: 'show_products_ajax.php?search=' + $('#searchInput').val() + '&orderBy=' + '<?php echo $orderBy; ?>' + '&orderDir=' + '<?php echo $orderDir; ?>',
                            success: function(data) {
                                $('#productGrid').html(data);
                            }
                        });
                    }, 2000);
                },
                error: function(response) {
                    $('#errorToast .toast-body').text(response.responseText);
                    $('#errorToast').toast('show');
                }
            });
        });

        // ค้นหาสินค้า (ต้องเพิ่มเติมใน add_product_action.php ด้วย)
        $('#searchForm').on('submit', function(event) {
            event.preventDefault();

            var searchTerm = $('#searchInput').val();
            if (searchTerm !== "") {
                window.location.href = '?search=' + searchTerm + '&orderBy=' + '<?php echo $orderBy; ?>' + '&orderDir=' + '<?php echo $orderDir; ?>';
            } else {
                window.location.href = '?page=1&orderBy=' + '<?php echo $orderBy; ?>' + '&orderDir=' + '<?php echo $orderDir; ?>';
            }
        });

        // ปรับปรุงการจัดวางการแสดงผลของหน้าต่างแจ้งเตือน
        $('.toast').toast({
            delay: 3000 // แสดงผลเป็นเวลา 3 วินาที
        });

        // เติมสีให้กับตัวเลือกหน้า
        $('.pagination a').click(function() {
            $('.pagination a').removeClass('active'); // เอาคลาส active ออกก่อน
            $(this).addClass('active'); // ใส่คลาส active ให้กับ link ที่กด
        });

        // เพิ่ม Event click ให้กับ Product card เพื่อ redirect ไปยังหน้า detail
        $('.product-card').click(function() {
            var productId = $(this).data('product-id'); // สมมติว่า คุณมี data attribute ใน product-card
            if (productId) {
                window.location.href = 'product_details.php?id=' + productId;
            }
        });

        function sortTable(column, element) {
            var currentOrderDir = '<?php echo $orderDir; ?>';
            var newOrderDir = (currentOrderDir === 'ASC') ? 'DESC' : 'ASC';

            var queryString = '?page=<?php echo $currentPage; ?>&search=<?php echo $searchTerm; ?>&orderBy=' + column + '&orderDir=' + newOrderDir;
            window.location.href = queryString;

            // เปลี่ยนไอคอนการเรียงลำดับ
            $('.table th i').removeClass('fas fa-sort-up fas fa-sort-down').addClass('fas fa-sort');
            $(element).find('i').removeClass('fas fa-sort').addClass('fas fa-' + (newOrderDir === 'ASC' ? 'sort-up' : 'sort-down'));
        }

        function addToCart(productId) {
            // เพิ่มสินค้าลงในตะกร้า
            $.ajax({
                url: 'add_to_cart.php',
                method: 'POST',
                data: { productId: productId },
                success: function(response) {
                    $('#successToast .toast-body').text(response);
                    $('#successToast').toast('show');
                    // ปรับปรุงจำนวนสินค้าในตะกร้า
                    // (คุณอาจต้องเขียนฟังก์ชันสำหรับปรับปรุงจำนวนสินค้าในตะกร้าเอง)
                },
                error: function(response) {
                    $('#errorToast .toast-body').text(response);
                    $('#errorToast').toast('show');
                }
            });
        }
    });
</script>
</body>
</html>