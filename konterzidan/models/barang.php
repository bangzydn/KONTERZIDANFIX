<?php
class Barang{
    // Connection
    private $conn;
    // Table
    private $db_table = "barang";
    // Columns
    public $id;
    public $kd_barang;
    public $nm_barang;
    public $hrg_barang;
    public $stok;
    public $jns_barang;
    public $hrg_beli;
    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }
    // GET ALL
    public function getBarangs(){
        $sqlQuery = "SELECT id, kd_barang, nm_barang, hrg_barang, stok, jns_barang, hrg_beli FROM ". $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    // CREATE
    public function createBarang(){
        $sqlQuery = "INSERT INTO ". $this->db_table ."
        SET
        kd_barang = :kd_barang,
        nm_barang = :nm_barang,
        hrg_barang = :hrg_barang,
        stok = :stok,
        jns_barang = :jns_barang,
        hrg_beli = :hrg_beli";
        $stmt = $this->conn->prepare($sqlQuery);
        // sanitize
        $this->kd_barang=htmlspecialchars(strip_tags($this->kd_barang));
        $this->nm_barang=htmlspecialchars(strip_tags($this->nm_barang));
        $this->hrg_barang=htmlspecialchars(strip_tags($this->hrg_barang));
        $this->stok=htmlspecialchars(strip_tags($this->stok));
        $this->jns_barang=htmlspecialchars(strip_tags($this->jns_barang));
        $this->hrg_beli=htmlspecialchars(strip_tags($this->hrg_beli));
        // bind data
        $stmt->bindParam(":kd_barang", $this->kd_barang);
        $stmt->bindParam(":nm_barang", $this->nm_barang);
        $stmt->bindParam(":hrg_barang", $this->hrg_barang);
        $stmt->bindParam(":stok", $this->stok);
        $stmt->bindParam(":jns_barang", $this->jns_barang);
        $stmt->bindParam(":hrg_beli", $this->hrg_beli);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    // READ single
    public function getSingleBarang(){
        $sqlQuery = "SELECT
        id,
        kd_barang,
        nm_barang,
        hrg_barang,
        stok,
        jns_barang,
        hrg_beli
        FROM
        ". $this->db_table ."
        WHERE
        id = ?
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->kd_barang = $dataRow['kd_barang'];
        $this->nm_barang = $dataRow['nm_barang'];
        $this->hrg_barang = $dataRow['hrg_barang'];
        $this->stok = $dataRow['stok'];
        $this->jns_barang = $dataRow['jns_barang'];
        $this->hrg_beli = $dataRow['hrg_beli'];
    }
    // UPDATE
    public function updateBarang(){
        $sqlQuery = "UPDATE
        ". $this->db_table ."
        SET
        kd_barang = :kd_barang,
        nm_barang = :nm_barang,
        hrg_barang = :hrg_barang,
        stok = :stok,
        jns_barang = :jns_barang,
        hrg_beli = :hrg_beli
        WHERE
        id = :id";
        $stmt = $this->conn->prepare($sqlQuery);
        
        $this->kd_barang=htmlspecialchars(strip_tags($this->kd_barang));
        $this->nm_barang=htmlspecialchars(strip_tags($this->nm_barang));
        $this->hrg_barang=htmlspecialchars(strip_tags($this->hrg_barang));
        $this->stok=htmlspecialchars(strip_tags($this->stok));
        $this->jns_barang=htmlspecialchars(strip_tags($this->jns_barang));
        $this->hrg_beli=htmlspecialchars(strip_tags($this->hrg_beli));
        $this->id=htmlspecialchars(strip_tags($this->id));
        // bind data
        $stmt->bindParam(":kd_barang", $this->kd_barang);
        $stmt->bindParam(":nm_barang", $this->nm_barang);
        $stmt->bindParam(":hrg_barang", $this->hrg_barang);
        $stmt->bindParam(":stok", $this->stok);
        $stmt->bindParam(":jns_barang", $this->jns_barang);
        $stmt->bindParam(":hrg_beli", $this->hrg_beli);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
    // DELETE
    function deleteBarang(){
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
?>