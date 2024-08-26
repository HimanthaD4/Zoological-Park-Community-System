<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZooParc Food Outlets</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('../../images/fox.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            margin-top: 150px;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            background: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 300px;
            overflow: hidden;
            transition: transform 0.3s ease;
            text-align: center;
            cursor: pointer;
            position: relative;
            padding-top: 20px;
            padding-left: 20px;
            padding-right: 20px;
            padding-bottom: 20px;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .card img:hover {
            animation: shake 0.6s ease-in-out;
        }
        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            50% { transform: translateX(10px); }
            75% { transform: translateX(-10px); }
            100% { transform: translateX(0); }
        }
        .card-body {
            padding: 15px;
        }
        .card-title {
            font-family: "Poppins", sans-serif;
            font-weight: 500;
            font-style: normal;
        }
        .price-list {
            display: none;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            margin-top: 60px;
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 800px;
            z-index: 1000;
        }
        .price-list h5 {
            margin-bottom: 15px;
            font-size: 1.5rem;
            color: #333;
        }
        .price-list table {
            width: 100%;
            border-collapse: collapse;
        }
        .price-list th, .price-list td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .price-list th {
            background-color: #f8f9fa;
            color: #004d40;
        }
        .price-list td {
            font-size: 1rem;
            color: #004d40;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #dc3545;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
        }
        .close-btn:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <?php include '../../components/userHeader.php'; ?>
    <div class="container">
        <div class="card-container">
            <div class="card" data-shop="drinks">
                <img src="../../images/shop/drink.png" alt="Drinks Shop">
                <div class="card-body">
                    <h5 class="card-title">The Hydration Station</h5>
                </div>
            </div>
            <div class="card" data-shop="buns">
                <img src="../../images/shop/bun.png" alt="Buns Shop">
                <div class="card-body">
                    <h5 class="card-title">Buns & More</h5>
                </div>
            </div>
            <div class="card" data-shop="snacks">
                <img src="../../images/shop/snack.png" alt="Snacks Shop">
                <div class="card-body">
                    <h5 class="card-title">Snack Haven</h5>
                </div>
            </div>
        </div>
        <!-- Price List Containers -->
        <div class="price-list" id="drinks-price-list">
            <button class="close-btn">&times;</button>
            <h5>The Hydration Station Price List</h5>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Soft Drink</td><td>$2.00</td></tr>
                    <tr><td>Juice</td><td>$3.00</td></tr>
                    <tr><td>Water</td><td>$1.00</td></tr>
                    <tr><td>Iced Tea</td><td>$2.50</td></tr>
                    <tr><td>Energy Drink</td><td>$3.50</td></tr>
                    <tr><td>Soda</td><td>$2.00</td></tr>
                    <tr><td>Lemonade</td><td>$2.50</td></tr>
                    <tr><td>Hot Chocolate</td><td>$2.00</td></tr>
                    <tr><td>Milkshake</td><td>$4.00</td></tr>
                    <tr><td>Fruit Punch</td><td>$3.00</td></tr>
                </tbody>
            </table>
        </div>
        <div class="price-list" id="buns-price-list">
            <button class="close-btn">&times;</button>
            <h5>Buns & More Price List</h5>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Cinnamon Bun</td><td>$2.50</td></tr>
                    <tr><td>Chocolate Bun</td><td>$3.00</td></tr>
                    <tr><td>Plain Bun</td><td>$1.50</td></tr>
                    <tr><td>Raisin Bun</td><td>$2.00</td></tr>
                    <tr><td>Apple Cinnamon Bun</td><td>$2.75</td></tr>
                    <tr><td>Blueberry Bun</td><td>$2.50</td></tr>
                    <tr><td>Pecan Bun</td><td>$3.00</td></tr>
                    <tr><td>Sticky Bun</td><td>$2.75</td></tr>
                    <tr><td>Chocolate Chip Bun</td><td>$2.50</td></tr>
                    <tr><td>Maple Bun</td><td>$3.00</td></tr>
                </tbody>
            </table>
        </div>
        <div class="price-list" id="snacks-price-list">
            <button class="close-btn">&times;</button>
            <h5>Snack Haven Price List</h5>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Chips</td><td>$1.50</td></tr>
                    <tr><td>Popcorn</td><td>$2.00</td></tr>
                    <tr><td>Nachos</td><td>$3.00</td></tr>
                    <tr><td>Cookies</td><td>$2.00</td></tr>
                    <tr><td>Trail Mix</td><td>$2.50</td></tr>
                    <tr><td>Peanuts</td><td>$1.75</td></tr>
                    <tr><td>Granola Bars</td><td>$1.50</td></tr>
                    <tr><td>Jerky</td><td>$3.00</td></tr>
                    <tr><td>Cheese Sticks</td><td>$2.50</td></tr>
                    <tr><td>Fruit Slices</td><td>$2.00</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var cards = document.querySelectorAll('.card');
            var priceLists = document.querySelectorAll('.price-list');
            var closeBtns = document.querySelectorAll('.close-btn');

            cards.forEach(function (card) {
                card.addEventListener('click', function () {
                    var shopId = card.getAttribute('data-shop');

                    priceLists.forEach(function (priceList) {
                        priceList.style.display = 'none';
                    });

                    document.getElementById(shopId + '-price-list').style.display = 'block';
                });
            });

            closeBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var priceList = btn.parentElement;
                    priceList.style.display = 'none';
                });
            });
        });
    </script>
</body>
</html>
