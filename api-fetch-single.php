<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['sid'];

require 'config.php';

$stmt = $conn->prepare("SELECT * FROM student_tbl WHERE id = :id");
$stmt->bindParam(":id", $id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $result = $stmt->fetch();
    echo json_encode($result);
} else {
    echo json_encode([
        'message' => 'No Record Found',
        'status' => false
    ]);
}
