<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ร้านค้าออนไลน์ - Shopify</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Parallax -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jarallax/1.12.0/jarallax.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            overflow-x: hidden;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Navbar */
        .navbar {
            transition: background-color 0.3s;
        }
        .navbar.scrolled {
            background-color: rgba(0, 0, 0, 0.9);
        }
        .navbar-nav .nav-link {
            color: white;
            padding: 1rem 1.5rem;
            transition: 0.3s;
            font-size: 16px;
        }
        .navbar-nav .nav-link:hover {
            color: #FF9950;
            background-color: transparent;
            border-bottom: 3px solid #FF9950;
            border-radius: 0;
        }
        .navbar-nav .nav-link.active {
            background-color: transparent;
            color: #FF9950;
            border-bottom: 3px solid #FF9950;
            border-radius: 0;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .navbar-toggler {
            border: none;
        }

        /* Hero Banner */
        .hero-banner {
            min-height: 600px;
            background-size: cover;
            background-position: center;
            background-image: url('https://cdn.pixabay.com/photo/2022/09/15/06/14/pattern-7455773_1280.png');
            color: white;
            display: flex;
            align-items: center; /*  แก้ไขให้อยู่ตรงกลาง  */
            justify-content: center;
            text-align: center;
            position: relative;
        }
        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.2); /* ปรับค่าความทึบแสง */
        }
        .hero-banner h1 {
            font-size: 4rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* เพิ่มเงาให้ตัวอักษร */
        }
        .hero-banner p {
            font-size: 1.5rem;
            font-weight: 400; /* ปรับความหนาของตัวอักษรให้เป็น 400 */
            margin-bottom: 20px; /* เพิ่มระยะห่างจากตัวอักษรข้างล่าง */
        }
        .hero-banner a {
            animation: zoomIn 1s ease-in-out;
            display: inline-block;
            padding: 12px 25px; /* เพิ่ม padding สำหรับ button */
            border-radius: 20px; /* ปรับ radius ให้โค้งมน */
            background-color: #FF9950; /* เพิ่มสี background */
            color: #fff; /* เพิ่มสี text */
            text-decoration: none; /* ลบ underline */
            font-weight: bold; /* เพิ่มความหนาให้ตัวอักษร */
            transition: background-color 0.3s ease;
        }

        .hero-banner a:hover {
            background-color: #ff7e2e; /* ปรับสี background เมื่อ hover */
        }

        @keyframes slideInDown {
            0% {
                transform: translateY(-100px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideInUp {
            0% {
                transform: translateY(100px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes zoomIn {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Owl Carousel */
        .owl-carousel .item {
            margin: 10px;
        }
        .owl-carousel .item img {
            border-radius: 10px;
            width: 100%;
        }
        .owl-theme .owl-nav [class*='owl-'] {
            background: rgba(0,0,0,0.4);
            border-radius: 50%;
            width: 35px;
            height: 35px;
            color: white;
            text-align: center;
            padding-top: 8px;
            transition: 0.3s;
            opacity: 0.7;
        }
        .owl-theme .owl-nav [class*='owl-']:hover {
            opacity: 1;
        }
        .owl-carousel {
            margin-top: 20px;
        }
        .owl-dots .owl-dot.active {
            background: #FF9950;
        }
        .owl-dots .owl-dot span {
            background: #ccc;
            border-radius: 50%;
        }

        /*  Section */
        section {
            padding: 40px 0;
        }
        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease-in-out;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /*  Card */
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        .card-img-top {
            border-radius: 10px 10px 0 0;
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            padding: 15px;
            background-color: #fff;
        }
        .card-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .card-text {
            color: #777;
            font-size: 14px;
        }

        /* Button */
        .btn-warning {
            background-color: #FF9950;
            border: none;
            padding: 12px 25px;
            border-radius: 20px;
            transition: 0.3s;
            color: white;
        }
        .btn-warning:hover {
            background-color: #ff7e2e;
        }

        /* About Us */
        .about-us p {
            line-height: 1.6;
            color: #555;
        }

        /*  Cart  */
        .cart-items ul {
            list-style: none;
            padding: 0;
            margin-bottom: 0;
        }
        .cart-items li {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .cart-items li span {
            display: block;
            font-weight: bold;
        }
        .cart-items li .price {
            font-size: 14px;
        }

        /* Footer */
        footer {
            padding: 15px;
            background-color: #212529;
            color: white;
        }

        /*  Search Box  */
        .search {
            position: relative;
            width: 55px;
            height: 54px;
            border-radius: 30px;
            padding: 10px;
            transition: 0.3s;
            cursor: pointer;
            background-repeat: no-repeat;
            font-size: 15px;
            color: transparent;
            border: 1px solid white;
            overflow: hidden;
            background: url(https://icons8.com/icon/112468/search) no-repeat center;
            background-size: 22px;
        }
        .search:hover {
            border: 1px solid #FF9950;
        }
        .search:focus {
            width: 250px;
            padding-left: 40px;
            color: white;
            outline: none;
            border: 1px solid #FF9950;
            background-color: transparent;
            background: url(https://icons8.com/icon/112468/search) no-repeat 10px center;
            background-size: 22px;
            animation: grow 0.3s ease-in-out;
        }
        @keyframes grow {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.1);
            }
        }
        .search::-webkit-input-placeholder {
            color: #999;
            font-size: 14px;
            opacity: 0.7;
        }
        .search:-ms-input-placeholder {
            color: #999;
            font-size: 14px;
            opacity: 0.7;
        }
        .search::placeholder {
            color: #999;
            font-size: 14px;
            opacity: 0.7;
        }

        /* ปรับแต่ง Parallax Effect */
        .jarallax {
            background-position: 50% 50%;
            background-size: cover;
        }

        .jarallax-element {
            width: 100%;
            height: 100%;
        }

        /* ปรับแต่ง Scroll-Based Navigation */
        .scroll-smooth {
            scroll-behavior: smooth;
        }

        /* สไตล์ Pinned Elements */
        .pinned-section {
            position: sticky;
            top: 0;
            background-color: #fff;
            z-index: 10;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .pinned-section h2 {
            margin-top: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        /*  สินค้า  */
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            grid-gap: 20px;
            margin-top: 20px;
        }

        .product-item {
            text-align: center;
            padding: 10px;
            transition: transform 0.2s ease-in-out;
            border: 1px solid #ddd; /* เพิ่มเส้นขอบรอบ card */
            border-radius: 10px; /* ปรับ radius ให้ card มีมุมโค้งมน */
            background-color: #fff; /* เพิ่มสี background */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* เพิ่มเงาให้ card */
        }

        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        .product-item img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            transition: transform 0.2s ease-in-out;
            object-fit: cover;  /* ปรับขนาดภาพให้พอดีโดยไม่บิดเบือน */
        }
        .product-item img:hover {
            transform: scale(1.1);
        }
        .product-item h4 {
            font-size: 1.2rem;
            margin-top: 10px;
        }
        .product-item p {
            margin-top: 5px;
            color: #555;
        }
        .product-item .btn-buy {
            margin-top: 10px;
            background-color: #FF9950;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            transition: 0.3s;
            color: white;
        }
        .product-item .btn-buy:hover {
            background-color: #ff7e2e;
        }

        /* ปรับแต่ง Layout สำหรับสินค้า */
        .products-section {
            background-color: #f9f9f9;
            padding: 40px 0;
        }

        .products-section .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* คำอธิบายเกี่ยวกับการปรับปรุงเว็บไซต์ */
        .website-update {
            margin-bottom: 20px;
            animation: fadeInUp 1s ease-in-out;
        }

        /*  Cart  */
        .cart-items {
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
        }

        .cart-items .total-price {
            margin-top: 10px;
            font-weight: bold;
            font-size: 1.2rem;
            text-align: right;
        }

        .cart-items .total-price span {
            color: #FF9950;
        }

        .cart-items li button.remove-item {
            background: none;
            border: none;
            cursor: pointer;
            color: #777;
            font-size: 1rem;
        }

        .cart-items li button.remove-item:hover {
            color: #FF9950;
        }

        /* Animation For Hero Banner */
        .col-md-12.text-center  h1,
        .col-md-12.text-center p,
        .col-md-12.text-center a{
            transition: transform 0.5s ease, opacity 0.5s ease; /* เพิ่ม  transition  */
            animation-duration: 0.5s;
            animation-delay: 0.5s;
        }



        /*  กฏนี้ทำให้มองเห็นทันทีเมื่อเข้ามาใน  Page */

        .col-md-12.text-center {
            animation-delay:  0s !important; /* เพิ่ม !important เพื่อบังคับ overwrite CSS */
            padding: 0 30px;
        }
        /* Animation fadeInUp */
        @keyframes fadeInUp {
            from {
                transform: translate(0px, 100px) scale(0.8, 0.8);
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /*  Mobile Navbar Styling */
        @media (max-width: 768px) {
            /* ปรับแต่ง Hero Banner */
            .hero-banner {
                min-height: 400px;
            }
            .hero-banner h1 {
                font-size: 2.5rem;
            }
            .hero-banner p {
                font-size: 1.2rem;
            }

            /* ปรับแต่งสินค้า */
            .products {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); /* ปรับขนาดของสินค้าให้เล็กลง */
                grid-gap: 10px; /* ปรับขนาดของช่องว่างระหว่างสินค้าให้เล็กลง */
            }

            .products .product-item {
                text-align: center;
                padding: 8px;
            }

            .products .product-item img {
                max-width: 100%;
                height: auto;
                border-radius: 8px;
                object-fit: cover;
            }

            .products .product-item h4 {
                font-size: 1.1rem;
                margin-top: 8px;
            }

            .products .product-item p {
                margin-top: 5px;
                font-size: 12px; /* ปรับขนาดของข้อความให้เล็กลง */
            }
        }

        /*  Product Page */
        .product-page {
            padding: 40px 0;
        }

        .product-page .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .product-page .row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }

        .product-page .col-md-6 {
            padding-right: 20px; /* เพิ่มระยะห่างระหว่าง  col  */
            padding-left: 20px;  /* เพิ่มระยะห่างระหว่าง  col  */
        }

        .product-page img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .product-page h2 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product-page p {
            line-height: 1.6;
            color: #555;
            margin-bottom: 10px;
        }

        .product-page .price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #FF9950;
        }

        /*  Category Page */
        .category-page {
            padding: 40px 0;
        }

        .category-page .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .category-page h2 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .category-page .categories {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 20px;
        }

        .category-page .category-item {
            margin: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s ease-in-out, background-color 0.3s ease-in-out;
            width: 150px; /* ปรับขนาด width ให้พอดี */
            height: 100px; /* ปรับขนาด height ให้พอดี */
        }

        .category-page .category-item:hover {
            transform: translateY(-5px);
            background-color: #f2f2f2; /* เปลี่ยนสีพื้นหลังเมื่อโฮเวอร์ */
        }

        .category-page .category-item img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            transition: transform 0.2s ease-in-out;
        }

        .category-page .category-item:hover img {
            transform: scale(1.1); /* ย่อภาพเมื่อโฮเวอร์ */
        }

        .category-page .category-item h3 {
            margin-top: 10px;
            font-size: 1.2rem;
            font-weight: bold;
        }

        /*  สไตล์สำหรับส่วนแสดงผลผลิตภัณฑ์บน  Product Page และ Category Page  */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            grid-gap: 20px;
            margin-top: 20px;
        }
        .row1{
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -100px;
            margin-left: -365px;
        }
    </style>
</head>
<body class="scroll-smooth">
<!-- ส่วนหัว (Header) -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="#">ร้านค้าออนไลน์ - Shopify</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link scroll-animated" href="#hero-section">หน้าหลัก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link scroll-animated" href="#about-us">เกี่ยวกับเรา</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link scroll-animated" href="#products">สินค้า</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link scroll-animated" href="#contact">ติดต่อเรา</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link scroll-animated" href="#">เข้าสู่ระบบ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link scroll-animated" href="#">ลงทะเบียน</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link scroll-animated" href="#cart"><i class="fas fa-shopping-cart"></i> รถเข็น</a>
                </li>
                <li class="nav-item">
                    <input type="text" class="search" placeholder="ค้นหา...">
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ส่วน Hero Banner -->
<section id="hero-section" class="hero-banner jarallax">
    <div class="jarallax-element"></div>
    <div class="container">
        <div class="row1">
            <div class="col-md-12 text-center">
                <h1 class="display-4 animate__animated animate__fadeInDown">สินค้าคุณภาพ ราคาถูก</h1>
                <p class="lead animate__animated animate__fadeInUp">เลือกซื้อสินค้าออนไลน์ได้ง่ายๆ</p>
                <a href="#products" class="btn btn-warning btn-lg animate__animated animate__fadeInUp" style="translate: none; rotate: none; scale: none; opacity: 1; transform: translate(0px, 100px);">ดูสินค้าทั้งหมด</a>
            </div>
        </div>
    </div>
</section>

<!-- ส่วนแสดงสินค้า (Product Cards) -->
<section id="products" class="py-5 products-section">
    <div class="container">
        <h2 class="section-title">สินค้าแนะนำ</h2>
        <div class="row">
            <div class="col-md-12">
                <p class="website-update">เรามีสินค้าใหม่เข้ามาแล้ว! ดูนวัตกรรมล่าสุดที่นี่</p>
                <div class="products">
                    <!--  Product Card 1  -->
                    <div class="product-item">
                        <img src="images/shop%20f1.jpg" alt="สินค้า 1">
                        <h4>ชื่อสินค้า 1</h4>
                        <p>รายละเอียดของสินค้า 1...</p>
                        <button class="btn-buy" onclick="addItem('ชื่อสินค้า 1', 100)">ซื้อเลย</button>
                    </div>

                    <!--  Product Card 2  -->
                    <div class="product-item">
                        <img src="images/shop%20f2.jpg" alt="สินค้า 2">
                        <h4>ชื่อสินค้า 2</h4>
                        <p>รายละเอียดของสินค้า 2...</p>
                        <button class="btn-buy" onclick="addItem('ชื่อสินค้า 2', 200)">ซื้อเลย</button>
                    </div>

                    <!--  Product Card 3  -->
                    <div class="product-item">
                        <img src="images/shop%20f3.jpg" alt="สินค้า 3">
                        <h4>ชื่อสินค้า 3</h4>
                        <p>รายละเอียดของสินค้า 3...</p>
                        <button class="btn-buy" onclick="addItem('ชื่อสินค้า 3', 300)">ซื้อเลย</button>
                    </div>
                    <!--  Add More Product Cards as Needed  -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ส่วนเกี่ยวกับเรา -->
<section id="about-us" class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title">เกี่ยวกับเรา</h2>
        <div class="row">
            <div class="col-md-12">
                <p class="about-us">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a nibh sed enim porta sollicitudin at et lorem. Duis semper sem eget purus pharetra, sed faucibus risus congue. Phasellus feugiat justo sed sem volutpat, sit amet ultrices risus mattis. Suspendisse potenti. Aenean pulvinar bibendum velit.</p>
                <p class="about-us">Donec ut est sit amet quam blandit tempor vitae id nulla. Vestibulum et semper felis. Morbi aliquam est at orci convallis, sit amet aliquet tellus feugiat. Donec sit amet sapien sem. Ut vitae justo id neque vulputate euismod vitae a ligula. Sed vitae lorem felis. </p>
            </div>
        </div>
    </div>
</section>

<!-- ส่วนตะกร้าสินค้า (Pinned Element) -->
<section id="cart" class="py-5 pinned-section">
    <div class="container">
        <h2 class="section-title">ตะกร้าสินค้า</h2>
        <div class="cart-items">
            <ul id="cart-list">
                <!-- สินค้าในตะกร้าจะแสดงที่นี่ -->
            </ul>
            <div class="total-price">
                <span>รวม: </span> <span id="cart-total">0 บาท</span>
            </div>
        </div>
        <a href="#" class="btn btn-warning">สั่งซื้อ</a>
    </div>
</section>

<!-- ส่วนติดต่อเรา -->
<section id="contact" class="py-5">
    <div class="container">
        <h2 class="section-title">ติดต่อเรา</h2>
        <div class="row">
            <div class="col-md-12">
                <p>
                    <strong>ที่อยู่:</strong> 123 ถนนรัชดาภิเษก เขตดินแดง กรุงเทพฯ 10400
                </p>
                <p>
                    <strong>โทรศัพท์:</strong> 095-846-2520
                </p>
                <p>
                    <strong>อีเมล:</strong> pushilkun@shop.com
                </p>
                <p>
                    <a href="https://www.facebook.com/profile.php?id=61556729537857" target="_blank"><i class="fab fa-facebook-square"></i> Facebook</a>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ส่วนท้ายเว็บ (Footer) -->
<footer class="container-fluid bg-dark text-white py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p>© 2023 ร้านค้าออนไลน์ - Shopify</p>
            </div>
            <div class="col-md-6 text-right">
                <a href="#contact" class="text-white">ติดต่อเรา</a> |
                <a href="#" class="text-white">นโยบายความเป็นส่วนตัว</a>
            </div>
        </div>
    </div>
</footer>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Owl Carousel JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<!-- GreenSock Animation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
<!-- Jarallax JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jarallax/1.12.0/jarallax.min.js"></script>

<script>
    // ปรับแต่ง Navbar
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll > 100) {
            $("#mainNav").addClass("scrolled");
        } else {
            $("#mainNav").removeClass("scrolled");
        }
    });

    // เริ่มต้นการเลื่อนอัตโนมัติของ Owl Carousel
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: { items: 1 },
            600: { items: 2 },
            1000: { items: 3 }
        }
    });

    //  ใช้ Gsap Animation สำหรับ Hero Banner
    gsap.from('.hero-banner h1', {
        y: 100,
        opacity: 0,
        duration: 1,
        ease: "power2.inOut",
        delay: 0.5,
        stagger: 0.2
    });

    gsap.from('.hero-banner p', {
        y: 100,
        opacity: 0,
        duration: 1,
        ease: "power2.inOut",
        delay: 1,
    });

    gsap.from('.hero-banner a', {
        y: 100,
        opacity: 0,
        duration: 1,
        ease: "power2.inOut",
        delay: 1.5,
    });
    // เริ่มต้น Parallax Effect
    jarallax(document.querySelectorAll('.jarallax'), {
        speed: 0.5,
    });

    // ตัวอย่างของ Scroll-Triggered Animations
    gsap.fromTo('.section-title', { opacity: 0, y: 50 }, { opacity: 1, y: 0, duration: 1, scrollTrigger: {
            trigger: '.section-title',
            start: "top 80%",
            end: "bottom 20%",
            scrub: true
        }
    });

    //  ตัวอย่างการเลื่อนแบบ Smooth สำหรับเมนู
    var navLinks = document.querySelectorAll('.nav-link.scroll-animated');
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            var targetId = link.getAttribute('href');
            var targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({behavior: 'smooth'});
            }
        });
    });

    // Cart functionality
    let cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];

    function updateCart() {
        const cartList = document.getElementById('cart-list');
        const cartTotal = document.getElementById('cart-total');

        cartList.innerHTML = '';
        let totalPrice = 0;

        cartItems.forEach((item, index) => {
            const li = document.createElement('li');
            li.innerHTML = `
                        <span>${item.name}</span>
                        <span class="price">${item.price} บาท</span>
                        <button class="remove-item" onclick="removeItem(${index})">ลบ</button>
                    `;
            cartList.appendChild(li);
            totalPrice += parseInt(item.price);
        });

        cartTotal.textContent = totalPrice + " บาท";
        localStorage.setItem("cartItems", JSON.stringify(cartItems));
    }

    function addItem(name, price) {
        cartItems.push({name: name, price: price});
        updateCart();
    }

    function removeItem(index) {
        cartItems.splice(index, 1);
        updateCart();
    }

    // Call to display initial cart items on page load
    updateCart();

    //  Animation for  Product Card
    gsap.fromTo('.product-item',
        { y: 20, opacity: 0 },
        { y: 0, opacity: 1, duration: 0.8, stagger: 0.2, scrollTrigger: {
                trigger: '.product-item',
                start: 'top 80%',
                end: 'bottom 20%',
                scrub: true
            }
        });

    // Animation for  Category Item
    gsap.fromTo('.category-item',
        { scale: 0.8, opacity: 0 },
        { scale: 1, opacity: 1, duration: 1, stagger: 0.2, scrollTrigger: {
                trigger: '.category-item',
                start: 'top 80%',
                end: 'bottom 20%',
                scrub: true
            }
        });

    // สร้าง  Function  สำหรับ  Product Page
    const productDetails = [
        {
            "name": "เสื้อยืดสีดำ",
            "image": "images/1x.jpg",
            "description": "เสื้อยืดสีดำคอวี  ผ้าคอตตอน  นุ่มสบาย  เนื้อผ้าดี  ใส่สบาย",
            "price": "200"
        },
        {
            "name": "กางเกงยีนส์ขาเดฟ",
            "image": "images/x2.jpg",
            "description": "กางเกงยีนส์สีน้ำเงิน  ขาเดฟ  ตัดเย็บด้วย  ผ้า  ดี  ใส่สบาย",
            "price": "450"
        },
        //  Add More Product as Needed
    ];

    // Create  a  Product Detail Page dynamically
    productDetails.forEach(product => {
        const productPage = document.createElement('section');
        productPage.classList.add('product-page');
        productPage.innerHTML = `
            <div class="container">
                <h2 class="section-title">${product.name}</h2>
                <div class="row">
                    <div class="col-md-6">
                        <img src="${product.image}" alt="${product.name}">
                    </div>
                    <div class="col-md-6">
                        <h3>รายละเอียด</h3>
                        <p>${product.description}</p>
                        <p class="price">ราคา: ${product.price} บาท</p>
                        <button class="btn-warning" onclick="addItem('${product.name}', ${product.price})">ซื้อเลย</button>
                    </div>
                </div>
            </div>
            `;
        document.body.appendChild(productPage);
    });

    //  Create  a  Category  Page
    const categories = [
        {
            "name": "เสื้อผ้า",
            "image": "images/1x [250x250].jpg",
            "products": [
                {
                    "name": "เสื้อยืดสีดำ",
                    "image": "images/1x [250x250].jpg",
                    "description": "เสื้อยืดสีดำคอวี  ผ้าคอตตอน  นุ่มสบาย  เนื้อผ้าดี  ใส่สบาย",
                    "price": "200"
                },
                //  Add  More  Products
            ]
        },
        {
            "name": "กางเกง",
            "image": "images/x2 [150x150].jpg",
            "products": [
                {
                    "name": "กางเกงยีนส์ขาเดฟ",
                    "image": "images/x2 [150x150].jpg",
                    "description": "กางเกงยีนส์สีน้ำเงิน  ขาเดฟ  ตัดเย็บด้วย  ผ้า  ดี  ใส่สบาย",
                    "price": "450"
                },
                //  Add More Products
            ]
        },
        //  Add  More  Categories  as Needed
    ];

    const categoryPage = document.createElement('section');
    categoryPage.classList.add('category-page');
    categoryPage.innerHTML = `
        <div class="container">
            <h2 class="section-title">หมวดหมู่สินค้า</h2>
            <div class="categories">
                ${categories.map(category => `
                    <div class="category-item" onclick="showCategoryProducts('${category.name}')">
                        <img src="${category.image}" alt="${category.name}">
                        <h3>${category.name}</h3>
                    </div>
                `).join('')}
            </div>
        </div>
        `;

    // Create  Function  for  showing products from each  Category
    function showCategoryProducts(categoryName) {
        const selectedCategory = categories.find(category => category.name === categoryName);

        // Create  Dynamic  Product Grid
        const productGrid = document.createElement('div');
        productGrid.classList.add('product-grid');
        productGrid.innerHTML = selectedCategory.products.map(product => `
                <div class="product-item">
                    <img src="${product.image}" alt="${product.name}">
                    <h4>${product.name}</h4>
                    <p>${product.description}</p>
                    <button class="btn-buy" onclick="addItem('${product.name}', ${product.price})">ซื้อเลย</button>
                </div>
            `).join('');

        // Add  the Product Grid  to the  Category Page
        const categoriesSection = document.querySelector('.categories');
        categoriesSection.parentNode.insertBefore(productGrid, categoriesSection.nextSibling);

        //  Scroll  to the  top  of  the  Product Grid
        productGrid.scrollIntoView({ behavior: 'smooth' });
    }

    document.body.appendChild(categoryPage);

    // เริ่มต้น Parallax Effect
    jarallax(document.querySelectorAll('.jarallax'), {
        speed: 0.5,
    });

</script>
</body>
</html>

