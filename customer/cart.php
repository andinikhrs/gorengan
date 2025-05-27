<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang | Gorengan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('customer/dashboard') ?>">
                <i class="fas fa-utensils"></i> Gorengan Enak
            </a>
            <div class="navbar-nav ml-auto">
                <a href="<?= base_url('customer/dashboard') ?>" class="btn btn-outline-light mr-2">
                    <i class="fas fa-arrow-left"></i> Kembali ke Menu
                </a>
                <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-light">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h5>
                    </div>
                    <div class="card-body">
                        <?php if(empty($cart_items)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Keranjang belanja kosong</p>
                                <a href="<?= base_url('customer/dashboard') ?>" class="btn btn-warning">
                                    Belanja Sekarang
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th width="150">Jumlah</th>
                                            <th>Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($cart_items as $item): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($item->name) ?></td>
                                            <td>Rp <?= number_format($item->price) ?></td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQty(<?= $item->id ?>, 'decrease')">-</button>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm text-center" value="<?= $item->quantity ?>" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQty(<?= $item->id ?>, 'increase')">+</button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Rp <?= number_format($item->price * $item->quantity) ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-danger" onclick="removeItem(<?= $item->id ?>)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Ringkasan Belanja</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Item:</span>
                            <span><?= $total_items ?? 0 ?> item</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Harga:</span>
                            <span class="text-warning font-weight-bold">Rp <?= number_format($total_price ?? 0) ?></span>
                        </div>
                        <hr>
                        <form action="<?= base_url('customer/checkout') ?>" method="post">
                            <div class="form-group">
                                <label>Nama Penerima</label>
                                <input type="text" name="customer_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Alamat Pengiriman</label>
                                <textarea name="address" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>No. Telepon</label>
                                <input type="tel" name="phone" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-warning btn-block" <?= empty($cart_items) ? 'disabled' : '' ?>>
                                <i class="fas fa-shopping-bag"></i> Checkout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateQty(id, action) {
            // Implementasi update quantity via AJAX
        }
        
        function removeItem(id) {
            if(confirm('Yakin ingin menghapus item ini?')) {
                // Implementasi remove item via AJAX
            }
        }
    </script>
</body>
</html>