<?php

$host = "localhost";
$username = "authuser";
$password = "YOUR_PASSWORD_HERE";
$database = "auth_demo";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed.");
}

$conn->set_charset("utf8mb4");
