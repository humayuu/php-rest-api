<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"), true);

$id = filter_var($data['id'], FILTER_SANITIZE_SPECIAL_CHARS);
$studentName = filter_var($data['student_name'], FILTER_SANITIZE_SPECIAL_CHARS);
$studentAge = filter_var($data['age'], FILTER_SANITIZE_SPECIAL_CHARS);
$studentCity = filter_var($data['city'], FILTER_SANITIZE_SPECIAL_CHARS);

require 'config.php';

$stmt = $conn->prepare("UPDATE student_tbl
                                  SET student_name = :sname,
                                      age = :sage,
                                      city = :scity
                                  WHERE id = :id");
$stmt->bindParam(":id", $id);
$stmt->bindParam(":sname", $studentName);
$stmt->bindParam(":sage", $studentAge);
$stmt->bindParam(":scity", $studentCity);
$result = $stmt->execute();

if ($result) {
    echo json_encode([
        'message' => 'Successfully Update',
        'status' => true
    ]);
} else {
    echo json_encode([
        'message' => 'Error',
        'status' => false
    ]);
}
