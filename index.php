<?php
session_start();
require_once 'config/auth.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

switch ($page) {
    case 'users':
        $title = "Users";
        $breadcrumb = ["Home" => "index.php", "Users" => ""];
        $content = 'views/users/index.php';
        break;

    case 'create-user':
        $title = "Tambah Pengguna";
        $breadcrumb = ["Home" => "index.php", "users" => "?page=create-user", "Create" => ""];
        $content = 'views/users/add.php';
        break;

    case 'edit-user':
        $title = "Edit Pengguna";
        $breadcrumb = ["Home" => "index.php", "users" => "?page=edit-user", "Edit" => ""];
        $content = 'views/users/edit.php';
        break;

    case 'products':
        $title = "Produk";
        $breadcrumb = ["Home" => "index.php", "Products" => ""];
        $content = 'views/products/index.php';
        break;

    case 'create-product':
        $title = "Tambah Produk";
        $breadcrumb = ["Home" => "index.php", "Products" => "?page=products", "Create" => ""];
        $content = 'views/products/add.php';
        break;

    case 'edit-product':
        $title = "Edit Produk";
        $breadcrumb = ["Home" => "index.php", "Products" => "?page=products", "Edit" => ""];
        $content = 'views/products/edit.php';
        break;

    case 'sales':
        $title = "Penjualan";
        $breadcrumb = ["Home" => "index.php", "Penjualan" => ""];
        $content = 'views/sales/index.php';
        break;

    case 'create-sale':
        $title = "Tambah Penjualan";
        $breadcrumb = ["Home" => "index.php", "Penjualan" => "?page=create-sake", "Create" => ""];
        $content = 'views/sales/add.php';
        break;

    case 'edit-sale':
        $title = "Edit Penjualan";
        $breadcrumb = ["Home" => "index.php", "Penjualan" => "?page=edit-sale", "Edit" => ""];
        $content = 'views/sales/edit.php';
        break;

    case 'detail-sale':
        $title = "Detail Penjualan";
        $breadcrumb = ["Home" => "index.php", "Penjualan" => "?page=detail-sale", "Detail" => ""];
        $content = 'views/sales/detail.php';
        break;

    case 'roles':
        $title = "Role";
        $breadcrumb = ["Home" => "index.php", "Roles" => ""];
        $content = 'views/roles.php';
        break;

    case 'dashboard':
    default:
        $title = "Dashboard";
        $breadcrumb = ["Home" => ""];
        $content = 'views/dashboard.php';
        break;
}

require_once 'layouts/header.php';
require_once 'layouts/sidebar.php';
require_once $content;
require_once 'layouts/footer.php';
