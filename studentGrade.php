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
$stuID = $_GET["id"];

//var_dump($_SESSION);
//var_dump($_GET);

$pdo = getDBConnection();
$sql = "SELECT * FROM assignments a
         join submission s on a.id = s.assignment_id
         WHERE class_id = :classid and student_id = :student_id";

if($stmt = $pdo->prepare($sql)) {
// Bind variables to the prepared statement as parameters
// Attempt to execute the prepared statement
    $stmt->bindParam(":classid", $classid);
    $stmt->bindParam(":student_id", $stuID);
    if ($stmt->execute()) {
        $rows = $stmt->fetchAll();
    }
}
//var_dump($stmt);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insert class name</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        <div id="primary-window " class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark overflow-y-scroll">
            <h1 class="my-5">This Students Grades.</h1>
            <table class="table table-striped table-hover"
            <thead>
            <tr>
                <th scope="col">Assignment</th>
                <th scope="col">Max Grade</th>
                <th scope="col">Grade</th>
                <th scope="col">Description</th>
                <th scope="col">Due Date</th>
                <th scope="col">Availability</th>
                <th scope="col">Category</th>


            </tr>
            </thead>
            <tbody>
            <?php
            $count = 1;
            $totalMax =  0;
            $totalGrade = 0;
            foreach($rows as $row)
            {
//            var_dump($row);
                if($row["is_active"]){
                    $id = $row["id"];
                    $totalMax+=$row["max_grade"];
                    $totalGrade+=$row["grade"];
                    ?>
                    <tr>
                        <td><?= $row["assignment_name"] ?></td>
                        <td><?= $row["max_grade"] ?></td>
                        <td><?= $row["grade"] ?></td>
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
                    </tr>
                    <?php
                    $count++;
                }
            }
            ?>
            </tbody>
            </table>
            <?php
            $average = $totalGrade / $totalMax *100;
            ?>
            <p>
                Current Class Average: <?= $average ?>%
            </p>
        </div>



</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<!-- end .container -->
<!--       _
       .__(.)< (Connor did it!)
        \___)
~~~~~~~~~~~~~~~~~~-->
</html>