<?php
// Initialize the session
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "admin"){
    header("location: login.php");
    exit;
}

$firstName = htmlspecialchars($_SESSION["first_name"]);
$role = $_SESSION["role"];

$pdo = getDBConnection();
$sql = "SELECT * FROM users where id = :id";

if($stmt = $pdo->prepare($sql)) {
// Bind variables to the prepared statement as parameters
    $stmt->bindParam(":id", $userID, PDO::PARAM_INT);
    $userID = $_GET["id"];
// Attempt to execute the prepared statement

    if ($stmt->execute()) {
        if($stmt->rowCount() == 1){
            if($row = $stmt->fetch()) {
                $id = $row["id"];
                $email = $row["email"];
                $fname = $row["first_name"];
                $lname = $row["last_name"];
                $userRole = $row["role"];
            }
        }
    }
}

//var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="resources/stylesheets/style.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<?php include("svgImages.html"); ?>
<main class="d-flex flex-nowrap">
    <?php include("leftSideMenu.php"); ?>
    <div id="primary-window" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark ">
        <h1>Change Personal Information:</h1>
        <form action="processor/editUserProcessor.php" method="post">
            <label for="fname">First name:</label><br>
            <input type="text" id="fname" name="fname" value="<?= $fname?>"><br>
            <label for="lname">Last name:</label><br>
            <input type="text" id="lname" name="lname" value="<?= $lname?>"><br>
            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email" value="<?= $email?>"><br>
            <br>

            <p>Change Role:</p>
            <select class="form-select" name="role" aria-label="Default select example">
                <option value="student" <?php echo ($userRole == "student") ? "selected=selected" : ""?> >Student</option>
                <option value="teacher" <?php echo ($userRole == "teacher") ? "selected=selected" : ""?> >Teacher</option>
                <option value="admin" <?php echo ($userRole == "admin") ? "selected=selected" : ""?> >Admin</option>
            </select>
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="submit" value="Submit">
        </form>
    </div>

</main>
<!-- end .container -->
<!--       _
<!-       .__(.)< (Connor did it!)
<!-        \___)
<!-~~~~~~~~~~~~~~~~~-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script></body>
</html>