<?php
session_start();
if (!isset($_SESSION["user"]) || !is_array($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

require_once "database.php";

// Fetch the current user's email from the session
$userEmail = $_SESSION["user"]["email"];

if (isset($_POST["confirm"])) {
    // Prepare the statement to delete the user by email
    $deleteQuery = $conn->prepare("DELETE FROM users WHERE email = ?");
    $deleteQuery->bind_param("s", $userEmail);
    
    if ($deleteQuery->execute()) {
        // Destroy the session and log out the user
        session_unset();
        session_destroy();
        header("Location: login.php?status=deleted");
        exit;
    } else {
        die("Error deleting account.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Are you sure you want to delete your account?</h2>
        <form action="delete.php" method="post">
            <div class="form-btn">
                <input type="submit" class="btn btn-danger" value="Delete Account" name="confirm">
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
