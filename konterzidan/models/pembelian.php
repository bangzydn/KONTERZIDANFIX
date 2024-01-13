<?php
class Pembelian{
    // Connection
    private $conn;
    // Table
    private $db_table = "pembelian";
    // Columns
    public $id;
    public $idtrx;
    public $tgl_pembelian;
    public $nama_supp;
    public $kasir;
    public $grand_total;
    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }
    // GET ALL
    public function getPembelians(){
        $sqlQuery = "SELECT id, idtrx ,tgl_pembelian, nama_supp, kasir, grand_total  FROM ". $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    // CREATE
    public function createPembelian(){
        $sqlQuery = "INSERT INTO ". $this->db_table ."
        SET
        idtrx = :idtrx,
        tgl_pembelian = :tgl_pembelian,
        nama_supp = :nama_supp,
        kasir = :kasir,
        grand_total = :grand_total";
        $stmt = $this->conn->prepare($sqlQuery);
        // sanitize
        $this->idtrx=htmlspecialchars(strip_tags($this->idtrx));
        $this->tgl_pembelian=htmlspecialchars(strip_tags($this->tgl_pembelian));
        $this->nama_supp=htmlspecialchars(strip_tags($this->nama_supp));
        $this->kasir=htmlspecialchars(strip_tags($this->kasir));
        $this->grand_total=htmlspecialchars(strip_tags($this->grand_total));
        // bind data
        $stmt->bindParam(":idtrx", $this->idtrx);
        $stmt->bindParam(":tgl_pembelian", $this->tgl_pembelian);
        $stmt->bindParam(":nama_supp", $this->nama_supp);
        $stmt->bindParam(":kasir", $this->kasir);
        $stmt->bindParam(":grand_total", $this->grand_total);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    // READ single
    public function getSinglePembelian(){
        $sqlQuery = "SELECT
        id,
        idtrx,
        tgl_pembelian,
        nama_supp,
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
        $this->tgl_pembelian = $dataRow['tgl_pembelian'];
        $this->nama_supp = $dataRow['nama_supp'];
        $this->kasir = $dataRow['kasir'];
        $this->grand_total = $dataRow['grand_total'];
    }
    function deletePembelian(){
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