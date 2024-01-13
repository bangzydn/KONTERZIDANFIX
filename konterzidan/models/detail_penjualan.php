<?php
class DetailPenjualan{
    // Connection
    private $conn;
    // Table
    private $db_table = "detail_penjualan";
    private $dbm_table = "barang";
    // Columns
    public $id;
    public $idtrx;
    public $kd_barang;
    public $nm_barang;
    public $hrg_barang;
    public $qty;
    public $total_harga;
    
    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }
    // GET ALL
    public function getDetailPenjualans(){
        $sqlQuery = "SELECT id, idtrx ,kd_barang, nm_barang, hrg_barang, qty, total_harga  FROM ". $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    // CREATE
    public function createDetailPenjualan(){
        if($this->checkStok()){
            $sqlQuery = "INSERT INTO ". $this->db_table ."
            SET
            idtrx = :idtrx,
            kd_barang = :kd_barang,
            nm_barang = :nm_barang,
            hrg_barang = :hrg_barang,
            qty = :qty,
            total_harga = :total_harga";
            $stmt = $this->conn->prepare($sqlQuery);
            // sanitize
            $this->idtrx=htmlspecialchars(strip_tags($this->idtrx));
            $this->kd_barang=htmlspecialchars(strip_tags($this->kd_barang));
            $this->nm_barang=htmlspecialchars(strip_tags($this->nm_barang));
            $this->hrg_barang=htmlspecialchars(strip_tags($this->hrg_barang));
            $this->qty=htmlspecialchars(strip_tags($this->qty));
            $this->total_harga=htmlspecialchars(strip_tags($this->total_harga));
            // bind data
            $stmt->bindParam(":idtrx", $this->idtrx);
            $stmt->bindParam(":kd_barang", $this->kd_barang);
            $stmt->bindParam(":nm_barang", $this->nm_barang);
            $stmt->bindParam(":hrg_barang", $this->hrg_barang);
            $stmt->bindParam(":qty", $this->qty);
            $stmt->bindParam(":total_harga", $this->total_harga);
            if($stmt->execute()){
                return true;
            }
            return false;
        }else{
            return false;
        }       
    }
    // READ single
    public function getSingleDetailPenjualan(){
        $sqlQuery = "SELECT
        id,
        idtrx,
        kd_barang,
        nm_barang,
        hrg_barang,
        qty,
        total_harga
        FROM
        ". $this->db_table ."
        WHERE
        id = ?
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->idtrx = $dataRow['idtrx'];
        $this->kd_barang = $dataRow['kd_barang'];
        $this->nm_barang = $dataRow['nm_barang'];
        $this->hrg_barang = $dataRow['hrg_barang'];
        $this->qty = $dataRow['qty'];
        $this->total_harga = $dataRow['total_harga'];
    }

    public function checkStok(){
        $sqlQuery = "SELECT
        id,
        kd_barang,
        stok
        FROM
        ". $this->dbm_table ."
        WHERE
        kd_barang = ?
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->kd_barang);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->kd_barang = $dataRow['kd_barang'];
        $stok = $dataRow['stok'];
        $saldo = $stok - $this->qty;
        if($saldo < 0){
            return false;
        }else{
            $this ->updateStok($saldo);
            return true;
        }
    }

    public function updateStok($saldo){
        $sqlQuery = "UPDATE
        ". $this->dbm_table ."
        SET
        stok = :stok 
        WHERE
        kd_barang = :kd_barang";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(":kd_barang", $this->kd_barang);
        $stmt->bindParam(":stok", $saldo);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function setDecrease(){
        $sqlQuery = "SELECT
        id,
        kd_barang,
        idtrx,
        nm_barang,
        hrg_barang,
        qty,
        total_harga
        FROM
        ". $this->db_table ."
        WHERE
        idtrx = ?
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $dataRow;
    }

        
    function deleteDetails(){
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE idtrx = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->idtrx=htmlspecialchars(strip_tags($this->idtrx));
        $stmt->bindParam(1, $this->idtrx);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
}