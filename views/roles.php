<?php
require_once 'models/Role.php';
require_once 'config/Database.php';
require_once 'config/auth.php';

$db = new Database();
$conn = $db->getConnection();

$role = new Role($conn);
$roles = $role->getRoles();
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Role</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr class="align-middle">
                            <th style="width: 10px">No</th>
                            <th>Nama Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($roles as $no => $r): ?>
                            <tr class="align-middle">
                                <td><?= $no + 1 ?></td>
                                <td><?= $r['name'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</html>