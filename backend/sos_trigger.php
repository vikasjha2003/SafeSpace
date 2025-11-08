<?php
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $msg = "SOS alert triggered from user: $email";

    $stmt = $conn->prepare("INSERT INTO sos (user_email, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $msg);
    $stmt->execute();

    echo "SOS alert sent successfully";
}
?>
