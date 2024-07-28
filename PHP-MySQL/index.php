<?php
session_start();
if (!isset($_SESSION["user"]) || !is_array($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$fullName = $_SESSION["user"]["fullName"];
$email = $_SESSION["user"]["email"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p>Logo</p>
        </div>
    </div>
    <main>
        <div class="main-box">
            <div class="top">
                <div class="box">
                    <p>Hello, <?php echo htmlspecialchars($fullName); ?>.</p>
                </div>
                <div class="box">
                    <p>Your email is <?php echo htmlspecialchars($email); ?>.</p>
                </div>
            </div>
            <div class="bottom">
                <a href="edit.php" class="btn btn-primary">Edit Information</a>
                <a href="delete.php" class="btn">Delete Account</a>
                <a href="logout.php" class="btn logout-btn">Log Out</a>
            </div>
        </div>
    </main>
</body>
</html>