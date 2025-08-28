<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$data = json_decode(file_get_contents("php://input"), true);

$search = filter_var($data['search']);

require 'config.php';

$stmt = $conn->prepare("SELECT * FROM student_tbl WHERE student_name LIKE '%:sname%'");
$stmt->bindParam(":sname", $search);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} else {
    echo json_encode([
        'message' => 'No Search Found',
        'status' => false
    ]);
}
