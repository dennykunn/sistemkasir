<?php
require_once 'config/Database.php';
require_once 'models/Sale.php';

$db = new Database();
$conn = $db->getConnection();

$sale = new Sale($conn);
$sales = $sale->getAllSales();
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Data Penjualan</h3>
                    <a class="btn btn-success" href="?page=create-sale">Tambah Penjualan</a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr class="align-middle">
                            <th style="width: 10px">No</th>
                            <th>Nomor Faktur</th>
                            <th>Nama Pelanggan</th>
                            <th>Total Harga</th>
                            <th>Tanggal</th>
                            <th style="width: 100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sales as $no => $sale): ?>
                            <tr class="align-middle">
                                <td><?= $no + 1 ?></td>
                                <td><?= $sale['invoice_number'] ?></td>
                                <td><?= $sale['customer_name'] ?></td>
                                <td>Rp<?= number_format($sale['total_amount'], 0, ',', '.') ?></td>
                                <td><?= date("H:i - d M Y", strtotime($sale['sale_date'])) ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a class="btn btn-warning" href="?page=detail-sale&id=<?= $sale['id'] ?>">Detail</a>
                                        <a class="btn btn-info" href="?page=edit-sale&id=<?= $sale['id'] ?>">Edit</a>
                                        <a class="btn btn-danger" href="controllers/SaleController.php?delete=<?= $sale['id'] ?>" onclick="return confirm('Apakah anda yakin ingin menghapus penjualan ini?')">Hapus</a>
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