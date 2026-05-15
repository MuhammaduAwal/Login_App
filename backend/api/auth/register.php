<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->name) && !empty($data->email) && !empty($data->password)) {

    // Check if email already exists
    $check_query = "SELECT id FROM users WHERE email = ? LIMIT 1";
    $stmt = $db->prepare($check_query);
    $stmt->execute([$data->email]);

    if($stmt->rowCount() > 0) {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Email already exists."));
    } else {
        $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);

        $password_hash = password_hash($data->password, PASSWORD_BCRYPT);

        if($stmt->execute([$data->name, $data->email, $password_hash])) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "User was created."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to create user."));
        }
    }
} else {
    http_response_code(200);
    echo json_encode(array("status" => 0, "message" => "Unable to create user. Data is incomplete."));
}
?>
