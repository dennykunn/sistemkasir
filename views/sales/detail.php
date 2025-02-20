<?php
require_once 'config/Database.php';
require_once 'models/Sale.php';
require_once 'models/SaleDetail.php';

$db = new Database();
$conn = $db->getConnection();

$sale = new Sale($conn);
$s = $sale->getSaleById($_GET['id']);

$saleDetail = new SaleDetail($conn);
$saleDetails = $saleDetail->getDetailsBySaleId($_GET['id']);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td colspan="2">Nomor Faktur</td>
                            <td colspan="3"><?php echo $s['invoice_number'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Nama Pelanggan</td>
                            <td colspan="3"><?php echo $s['customer_name'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Total Penjualan</td>
                            <td colspan="3">Rp<?= number_format($s['total_amount'], 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Tanggal Penjualan</td>
                            <td colspan="3"><?= date("H:i - d M Y", strtotime($s['sale_date'])) ?></td>
                        </tr>
                        <tr class="align-middle">
                            <th style="width: 10px">No</th>
                            <th>Nama Produk</th>
                            <th>Kuantitas</th>
                            <th>Harga Per Unit</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($saleDetails as $no => $detail): ?>
                            <tr class="align-middle">
                                <td><?= $no + 1 ?></td>
                                <td><?= $detail['product_name'] ?></td>
                                <td><?= $detail['quantity'] ?></td>
                                <td>Rp<?= number_format($detail['price'], 0, ',', '.') ?></td>
                                <td>Rp<?= number_format($detail['subtotal'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>