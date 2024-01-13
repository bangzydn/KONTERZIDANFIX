<?php
class User{
    // Connection
    private $conn;
    // Table
    private $db_table = "user";
    // Columns
    public $id;
    public $fullname;
    public $email;
    public $pw;
    public $rolee;
    public $created;
    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }
    // GET ALL
    public function getUsers(){
        $sqlQuery = "SELECT id, fullname, email, pw, rolee, created FROM ". $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    // CREATE
    public function createUser(){
        $sqlQuery = "INSERT INTO ". $this->db_table ."
        SET
        fullname = :fullname,
        email = :email,
        pw = :pw,
        rolee = :rolee,
        created = :created";
        $stmt = $this->conn->prepare($sqlQuery);
            // sanitize
            $this->fullname=htmlspecialchars(strip_tags($this->fullname));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->pw=htmlspecialchars(strip_tags($this->pw));
            $this->rolee=htmlspecialchars(strip_tags($this->rolee));
            $this->created=htmlspecialchars(strip_tags($this->created));
            // bind data
            $stmt->bindParam(":fullname", $this->fullname);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":pw", $this->pw);
            $stmt->bindParam(":rolee", $this->rolee);
            $stmt->bindParam(":created", $this->created);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
    // READ single
    public function getSingleUser(){
        $sqlQuery = "SELECT
        id,
        fullname,
        email,
        pw,
        rolee,
        created       
        FROM
        ". $this->db_table ."
        WHERE
        id = ?
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->fullname = $dataRow['fullname'];
        $this->email = $dataRow['email'];
        $this->pw = $dataRow['pw'];
        $this->rolee = $dataRow['rolee'];
        $this->created = $dataRow['created'];
    }
    // UPDATE
    public function updateUser(){
        $sqlQuery = "UPDATE
        ". $this->db_table ."
        SET
        fullname = :fullname,
        email = :email,
        pw = :pw,
        rolee = :rolee,
        created = :created
        WHERE
        id = :id";
        $stmt = $this->conn->prepare($sqlQuery);
        
        $this->fullname=htmlspecialchars(strip_tags($this->fullname));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->pw=htmlspecialchars(strip_tags($this->pw));
        $this->rolee=htmlspecialchars(strip_tags($this->rolee));
        $this->created=htmlspecialchars(strip_tags($this->created));
        $this->id=htmlspecialchars(strip_tags($this->id));
        // bind data
        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":pw", $this->pw);
        $stmt->bindParam(":rolee", $this->rolee);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":id", $this->id);
        $stmt->fetchAll();

        try {
            $stmt->execute();
        }
        catch(PDOException $exception) {
            die($exception->getMessage());
        }
        
        if (count($stmt->fetchAll()) == 0) {
            return true;
        }
    }
    // DELETE
    function deleteUser(){
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
    public function prosesLogin(){
        $sqlQuery = "SELECT
        fullname,
        email,
        pw,
        rolee,
        created
        FROM
        ". $this->db_table ."
        WHERE
        email = :email AND
        pw = :pw
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":pw", $this->pw);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!empty($dataRow)) {
            return $dataRow;
        }else{
            return false;
        }
    }
    public function prosesLogout(){
        session_start();
        session_unset();
        session_destroy();
        return true;
    }
}
?>