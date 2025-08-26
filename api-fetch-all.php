<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');


require 'config.php';

$stmt = $conn->prepare("SELECT * FROM student_tbl");
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $result = $stmt->fetchAll();
    echo json_encode($result);
} else {
    echo json_encode([
        'message' => 'No Record Found',
        'status' => false
    ]);
}
