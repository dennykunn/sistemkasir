<?php
require_once 'config/Database.php';
require_once 'models/Product.php';

$db = new Database();
$conn = $db->getConnection();
$product = new Product($conn);
$products = $product->getProducts();
$user = $_SESSION['user'];
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Data Produk</h3>

                    <a class="btn btn-success" href="?page=create-product">Tambah Produk</a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr class="align-middle">
                            <th style="width: 10px">No</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th style="width: 40px">Stock</th>
                            <th style="width: 100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $no => $p): ?>
                            <tr class="align-middle">
                                <td><?= $no + 1 ?></td>
                                <td><?= $p['name'] ?></td>
                                <td><?= $p['price'] ?></td>
                                <td><?= $p['stock'] ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a class="btn btn-info" href="?page=edit-product&id=<?= $p['id'] ?>">Edit</a>
                                        <a class="btn btn-danger" href="controllers/ProductController.php?delete=<?= $p['id'] ?>" onclick="return confirm('Apakah anda yakin ingin menghapus produk ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>