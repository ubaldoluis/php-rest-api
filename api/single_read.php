<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Telefono: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../class/employees.php';

$database = new Database();
$db = $database->getConnection();

$item = new Employee($db);

$item->id = isset($_GET['id']) ? $_GET['id'] : die();

$item->getSingleEmployee();

if ($item->Nombre != null) {
    // create array
    $emp_arr = array(
        "id" => $item->id,
        "Nombre" => $item->Nombre,
        "Email" => $item->Email,
        "Telefono" => $item->Telefono,
        "Curso" => $item->Curso,
        "Fecha" => $item->Fecha
    );

    http_response_code(200);
    echo json_encode($emp_arr);
} else {
    http_response_code(404);
    echo json_encode("Employee not found.");
}
?>