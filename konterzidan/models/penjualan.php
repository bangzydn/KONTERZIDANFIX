<?php
class Penjualan{
    // Connection
    private $conn;
    // Table
    private $db_table = "penjualan";
    // Columns
    public $id;
    public $idtrx;
    public $tgl_penjualan;
    public $nama_cust;
    public $kasir;
    public $grand_total;
    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }
    // GET ALL
    public function getPenjualans(){
        $sqlQuery = "SELECT id, idtrx ,tgl_penjualan, nama_cust, kasir, grand_total  FROM ". $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    // CREATE
    public function createPenjualan(){
        $sqlQuery = "INSERT INTO ". $this->db_table ."
        SET
        idtrx = :idtrx,
        tgl_penjualan = :tgl_penjualan,
        nama_cust = :nama_cust,
        kasir = :kasir,
        grand_total = :grand_total";
        $stmt = $this->conn->prepare($sqlQuery);
        // sanitize
        $this->idtrx=htmlspecialchars(strip_tags($this->idtrx));
        $this->tgl_penjualan=htmlspecialchars(strip_tags($this->tgl_penjualan));
        $this->nama_cust=htmlspecialchars(strip_tags($this->nama_cust));
        $this->kasir=htmlspecialchars(strip_tags($this->kasir));
        $this->grand_total=htmlspecialchars(strip_tags($this->grand_total));
        // bind data
        $stmt->bindParam(":idtrx", $this->idtrx);
        $stmt->bindParam(":tgl_penjualan", $this->tgl_penjualan);
        $stmt->bindParam(":nama_cust", $this->nama_cust);
        $stmt->bindParam(":kasir", $this->kasir);
        $stmt->bindParam(":grand_total", $this->grand_total);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    // READ single
    public function getSinglePenjualan(){
        $sqlQuery = "SELECT
        id,
        idtrx,
        tgl_penjualan,
        nama_cust,
        kasir,
        grand_total
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
        $this->tgl_penjualan = $dataRow['tgl_penjualan'];
        $this->nama_cust = $dataRow['nama_cust'];
        $this->kasir = $dataRow['kasir'];
        $this->grand_total = $dataRow['grand_total'];
    }
    function deletePenjualan(){
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