<?php
require '../vendor/autoload.php';
use League\HTMLToMarkdown\HtmlConverter;


class Employee
{

    // Connection
    private $conn;

    // Table
    private $db_table = "cursos_fp";

    // Columns
    public $id;
    public $Nombre;
    public $Objetivos;
    public $Preparacion;
    public $Trabajo;
    public $Acceso;

    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function getEmployees()
    {
        $sqlQuery = "SELECT id, Nombre, Objetivos, Preparacion, Trabajo, Apellidos, Acceso FROM " . $this->db_table . "";
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
                    Objetivos = :Objetivos, 
                        Preparacion = :Preparacion, 
                        Trabajo = :Trabajo, 
                        Acceso = :Acceso";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
        $this->Objetivos = htmlspecialchars(strip_tags($this->Objetivos));
        $this->Preparacion = htmlspecialchars(strip_tags($this->Preparacion));
        $this->Trabajo = htmlspecialchars(strip_tags($this->Trabajo));
        $this->Acceso = htmlspecialchars(strip_tags($this->Acceso));

        // bind data
        $stmt->bindParam(":Nombre", $this->Nombre);
        $stmt->bindParam(":Objetivos", $this->Objetivos);
        $stmt->bindParam(":Preparacion", $this->Preparacion);
        $stmt->bindParam(":Trabajo", $this->Trabajo);
        $stmt->bindParam(":Acceso", $this->Acceso);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // UPDATE
    public function getSingleCurso()
    {
        $converter = new HtmlConverter();

        $sqlQuery = "SELECT
                        id, 
                        Nombre, 
                        Objetivos, 
                        Preparacion, 
                        Trabajo, 
                        Acceso
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
        $this->Objetivos = (html_entity_decode($dataRow['Objetivos']));
        $this->Preparacion = (html_entity_decode($dataRow['Preparacion']));
        $this->Trabajo = html_entity_decode($dataRow['Trabajo']);
        $this->Acceso = html_entity_decode($dataRow['Acceso']);
    }

    // UPDATE
    public function updateEmployee()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        Nombre = :Nombre, 
                        Objetivos = :Objetivos, 
                        Preparacion = :Preparacion, 
                        Trabajo = :Trabajo, 
                        Acceso = :Acceso
                    WHERE 
                        id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
        $this->Objetivos = htmlspecialchars(strip_tags($this->Objetivos));
        $this->Preparacion = htmlspecialchars(strip_tags($this->Preparacion));
        $this->Trabajo = htmlspecialchars(strip_tags($this->Trabajo));
        $this->Acceso = htmlspecialchars(strip_tags($this->Acceso));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind data
        $stmt->bindParam(":Nombre", $this->Nombre);
        $stmt->bindParam(":Objetivos", $this->Objetivos);
        $stmt->bindParam(":Preparacion", $this->Preparacion);
        $stmt->bindParam(":Trabajo", $this->Trabajo);
        $stmt->bindParam(":Acceso", $this->Acceso);
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