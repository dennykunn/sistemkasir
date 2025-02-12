<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="./index.html" class="brand-link">
            <img
                src="template/dist/assets/img/AdminLTELogo.png"
                alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">AdminLTE 4</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul
                class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="?page=dashboard" class="nav-link">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?page=products" class="nav-link">
                        <i class="nav-icon bi bi-box"></i>
                        <p>Data Barang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?page=users" class="nav-link">
                        <i class="nav-icon bi bi-person-circle"></i>
                        <p>Data Pengguna</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?page=roles" class="nav-link">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Data Role</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0"><?php echo $title; ?></h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <?php
                        $lastKey = array_key_last($breadcrumb);
                        foreach ($breadcrumb as $name => $link) {
                            if ($link) {
                                echo "<li class='breadcrumb-item'><a href='$link'>$name</a></li>";
                            } else {
                                echo "<li class='breadcrumb-item active' aria-current='page'>$name</li>";
                            }
                        }
                        ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">

            <?php if (isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $_SESSION['success'] ?>
                </div>
            <?php
            }
            unset($_SESSION['success']);
            ?>