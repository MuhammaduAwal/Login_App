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

if(!empty($data->email) && !empty($data->password)) {

    $query = "SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->execute([$data->email]);

    if($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $row['id'];
        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];

        if(password_verify($data->password, $password)) {
            $user_data = array(
                "id" => (int)$id,
                "name" => $name,
                "email" => $email
            );

            http_response_code(200);
            echo json_encode(array(
                "status" => 1,
                "message" => "Login successful.",
                "data" => $user_data
            ));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Invalid email or password."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Invalid email or password."));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status" => 0, "message" => "Login failed. Data is incomplete."));
}
?>
