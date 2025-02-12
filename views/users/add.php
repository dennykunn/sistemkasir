<?php
require_once 'config/Database.php';
require_once 'models/Role.php';
require_once 'config/auth.php';

$db = new Database();
$conn = $db->getConnection();

$role = new Role($conn);
$roles = $role->getRoles();
?>

<div class="row g-4">
    <div class="col-12">
        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <div class="card-title">Tambah Pengguna</div>
            </div>
            <form action="controllers/UserController.php" method="POST">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" placeholder="Username" class="form-control" name="username" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" placeholder="Password" class="form-control" name="password" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="role_id" class="form-label">Role</label>

                            <select name="role_id" id="role_id" required class="form-control">
                                <option disabled selected>-- Pilih Role --</option>
                                <?php foreach ($roles as $r) : ?>
                                    <option value="<?= $r['id'] ?>"><?= $r['name'] ?></option>
                                <?php endforeach; ?>
                            </select> <br>
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