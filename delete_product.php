<?php
include 'db_connect.php';

$conn = db_connect();

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // ลบข้อมูลสินค้า
    $sql = "DELETE FROM products WHERE id = $product_id";
    if ($conn->query($sql) === TRUE) {
        header('Location: show_products.php');
        exit;
    } else {
        echo "Error deleting product: " . $conn->error;
    }
} else {
    header('Location: show_products.php');
    exit;
}
?>