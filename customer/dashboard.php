<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Gorengan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .product-card {
            transition: transform 0.2s;
            height: 100%;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .price-tag {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ffc107;
            color: #000;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
        }
        .product-img {
            height: 200px;
            object-fit: cover;
        }
        .add-to-cart {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }
        .category-buttons {
            margin-bottom: 20px;
        }
        .category-buttons .btn {
            margin: 5px;
            border-radius: 20px;
            padding: 8px 20px;
        }
        .category-buttons .btn.active {
            background-color: #ffc107;
            color: #000;
            border-color: #ffc107;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-utensils mr-2"></i>Gorengan
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('customer/cart') ?>">
                            <i class="fas fa-shopping-cart mr-1"></i>Keranjang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('auth/logout') ?>">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="jumbotron bg-warning text-white">
            <h1 class="display-4">Selamat Datang di Gorengan!</h1>
            <p class="lead">Nikmati berbagai macam gorengan lezat dengan harga terjangkau</p>
        </div>

        <!-- Category Buttons -->
        <div class="category-buttons text-center">
            <button class="btn btn-outline-warning active" data-category="all">Semua</button>
            <button class="btn btn-outline-warning" data-category="gorengan">Gorengan</button>
            <button class="btn btn-outline-warning" data-category="minuman">Minuman</button>
            <button class="btn btn-outline-warning" data-category="snack">Snack</button>
        </div>

        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari menu gorengan...">
                    <div class="input-group-append">
                        <button class="btn btn-warning" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row">
            <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card product-card shadow-sm">
                    <div class="position-relative">
                        <?php if($product->photo): ?>
                            <img src="<?= base_url('uploads/' . $product->photo) ?>" class="card-img-top product-img" alt="<?= $product->name ?>">
                        <?php else: ?>
                            <img src="<?= base_url('assets/img/default-food.jpg') ?>" class="card-img-top product-img" alt="<?= $product->name ?>">
                        <?php endif; ?>
                        <span class="price-tag">Rp <?= number_format($product->price, 0, ',', '.') ?></span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product->name) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($product->description) ?></p>
                        <button class="btn btn-warning add-to-cart" onclick="addToCart(<?= $product->id ?>)">
                            <i class="fas fa-cart-plus mr-1"></i>Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addToCart(productId) {
            $.ajax({
                url: '<?= base_url('customer/add_to_cart') ?>',
                type: 'POST',
                data: { product_id: productId },
                dataType: 'json',
                success: function(response) {
                    if(response.status === 'success') {
                        alert('Produk berhasil ditambahkan ke keranjang!');
                    } else {
                        alert('Gagal menambahkan produk ke keranjang');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan sistem');
                }
            });
        }

        // Category filter
        $('.category-buttons .btn').click(function() {
            $('.category-buttons .btn').removeClass('active');
            $(this).addClass('active');
            // Add category filtering logic here
        });

        // Search functionality
        $('#searchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('.product-card').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    </script>
</body>
</html>
