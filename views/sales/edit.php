<?php
require_once 'config/Database.php';
require_once 'models/Product.php';
require_once 'models/Sale.php';
require_once 'models/SaleDetail.php';

$db = new Database();
$conn = $db->getConnection();

$sale = new Sale($conn);
$saleDetail = new SaleDetail($conn);
$product = new Product($conn);
$products = $product->getProducts();

$sale_id = $_GET['id'];
$sale_data = $sale->getSaleById($sale_id);
$sale_details = $saleDetail->getDetailsBySaleId($sale_id);
?>

<div class="row g-4">
    <div class="col-12">
        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <div class="card-title">Edit Penjualan</div>
            </div>
            <form action="controllers/SaleController.php" method="POST">
                <input type="hidden" name="sale_id" value="<?= $sale_id ?>">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Nama Pelanggan</label>
                        <input type="text" id="customer_name" class="form-control" name="customer_name" value="<?= $sale_data['customer_name'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Barang</label>
                        <div id="product-list">
                            <?php foreach ($sale_details as $index => $detail) : ?>
                                <div class="row mb-2 product-item">
                                    <input type="hidden" name="sale_id" value="<?= $_GET['id'] ?>">
                                    <div class="col-md-4">
                                        <select class="form-control product" name="products[<?= $index ?>][product_id]" required>
                                            <option value="">Pilih Produk</option>
                                            <?php foreach ($products as $product) : ?>
                                                <option value="<?= $product['id'] ?>"
                                                    data-price="<?= $product['price'] ?>"
                                                    data-stock="<?= $product['stock'] ?>"
                                                    <?= $product['id'] == $detail['product_id'] ? 'selected' : '' ?>
                                                    <?= $product['stock'] == 0 ? 'disabled' : '' ?>>
                                                    <?= $product['name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <?php
                                        // Cari stok berdasarkan product_id jika tidak tersedia di $sale_details
                                        $product_stock = '-';
                                        foreach ($products as $p) {
                                            if ($p['id'] == $detail['product_id']) {
                                                $product_stock = $p['stock'];
                                                break;
                                            }
                                        }
                                        ?>
                                        <small class="text-muted">Harga: <span class="price-label"><?= number_format($detail['price'], 0, ',', '.') ?></span> | Stok: <span class="stock-label"><?= $product_stock ?></span></small>
                                        <input type="hidden" class="hidden_price" name="products[<?= $index ?>][price]" value="<?= $detail['price'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control quantity" name="products[<?= $index ?>][quantity]" required min="1" value="<?= $detail['quantity'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control subtotal" name="products[<?= $index ?>][subtotal]" required readonly value="<?= $detail['subtotal'] ?>">
                                    </div>
                                    <?php if ($index > 0) : ?>
                                        <div class="col-md-2 d-flex align-items-center">
                                            <button type="button" class="btn btn-danger remove-product">❌</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" id="add-product" class="btn btn-success mt-1" style="width: 100%;">Tambah Produk</button>
                    </div>

                    <div class="mb-3">
                        <label for="total_amount" class="form-label">Total Harga Keseluruhan</label>
                        <input type="text" id="total_amount" class="form-control" name="total_amount" value="<?= $sale_data['total_amount'] ?>" required readonly>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" name="update">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function updateSubtotal(row) {
            var product = row.querySelector(".product option:checked");
            var price = parseFloat(product.getAttribute("data-price")) || 0;
            var stock = product.getAttribute("data-stock") || "-";
            var quantity = parseInt(row.querySelector(".quantity").value) || 0;
            var subtotal = price * quantity;

            row.querySelector(".subtotal").value = subtotal;
            row.querySelector(".price-label").textContent = new Intl.NumberFormat("id-ID").format(price);
            row.querySelector(".stock-label").textContent = stock;
            row.querySelector(".hidden_price").value = price; // Menyimpan harga dalam input hidden

            updateTotal();
        }

        function updateTotal() {
            var totalAmount = 0;
            document.querySelectorAll(".subtotal").forEach(function(input) {
                totalAmount += parseFloat(input.value) || 0;
            });
            document.getElementById("total_amount").value = totalAmount;
        }

        document.querySelectorAll(".product").forEach(select => {
            select.addEventListener("change", function() {
                updateSubtotal(this.closest(".product-item"));
            });
        });

        document.querySelectorAll(".quantity").forEach(input => {
            input.addEventListener("input", function() {
                updateSubtotal(this.closest(".product-item"));
            });
        });

        document.getElementById("add-product").addEventListener("click", function() {
            var count = document.querySelectorAll("#product-list .product-item").length;
            var productList = document.getElementById("product-list");

            var newRow = document.createElement("div");
            newRow.className = "row mb-2 product-item";
            newRow.innerHTML = `
                <div class="col-md-4">
                    <select class="form-control product" name="products[\${count}][product_id]" required>
                        <option value="">Pilih Produk</option>
                        <?php foreach ($products as $product) : ?>
                            <option value="<?= $product['id'] ?>" data-price="<?= $product['price'] ?>" data-stock="<?= $product['stock'] ?>">
                                <?= $product['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">Harga: Rp <span class="price-label">0</span> | Stok: <span class="stock-label">-</span></small> 
                    <input type="hidden" class="hidden_price" name="products[\${count}][price]"> 
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control quantity" name="products[\${count}][quantity]" required min="1" value="1">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control subtotal" name="products[\${count}][subtotal]" required readonly>
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <button type="button" class="btn btn-danger remove-product">❌</button>
                </div>
            `;
            productList.appendChild(newRow);

            // Tambahkan event listener untuk produk dan quantity yang baru
            newRow.querySelector(".product").addEventListener("change", function() {
                updateSubtotal(newRow);
            });

            newRow.querySelector(".quantity").addEventListener("input", function() {
                updateSubtotal(newRow);
            });

            newRow.querySelector(".remove-product").addEventListener("click", function() {
                newRow.remove();
                updateTotal();
            });
        });

        document.querySelectorAll(".remove-product").forEach(button => {
            button.addEventListener("click", function() {
                this.closest(".product-item").remove();
                updateTotal();
            });
        });
    });
</script>