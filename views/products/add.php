<div class="row g-4">
    <div class="col-12">
        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <div class="card-title">Tambah Barang</div>
            </div>
            <form action="controllers/ProductController.php" method="POST">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="nama" class="form-label">Nama Barang</label>
                            <input type="text" id="nama" placeholder="Nama barang" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">Harga barang</label>
                            <input type="text" id="price" placeholder="Harga barang" class="form-control" name="price" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="stock" class="form-label">Stok barang</label>
                            <input type="text" id="stock" placeholder="Stok barang" class="form-control" name="stock" required>
                        </div>
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