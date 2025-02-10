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
    <title><?= $className ?> Create Assignment</title>
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
        <h1 class="my-5">Create Assignment</h1>
        <div>
            <form action="processor/createAssignmentProcessor.php?classid=<?= $_SESSION["currentclass"] ?>" method="post">
                <div class="form-row">
                    <div style="margin:auto"  class="form-group col-md-6">
                        <label for="inputAssignment">Assignment Name</label>
                        <input type="text" name="inputAssignment" class="form-control" id="inputAssignment" placeholder="Enter assignment name here...">
                    </div>
                    <div style="margin:auto"  class="form-group col-md-6">
                        <label for="inputMaxGrade">Maximum Grade</label>
                        <input type="number" name="inputMaxGrade" class="form-control" id="inputMaxGrade" placeholder="Enter max attainable grade. (number only)">
                    </div>
                    <div style="margin:auto"  class="form-group col-md-6">
                        <label for="inputDescription">Description</label>
                        <textarea name="inputDescription" class="form-control" id="inputDescription" placeholder="Enter description..." rows="5" cols="40"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div style="margin:auto"  class="form-group col-md-6">
                        <label for="inputDueDate">Due Date</label>
                        <input type="datetime-local" name = "inputDueDate" class="form-control" id="inputDueDate">
                    </div>
                    <div style="margin:auto" class="form-group col-md-4">
                        <label for="inputAssigmentCategory">Assigment Category</label>
                        <select id="inputAssigmentCategory" class="form-control" name="inputAssigmentCategory">
                            <option selected value="Homework">Homework</option>
                            <option value="Project">Project</option>
                            <option value="Quiz">Quiz</option>
                            <option value="Test">Test</option>
                        </select>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Create Assignment</button>
            </form>
        </div>
    </div>
</main>
<!-- end .container -->
<!--       _
       .__(.)< (Connor did it!)
        \___)
~~~~~~~~~~~~~~~~~~-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script></body>
<script src="resources/scripts/popups.js"></script>
</html>
