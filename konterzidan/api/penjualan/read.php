<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-AllowHeaders, Authorization, X-Requested-With");
include_once '../../config/database.php';
include_once '../../models/penjualan.php';

$database = new Database();
$db = $database->getConnection();
if(isset($_GET['id'])){
    $item = new Penjualan($db);
    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
    $item->getSinglePenjualan();
    if($item->idtrx != null){
        // create array
        $emp_arr = array(
        "id" => $item->id,
        "idtrx" => $item->idtrx,
        "tgl_penjualan" => $item->tgl_penjualan,
        "nama_cust" => $item->nama_cust,
        "kasir" => $item->kasir,
        "grand_total" => $item->grand_total
        );
        http_response_code(200);
        echo json_encode($emp_arr);
    }
    else{
        http_response_code(404);
        echo json_encode("Transaksi not found.");
    }
}
else {
    $items = new Penjualan($db);
    $stmt = $items->getPenjualans();
    $itemCount = $stmt->rowCount();
    if($itemCount > 0){
        $PenjualanArr = array();
        $PenjualanArr["body"] = array();
        $PenjualanArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "idtrx" => $idtrx,
                "tgl_penjualan" => $tgl_penjualan,
                "nama_cust" => $nama_cust,
                "kasir" => $kasir,
                "grand_total" => $grand_total
            );
            array_push($PenjualanArr["body"], $e);
        }
        echo json_encode($PenjualanArr);
    }
    else{
        http_response_code(404);
        echo json_encode(array("messstock" => "No record found."));
    }
}
?>