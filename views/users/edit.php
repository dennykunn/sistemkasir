<?php
require_once 'config/Database.php';
require_once 'models/Role.php';
require_once 'models/User.php';
require_once 'config/auth.php';

$db = new Database();
$conn = $db->getConnection();

$user = new User($conn);
$u = $user->getUserById($_GET['id']);

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
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" placeholder="Username" class="form-control" name="username" required value="<?= $u['username'] ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="role_id" class="form-label">Role</label>

                            <select name="role_id" id="role_id" required class="form-control">
                                <option disabled selected>-- Pilih Role --</option>
                                <?php foreach ($roles as $r) : ?>
                                    <option value="<?= $r['id'] ?>" <?= $u['role_id'] == $r['id'] ? 'selected' : '' ?>><?= $r['name'] ?></option>
                                <?php endforeach; ?>
                            </select> <br>
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