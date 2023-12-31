<?php

if (empty($_POST["name"])){
    die("Name is required");
}

if (! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 6) {
    die("Password must be at least 6 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",
$_POST["name"],
$_POST["email"],
$password_hash);

try {
    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        die("An error occurred during signup: " . $stmt->error);
    }
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() === 1062) {
        die("Email already taken. Please go back to the go back to the <a href='index.html'> signup page</a> and try again");
    } else {
        die("An error occurred during signup: " . $e->getMessage());
    }
}



?>