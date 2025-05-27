<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk | Gorengan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('admin/dashboard') ?>">
                <i class="fas fa-utensils"></i> Gorengan Admin
            </a>
            <div class="navbar-nav ml-auto">
                <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-outline-light mr-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-light">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Produk</h5>
                    </div>
                    <div class="card-body">
                        <?php if($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= $this->session->flashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('admin/edit_product/'.$product->id) ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Nama Produk</label>
                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product->name) ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Harga</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" name="price" class="form-control" value="<?= $product->price ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Foto Produk</label>
                                <?php if($product->photo): ?>
                                    <div class="mb-2">
                                        <img src="<?= base_url('uploads/'.$product->photo) ?>" class="img-thumbnail" width="200">
                                    </div>
                                <?php endif; ?>
                                <div class="custom-file">
                                    <input type="file" name="photo" class="custom-file-input" id="photo" accept="image/*">
                                    <label class="custom-file-label" for="photo">Pilih file baru...</label>
                                </div>
                                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($product->description ?? '') ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Simpan Perubahan
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
        // Update file input label
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>
</body>
</html> 