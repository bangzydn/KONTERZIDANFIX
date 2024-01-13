<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include_once '../../config/database.php';
    include_once '../../models/pembelian.php';
    include_once '../../models/detail_pembelian.php';
    $database = new Database();
    $db = $database->getConnection();
    $item = new Pembelian($db);
    $data = json_decode(file_get_contents("php://input"));
    $item->idtrx = $data->idtrx;
    $item->tgl_pembelian = date('Y-m-d');
    $item->nama_supp = $data->nama_supp;
    $item->kasir = $data->kasir;
    $item->grand_total = $data->grand_total;
    $db->beginTransaction();
    if($item->createPembelian()){
        $details = new DetailPembelian($db);
        foreach($data->details as $barang){      
            $details->kd_barang = $barang->kd_barang;
            $details->idtrx = $data->idtrx;
            $details->nm_barang = $barang->nm_barang;
            $details->hrg_barang = $barang->hrg_barang;
            $details->qty = $barang->qty;
            $details->total_harga = $barang->total_harga;
            if(!$details->createDetailPembelian()){
                $db->rollBack();
                echo json_encode('Produk '.$barang->nm_barang.' saldo tidak mencukupi.');
                return false;
            }
        }
        $db->commit();
        echo json_encode('Trasnsaksi created successfully.');
    } else{
        $db->rollBack();
        echo json_encode ('Transaksi could not be created.');
    }
?>