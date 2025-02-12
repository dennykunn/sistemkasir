<?php
require_once 'config/Database.php';
require_once 'models/Product.php';
require_once 'config/auth.php';

$db = new Database();
$conn = $db->getConnection();

$product = new Product($conn);
$p = $product->getProductById($_GET['id']);
?>
<div class="row g-4">
    <div class="col-12">
        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <div class="card-title">Edit Barang</div>
            </div>
            <form action="controllers/ProductController.php" method="POST">
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                        <div class="col-md-4 mb-3">
                            <label for="nama" class="form-label">Nama Barang</label>
                            <input type="text" id="nama" placeholder="Nama barang" class="form-control" name="name" required value="<?= $p['name'] ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">Harga barang</label>
                            <input type="text" id="price" placeholder="Harga barang" class="form-control" name="price" required value="<?= $p['price'] ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="stock" class="form-label">Stok barang</label>
                            <input type="text" id="stock" placeholder="Stok barang" class="form-control" name="stock" required value="<?= $p['stock'] ?>">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" name="update">Perbarui</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>