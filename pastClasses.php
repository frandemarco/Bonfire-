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
//var_dump($_SESSION);
$pdo = getDBConnection();

if($role == "student") {
    $sql = "SELECT c.id, c.class_name, c.start_date, c.end_date,
        c.term, c.is_active
        FROM classes c
        join course_grades cg on cg.class_id =c.id
        join users u on u.id =cg.user_id
        where u.id = :id
 ";

    if ($stmt = $pdo->prepare($sql)) {
// Bind variables to the prepared statement as parameters
// Attempt to execute the prepared statement
        $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
        $userId = $_SESSION["id"];
        if ($stmt->execute()) {
            $rows = $stmt->fetchAll();
        }
    }
}
else if($role == "teacher") {
    $sql = "SELECT c.id, c.class_name, c.start_date, c.end_date,
        c.term, c.is_active
        FROM    classes c
        where c.teacher_id = :id;
 ";


    if ($stmt = $pdo->prepare($sql)) {
// Bind variables to the prepared statement as parameters
// Attempt to execute the prepared statement
        $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
        $userId = $_SESSION["id"];
        if ($stmt->execute()) {
            $rows = $stmt->fetchAll();
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Past Classes</title>
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
    <div id="primary-window" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark overflow-y-scroll">
<!--        <h1 class="my-5">Hi, <b>--><?php //echo $firstName; ?><!--</b>. Hi, Welcome to our site.</h1>-->
        <?php
        if($role == "student" || $role == "teacher"){
            ?>
            <div class="flex-grid-wrapper">

                <?php
                foreach($rows as $row) {
                    $param_id = $row['id'];
                    $imageString = "classpic/class-$param_id.jpg";
                    if(file_exists($imageString))
                    {
                        $classImage = $imageString;
                    }
                    else{
                        $classImage = "classpic/class_default.jpg";
                    }
                    if($row["is_active"]) {
                    }
                    else{
                        $class_id = $row["id"];
                        ?>

                        <div class="card flex-grid-card" style="width: 18rem;">
                            <a href="class.php?classid=<?= $class_id?>">
                                <img src="<?= $classImage?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $row["class_name"] ?></h5>
                                    <!-- <p class="card-text"> Teacher --><?php //= $row["first_name"] . " " .$row["last_name"]?><!--</p>-->
                                    <p class="card-text"> Term <?= $row["term"]?></p>
                                    <p class="card-text"> Start Date: <?= $row["start_date"]?></p>
                                    <p class="card-text"> End Date: <?= $row["end_date"]?></p>
                                </div>
                            </a>
                        </div>

                        <?php
                    }
                }
                ?>

            </div>
            <?php
        }
        ?>
        <?php
        if($role == "admin"){
            ?>
            <h1>Nothing here for you to see,</h1>
            <h1>look at the left side menu for your options</h1>
            <?php
        }
        ?>
        <!--        <p>-->
        <!--            <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>-->
        <!--            <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>-->
        <!--        </p>-->
    </div>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script></body>

</body>
<!-- end .container -->
<!--       _
       .__(.)< (Connor did it!)
        \___)
~~~~~~~~~~~~~~~~~~-->
</html>