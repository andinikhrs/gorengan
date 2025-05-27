<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Gorengan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning">
        <div class="container">
            <a class="navbar-brand" href="#">Gorengan Admin</a>
            <div class="navbar-nav ml-auto">
                <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-light">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h4><i class="fas fa-chart-line"></i> Dashboard Overview</h4>
                        <p class="mb-0">Selamat datang di panel admin Gorengan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-box-open fa-3x text-warning mb-3"></i>
                        <h5>Kelola Produk</h5>
                        <p class="text-muted">Tambah, edit, atau hapus produk</p>
                        <a href="<?= base_url('admin/products') ?>" class="btn btn-warning">
                            <i class="fas fa-arrow-right"></i> Lihat Produk
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-plus-circle fa-3x text-warning mb-3"></i>
                        <h5>Tambah Produk Baru</h5>
                        <p class="text-muted">Tambahkan produk baru ke katalog</p>
                        <a href="<?= base_url('admin/add_product') ?>" class="btn btn-warning">
                            <i class="fas fa-plus"></i> Tambah Produk
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-shopping-cart fa-3x text-warning mb-3"></i>
                        <h5>Pesanan</h5>
                        <p class="text-muted">Lihat dan kelola pesanan</p>
                        <a href="<?= base_url('admin/orders') ?>" class="btn btn-warning">
                            <i class="fas fa-list"></i> Lihat Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Products -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Produk Terbaru</h5>
                            <a href="<?= base_url('admin/products') ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-eye"></i> Lihat Semua
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Gorengan</th>
                                        <th>Harga</th>
                                        <th>Foto</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($products as $p): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($p->name) ?></td>
                                        <td>Rp <?= number_format($p->price) ?></td>
                                        <td>
                                            <?php if($p->photo): ?>
                                                <img src="<?= base_url('uploads/' . $p->photo) ?>" width="50" class="img-thumbnail">
                                            <?php else: ?>
                                                <span class="text-muted">No image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/edit_product/'.$p->id) ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('admin/delete_product/'.$p->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>