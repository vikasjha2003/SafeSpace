<?php
// ✅ Start session safely
if (session_status() === PHP_SESSION_NONE) {
    $customSessionPath = __DIR__ . "/../sessions";
    if (!file_exists($customSessionPath)) {
        mkdir($customSessionPath, 0755, true); // safer permissions
    }

    ini_set("session.gc_maxlifetime", 3600);
    ini_set("session.cookie_lifetime", 3600);
    session_save_path($customSessionPath);

    session_start();
}

// ✅ Database connection
$servername = "localhost";
$username   = "root"; // consider using a dedicated DB user
$password   = "Rohan@2005";
$dbname     = "safespace";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("DB Connection failed: " . $conn->connect_error);
    die("Internal server error. Please try again later.");
}
?>