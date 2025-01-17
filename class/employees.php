<?php
class Employee
{

    // Connection
    private $conn;

    // Table
    private $db_table = "cupones";

    // Columns
    public $id;
    public $Nombre;
    public $Email;
    public $Telefono;
    public $Curso;
    public $Fecha;

    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function getEmployees()
    {
        $sqlQuery = "SELECT id, Nombre, Email, Telefono, Curso, Apellidos, Fecha FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createEmployee()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET
                    Nombre = :Nombre, 
                    Email = :Email, 
                        Telefono = :Telefono, 
                        Curso = :Curso, 
                        Fecha = :Fecha";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $this->Telefono = htmlspecialchars(strip_tags($this->Telefono));
        $this->Curso = htmlspecialchars(strip_tags($this->Curso));
        $this->Fecha = htmlspecialchars(strip_tags($this->Fecha));

        // bind data
        $stmt->bindParam(":Nombre", $this->Nombre);
        $stmt->bindParam(":Email", $this->Email);
        $stmt->bindParam(":Telefono", $this->Telefono);
        $stmt->bindParam(":Curso", $this->Curso);
        $stmt->bindParam(":Fecha", $this->Fecha);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // UPDATE
    public function getSingleEmployee()
    {
        $sqlQuery = "SELECT
                        id, 
                        Nombre, 
                        Email, 
                        Telefono, 
                        Curso, 
                        Fecha
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       id = ?
                    LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->Nombre = $dataRow['Nombre'];
        $this->Email = $dataRow['Email'];
        $this->Telefono = $dataRow['Telefono'];
        $this->Curso = $dataRow['Curso'];
        $this->Fecha = $dataRow['Fecha'];
    }

    // UPDATE
    public function updateEmployee()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        Nombre = :Nombre, 
                        Email = :Email, 
                        Telefono = :Telefono, 
                        Curso = :Curso, 
                        Fecha = :Fecha
                    WHERE 
                        id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $this->Telefono = htmlspecialchars(strip_tags($this->Telefono));
        $this->Curso = htmlspecialchars(strip_tags($this->Curso));
        $this->Fecha = htmlspecialchars(strip_tags($this->Fecha));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind data
        $stmt->bindParam(":Nombre", $this->Nombre);
        $stmt->bindParam(":Email", $this->Email);
        $stmt->bindParam(":Telefono", $this->Telefono);
        $stmt->bindParam(":Curso", $this->Curso);
        $stmt->bindParam(":Fecha", $this->Fecha);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deleteEmployee()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

}
?>