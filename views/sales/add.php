<?php
require_once 'config/Database.php';
require_once 'models/Product.php';

$db = new Database();
$conn = $db->getConnection();

$product = new Product($conn);
$products = $product->getProducts();
?>

<div class="row g-4">
    <div class="col-12">
        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <div class="card-title">Tambah Penjualan</div>
            </div>
            <form action="controllers/SaleController.php" method="POST">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Nama Pelanggan</label>
                        <input type="text" id="customer_name" placeholder="Nama pelanggan" class="form-control" name="customer_name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Barang</label>
                        <div id="product-list">
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <select class="form-control product" name="products[0][product_id]" required>
                                        <option value="">Pilih Produk</option>
                                        <?php foreach ($products as $product) : ?>
                                            <option value="<?= $product['id'] ?>"
                                                data-price="<?= $product['price'] ?>"
                                                data-stock="<?= $product['stock'] ?>"
                                                <?= $product['stock'] == 0 ? 'disabled' : '' ?>>
                                                <?= $product['stock'] == 0 ? $product['name'] . ' (Stok Habis)' : $product['name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-muted price-label">Harga: - | Stok: -</small>
                                    <input type="hidden" class="hidden_price" name="products[0][price]">
                                </div>
                                <div class="col-md-4">
                                    <input type="number" placeholder="Jumlah" class="form-control quantity" name="products[0][quantity]" required min="1" value="1">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Subtotal" class="form-control subtotal" name="products[0][subtotal]" required readonly>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-product" style="width: 100%;" class="btn btn-success mt-1">Tambah Produk</button>
                    </div>

                    <div class="mb-3">
                        <label for="total_amount" class="form-label">Total Harga Keseluruhan</label>
                        <input type="text" id="total_amount" placeholder="Total harga" class="form-control" name="total_amount" required readonly>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" name="store">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function updatePrice(event) {
            var row = event.target.closest('.row');
            var subtotalInput = row.querySelector('.subtotal');
            var quantityInput = row.querySelector('.quantity');
            var selectedProduct = row.querySelector('.product').selectedOptions[0];
            var priceLabel = row.querySelector('.price-label');
            var hiddenPriceInput = row.querySelector('.hidden_price');

            var pricePerItem = selectedProduct ? parseFloat(selectedProduct.getAttribute("data-price")) || 0 : 0;
            var stockAvailable = selectedProduct ? parseInt(selectedProduct.getAttribute("data-stock")) || 0 : 0;
            var quantity = quantityInput.value ? parseInt(quantityInput.value) : 1;

            priceLabel.textContent = "Harga: Rp" + pricePerItem.toLocaleString("id-ID") + " | Stok: " + stockAvailable;
            hiddenPriceInput.value = pricePerItem;

            quantityInput.max = stockAvailable;
            if (quantity > stockAvailable) {
                quantityInput.value = stockAvailable;
                quantity = stockAvailable;
            }

            subtotalInput.value = pricePerItem * quantity;
            updateTotal();
        }

        function updateTotal() {
            var totalAmountInput = document.getElementById("total_amount");
            var total = 0;

            document.querySelectorAll(".subtotal").forEach(function(subtotalInput) {
                total += parseFloat(subtotalInput.value) || 0;
            });

            totalAmountInput.value = total;
        }

        function addRemoveEventListeners() {
            document.querySelectorAll(".remove-product").forEach(button => {
                button.addEventListener("click", function() {
                    this.closest(".row").remove();
                    updateTotal();
                });
            });
        }

        document.querySelectorAll(".product").forEach(el => el.addEventListener("change", updatePrice));
        document.querySelectorAll(".quantity").forEach(el => el.addEventListener("input", updatePrice));

        document.querySelectorAll(".product").forEach(el => {
            updatePrice({
                target: el
            });
        });

        document.getElementById("add-product").addEventListener("click", function() {
            var productList = document.getElementById("product-list");
            var count = productList.getElementsByClassName("row").length;

            var newRow = document.createElement("div");
            newRow.className = "row mb-2";
            newRow.innerHTML = `
                <div class="col-md-4">
                    <select class="form-control product" name="products[${count}][product_id]" required>
                        <option value="">Pilih Produk</option>
                        <?php foreach ($products as $product) : ?>
                            <option value="<?= $product['id'] ?>" 
                                    data-price="<?= $product['price'] ?>" 
                                    data-stock="<?= $product['stock'] ?>"
                                    <?= $product['stock'] == 0 ? 'disabled' : '' ?>>
                                <?= $product['stock'] == 0 ? $product['name'] . ' (Stok Habis)' : $product['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted price-label">Harga: - | Stok: -</small>
                    <input type="hidden" class="hidden_price" name="products[${count}][price]"> 
                </div>
                <div class="col-md-3">
                    <input type="number" placeholder="Jumlah" class="form-control quantity" name="products[${count}][quantity]" required min="1" value="1">
                </div>
                <div class="col-md-3">
                    <input type="text" placeholder="Subtotal" class="form-control subtotal" name="products[${count}][subtotal]" required readonly>
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <button type="button" class="btn btn-danger remove-product">❌</button>
                </div>
            `;

            productList.appendChild(newRow);
            newRow.querySelector(".product").addEventListener("change", updatePrice);
            newRow.querySelector(".quantity").addEventListener("input", updatePrice);
            addRemoveEventListeners();
        });

        addRemoveEventListeners();
    });
</script>