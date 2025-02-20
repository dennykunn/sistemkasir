<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../models/SaleDetail.php";

class SaleDetailController
{
    private $saleDetail;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->saleDetail = new SaleDetail($db);
    }

    public function getSaleDetails($sale_id)
    {
        return $this->saleDetail->getDetailsBySaleId($sale_id);
    }
}
