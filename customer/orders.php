<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan | Gorengan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .order-card {
            transition: transform 0.2s;
        }
        .order-card:hover {
            transform: translateY(-5px);
        }
        .status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('customer/dashboard') ?>">
                <i class="fas fa-utensils mr-2"></i>Gorengan
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('customer/dashboard') ?>">
                            <i class="fas fa-home mr-1"></i>Menu
                        </a>
                    </li>
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

    <!-- Content -->
    <div class="container py-5">
        <h2 class="mb-4">Riwayat Pesanan</h2>

        <?php if (empty($orders)): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i>Belum ada pesanan
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($orders as $order): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card order-card">
                            <div class="card-body">
                                <span class="badge badge-<?= $order->status == 'pending' ? 'warning' : 
                                    ($order->status == 'processing' ? 'info' : 
                                    ($order->status == 'completed' ? 'success' : 'secondary')) ?> status-badge">
                                    <?= ucfirst($order->status) ?>
                                </span>
                                
                                <h5 class="card-title">Pesanan #<?= $order->id ?></h5>
                                <p class="card-text">
                                    <small class="text-muted">
                                        <?= date('d M Y H:i', strtotime($order->created_at)) ?>
                                    </small>
                                </p>
                                
                                <div class="mb-3">
                                    <strong>Detail Pesanan:</strong>
                                    <ul class="list-unstyled mt-2">
                                        <?php foreach ($order->items as $item): ?>
                                            <li>
                                                <?= $item->name ?> x <?= $item->quantity ?>
                                                <span class="float-right">
                                                    Rp <?= number_format($item->price * $item->quantity, 0, ',', '.') ?>
                                                </span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                                <div class="border-top pt-3">
                                    <div class="row">
                                        <div class="col">
                                            <strong>Total:</strong>
                                        </div>
                                        <div class="col text-right">
                                            <strong>Rp <?= number_format($order->total_price, 0, ',', '.') ?></strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <strong>Informasi Pengiriman:</strong>
                                    <p class="mb-1"><?= $order->customer_name ?></p>
                                    <p class="mb-1"><?= $order->address ?></p>
                                    <p class="mb-0"><?= $order->phone ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 