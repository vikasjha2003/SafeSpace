<?php
ob_clean();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");

include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $password = trim($_POST["password"] ?? '');

    if (empty($name) || empty($email) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit;
    }

    // Check existing user
    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $res = $check->get_result();

    if ($res && $res->num_rows > 0) {
        echo json_encode(["status" => "exists", "message" => "User already exists!"]);
        exit;
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Registration successful."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . $stmt->error]);
    }
}
?>