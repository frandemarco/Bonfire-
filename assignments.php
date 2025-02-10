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
//var_dump($_SESSION);

$pdo = getDBConnection();
$sql = "SELECT * FROM assignments WHERE class_id = :classid";

if($stmt = $pdo->prepare($sql)) {
// Bind variables to the prepared statement as parameters
// Attempt to execute the prepared statement
    $stmt->bindParam(":classid", $classid);
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
//var_dump($stmt);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $className ?> Assignments</title>
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
    <div id="primary-window " class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark overflow-y-scroll">
        <h1 class="my-5">Assignments.</h1>
        <?php
        if($role == "teacher"){
            ?>
            <div class="flex-grid-wrapper">
                <p>
                    <a href="createAssignment.php?classid=<?= $_SESSION["currentclass"] ?>" class="btn btn-info">Make an assignment.</a>
                </p>
            </div>
            <?php
        }
        ?>
        <table class="table table-striped table-hover"
        <thead>
        <tr>
            <th scope="col">Assignment</th>
            <th scope="col">Max Grade</th>
            <th scope="col">Description</th>
            <th scope="col">Due Date</th>
            <th scope="col">Availability</th>
            <th scope="col">Category</th>
            <th scope="col">Actions</th>

        </tr>
        </thead>
        <tbody>
        <?php
        $count = 1;
        //TODO: Add row potential join in sql to get if there is a submission for this student for this assignment and if so, put a field saying submitted
        foreach($rows as $row)
        {
//            var_dump($row);
            if($row["is_active"]){
            $id = $row["id"];
            ?>
            <tr>
                <td><?= $row["assignment_name"] ?></td>
                <td><?= $row["max_grade"] ?></td>
                <td><?= $row["description"] ?></td>
                <td><?= $row["due_date"] ?></td>
                <td>
                <?php
                date_default_timezone_set("America/New_York");
                if(strtotime(date_default_timezone_get())<strtotime($row["due_date"])){
                    ?>
                    Open
                    <?php
                }
                ?>
                    <?php
                    date_default_timezone_set("America/New_York");
                    if(strtotime(date_default_timezone_get())>strtotime($row["due_date"])){
                        ?>
                        Closed
                        <?php
                    }
                    ?>
                </td>
                <td><?= $row["category"] ?></td>
                <td>
                    <?php
                    date_default_timezone_set("America/New_York");
                    if(strtotime(date_default_timezone_get())<strtotime($row["due_date"])){
                        ?>
                        <a href="viewAssignment.php?id=<?= $id?>" class="btn btn-info">View</a>
                        <?php
                    }
                    ?>
                    <?php
                    date_default_timezone_set("America/New_York");
                    if(strtotime(date_default_timezone_get())>strtotime($row["due_date"])){
                        ?>
                        <button type="button" class="btn btn-danger" disabled> Closed</button>
                        <?php
                    }
                    ?>

                    <?php
                    if($role == "teacher"){
                        ?>
                        <a href="editAssignment.php?id=<?= $id?>" class="btn btn-warning">Edit</a>
                        <a href="deleteAssignment.php?id=<?= $id?>" class="btn btn-danger">Delete</a>
                        <a href="viewSubmissions.php?id=<?= $id?>" class="btn btn-danger">View Submissions</a>
                        <?php
                    }
                    ?>
<!--                    <a href="editAssignment.php?id=--><?php //= $id?><!--" class="btn btn-warning">Edit</a>-->
<!--                    <a href="deleteAssignment.php?id=--><?php //= $id?><!--" class="btn btn-danger">Delete</a>-->
                </td>
            </tr>
            <?php
            $count++;
            }
        }
        ?>
        </tbody>
        </table>
    </div>



</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="resources/scripts/popups.js"></script>
</body>
<!-- end .container -->
<!--       _
       .__(.)< (Connor did it!)
        \___)
~~~~~~~~~~~~~~~~~~-->
</html>