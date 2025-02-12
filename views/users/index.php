<?php
require_once 'config/Database.php';
require_once 'models/User.php';
require_once 'config/auth.php';

$db = new Database();
$conn = $db->getConnection();
$user = new User($conn);
$users = $user->getUsers();
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Data Pengguna</h3>

                    <a class="btn btn-success" href="?page=create-user">Tambah Pengguna</a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr class="align-middle">
                            <th style="width: 10px">No</th>
                            <th>Nama Pengguna</th>
                            <th style="width: 40px">Role</th>
                            <th style="width: 100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $no => $u): ?>
                            <tr class="align-middle">
                                <td><?= $no + 1 ?></td>
                                <td><?= $u['username'] ?></td>
                                <td><?= $u['role'] ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a class="btn btn-info" href="?page=edit-user&id=<?= $u['id'] ?>">Edit</a>
                                        <a class="btn btn-danger" href="controllers/UserController.php?delete=<?= $u['id'] ?>" onclick="return confirm('Apakah anda yakin ingin menghapus pengguna ini?')">Hapus</a>
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