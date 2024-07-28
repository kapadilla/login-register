<?php
session_start();
if (!isset($_SESSION["user"]) || !is_array($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

require_once "database.php";

// Fetch user data from the database
$userId = $_SESSION["user"]["email"];
$query = $conn->prepare("SELECT full_name, email FROM users WHERE email = ?");
$query->bind_param("i", $userId);
$query->execute();
$userData = $query->get_result()->fetch_assoc();

// Update user data
if (isset($_POST["submit"])) {
    $newFullName = trim($_POST["fullname"]);
    $newEmail = trim($_POST["email"]);

    $errors = array();

    if (empty($newFullName) || empty($newEmail)) {
        $errors[] = "All fields are required.";
    }
    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is not valid.";
    }

    if (empty($errors)) {
        $updateQuery = $conn->prepare("UPDATE users SET full_name = ?, email = ? WHERE email = ?");
        $updateQuery->bind_param("ssi", $newFullName, $newEmail, $userId);
        if ($updateQuery->execute()) {
            $_SESSION["user"]["fullName"] = $newFullName;
            $_SESSION["user"]["email"] = $newEmail;
            header("Location: index.php?status=updated");
            exit;
        } else {
            die("Error updating information.");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($errors) && count($errors) > 0) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }
        ?>
        <form action="edit.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name:" value="<?php echo htmlspecialchars($userData['full_name']); ?>" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Update" name="submit">
                <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </form>
    </div>
</body>
</html>
