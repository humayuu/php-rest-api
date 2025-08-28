<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"), true);

$studentName = filter_var($data['student_name'], FILTER_SANITIZE_SPECIAL_CHARS);
$studentAge = filter_var($data['age'], FILTER_SANITIZE_SPECIAL_CHARS);
$studentCity = filter_var($data['city'], FILTER_SANITIZE_SPECIAL_CHARS);

require 'config.php';

$stmt = $conn->prepare("INSERT INTO student_tbl (student_name, age, city) VALUES (:sname, :sage, :scity)");
$stmt->bindParam(":sname", $studentName);
$stmt->bindParam(":sage", $studentAge);
$stmt->bindParam(":scity", $studentCity);
$result = $stmt->execute();

if ($result) {
    echo json_encode([
        'message' => 'Successfully Inserted',
        'status' => true
    ]);
} else {
    echo json_encode([
        'message' => 'Error',
        'status' => false
    ]);
}
