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
$sql = "SELECT c.id, c.class_name, c.start_date, c.end_date, 
       c.term, u.first_name, u.last_name FROM classes c
        Join users u on c.teacher_id = u.id WHERE c.id = :class_id
";

if($stmt = $pdo->prepare($sql)) {
// Bind variables to the prepared statement as parameters
// Attempt to execute the prepared statement

    $stmt->bindParam(":class_id", $class_id, PDO::PARAM_INT);
    $class_id = $_GET["id"];

    if ($stmt->execute()) {
//        echo "execute select class";
        if($stmt->rowCount() == 1){
//            echo "row count1 on select class";
            if($row = $stmt->fetch()) {
//                echo "fetch ";
                $class_id = $row["id"];
                $class_name =$row["class_name"];
                $currentTeacherId=$row["teacher_id"];
                $start_date =$row["start_date"];
                $end_date= $row["end_date"];
                $term =$row["term"];
                $currentTeacherFirst=$row["first_name"];
                $currentTeacherLast=$row["last_name"];
                //var_dump($row);
            }
        }
    }
    //echo $currentTeacherId;
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
        <h1 class="my-5">Archive Class</h1>

        <div id="primary-window" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark ">
            <h1 class="my-5">Are you sure you want to Archive this class?</h1>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">id#</th>
                    <th scope="col">Class Name</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Term</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row"><?= $class_id?></th>
                    <td><?= $row["class_name"] ?></td>
                    <td><?= $row["first_name"] ?></td>
                    <td><?= $row["last_name"] ?></td>
                    <td><?= $row["start_date"] ?></td>
                    <td><?= $row["end_date"] ?></td>
                    <td><?= $row["term"] ?></td>
                </tr>

                </tbody>
            </table>
        </div>

    <form action="processor/deleteClassProcessor.php" method="post">
        <input type="hidden" name="id" value="<?= $class_id ?>">
        <input type="submit" value="Yes, delete this class.">
    </form>
    </div>



</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script></body>
</html>

<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th scope="col">id#</th>
        <th scope="col">Class Name</th>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">Start Date</th>
        <th scope="col">End Date</th>
        <th scope="col">Term</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row"><?= $class_id?></th>
        <td><?= $row["class_name"] ?></td>
        <td><?= $row["first_name"] ?></td>
        <td><?= $row["last_name"] ?></td>
        <td><?= $row["start_date"] ?></td>
        <td><?= $row["end_date"] ?></td>
        <td><?= $row["term"] ?></td>
    </tr>

    </tbody>
    <!-- end .container -->
    <!--       _
           .__(.)< (Connor did it!)
            \___)
    ~~~~~~~~~~~~~~~~~~-->
</table>