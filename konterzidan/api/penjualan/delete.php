<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-AllowHeaders, Authorization, X-Requested-With");
include_once '../../config/database.php';
include_once '../../models/penjualan.php';
include_once '../../models/detail_penjualan.php';
$database = new Database();
$db = $database->getConnection();

$item = new Penjualan($db);  
$data = json_decode(file_get_contents("php://input"));

$item->idtrx = $data->idtrx;
$db->beginTransaction();

if($item->deletePenjualan()){
    $details = new DetailPenjualan($db);
    if(!$details->deleteDetails()){
        $db->rollBack();
        echo json_encode('Details Data could not be deleted.');
        return false;
    }
    $db->commit();
    echo json_encode("Sell deleted.");
} else{
    echo json_encode("Data could not be deleted");
}
?>