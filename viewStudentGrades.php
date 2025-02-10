<?php
// Initialize the session
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$firstName = htmlspecialchars($_SESSION["first_name"]);
$role = $_SESSION["role"];
$classid = $_SESSION["currentclass"];


$pdo = getDBConnection();
$sql = "SELECT u.id, u.first_name, u.last_name, u.email, u.role FROM course_grades cg       
        join users u on cg.user_id = u.id
        WHERE class_id = :classid
        ";

if($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(":classid", $classid);
// Bind variables to the prepared statement as parameters
// Attempt to execute the prepared statement
    if ($stmt->execute()) {
        $rows = $stmt->fetchAll();
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
//var_dump($_SESSION);
//var_dump($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $className ?> Student Grades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="resources/stylesheets/table.css">
    <link rel="stylesheet" href="resources/stylesheets/style.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<?php include("svgImages.html"); ?>
<main class="d-flex flex-nowrap">
    <?php include("leftSideMenu.php")?>
    <div id="primary-window" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark overflow-y-scroll">
        <?php include("classTopMenu.php"); ?>
    <div id="primary-window" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark overflow-y-scroll">
        <h1 class="my-5">Student Grades.</h1>
        <table class="table table-striped table-hover"
        <thead>
        <tr>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $count = 1;
        foreach($rows as $row)
        {
            $id = $row["id"];
            ?>
            <tr>
                <td><?= $row["first_name"] ?></td>
                <td><?= $row["last_name"] ?></td>
                <td><?= $row["email"] ?></td>
                <td class ='<?= $role?>'><?= $row["role"] ?></td>
                <td>
                    <a href="studentGrade.php?id=<?= $id?>" class="btn btn-info">View Grades</a>
                </td>
            </tr>
            <?php
            $count++;
        }
        ?>
        </tbody>
        </table>

    </div>
    <!-- end .container -->
    <!--       _
           .__(.)< (Connor did it!)
            \___)
    ~~~~~~~~~~~~~~~~~~-->
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script></body>
</html>