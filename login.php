<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf ("SELECT * FROM user
            WHERE email = '%s'",
            $mysqli->real_escape_string($_POST["email"]));
    
            $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    var_dump($user);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="login">
    
    
        <div class="login-card">
    
          <h1>Blog Spot</h1>
          <h2>Login</h2>
          <form class="login-form" method="POST">
            
            <!-- Email Input -->
            <input type="email" id="email" name="email" placeholder="email"/>
            
            <!-- Password Input -->
            <input type="password" id="password" name="password" placeholder="password"/>

            <p class="loginSignup">Don't have an account?</p>
            <a href="index.html">Signup</a>
            <button class='loginBtn'>LOGIN</button>
          </form>
    </div>
    </div>
</body>
</html>