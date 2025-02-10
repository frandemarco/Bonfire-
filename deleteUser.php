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
    <title>Welcome</title>
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
        <h1>Delete User:</h1>

        <div id="primary-window" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark ">
            <h1 class="my-5">Are you sure you want to delete this user?</h1>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">id#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row"><?= $id?></th>
                        <td><?= $row["first_name"] ?></td>
                        <td><?= $row["last_name"] ?></td>
                        <td><?= $row["email"] ?></td>
                        <td><?= $row["role"] ?></td>
                    </tr>

                </tbody>
            </table>
        </div>

        <form action="processor/deleteUserProcessor.php" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="submit" value="Yes, delete this user.">
        </form>
    </div>

</main>
<!-- end .container -->
<!--       _
       .__(.)< (Connor did it!)
        \___)
~~~~~~~~~~~~~~~~~~-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script></body>
</html>
