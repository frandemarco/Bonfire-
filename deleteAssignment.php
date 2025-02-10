<?php
// Initialize the session
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "teacher"){
    header("location: login.php");
    exit;
}

$firstName = htmlspecialchars($_SESSION["first_name"]);
$role = $_SESSION["role"];

$pdo = getDBConnection();
$sql = "SELECT * FROM assignments where id = :id";

if($stmt = $pdo->prepare($sql)) {
// Bind variables to the prepared statement as parameters
    $stmt->bindParam(":id", $aID, PDO::PARAM_INT);
    $aID = $_GET["id"];
// Attempt to execute the prepared statement

    if ($stmt->execute()) {
        if($stmt->rowCount() == 1){
            if($row = $stmt->fetch()) {
                $id = $row["id"];
                $asname = $row["assignment_name"];
                $mgrade = $row["max_grade"];
                $descr = $row["description"];
                $ddate = $row["due_date"];
                $categ = $row["category"];
            }
        }
    }
}

$sql2 = "Select * from classes where id = :id";
if($stmt2=$pdo->prepare($sql2))
{
    $stmt2->bindParam(":id", $param_id, PDO::PARAM_INT);
    $param_id  = $_GET["classid"];
    if($stmt2->execute())
    {
        if($stmt2->rowCount() == 1) {
            if ($row2 = $stmt2->fetch()) {
                $className = $row2["class_name"];
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $className ?> Archive Assignemnt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="resources/stylesheets/style.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<?php include("svgImages.html"); ?>
<main class="d-flex flex-nowrap">
    <?php include("leftSideMenu.php")?>
    <div id="primary-window" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark overflow-y-scroll">
        <?php include("classTopMenu.php"); ?>
    <div id="primary-window" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark overflow-y-scroll">
        <h1>Delete Assignment:</h1>

        <div id="primary-window" style="margin:auto" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark ">
            <h1 class="my-5">Are you sure you want to delete this assignment?</h1>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Max Grade</th>
                    <th scope="col">Description</th>
                    <th scope="col">Due Date</th>
                    <th scope="col">Category</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row"><?= $id?></th>
                    <td><?= $row["assignment_name"] ?></td>
                    <td><?= $row["max_grade"] ?></td>
                    <td><?= $row["description"] ?></td>
                    <td><?= $row["due_date"] ?></td>
                    <td><?= $row["category"] ?></td>
                </tr>

                </tbody>
            </table>
        </div>

        <form action="deleteAssignmentProcessor.php" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="submit" value="Yes, delete this assignment.">
        </form>
    </div>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script></body>
</html>

