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
       c.term,c.is_active, u.first_name, u.last_name FROM classes c
        Join users u on c.teacher_id = u.id";
// echo "before stmt";
if($stmt = $pdo->prepare($sql)) {
    // echo "stmt prepared";
// Bind variables to the prepared statement as parameters
// Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // echo "stmt executed";
        $rows = $stmt->fetchAll();
    }
}
//echo "printing seession";
//var_dump($_SESSION);
//foreach ($rows as $row) {
//    echo "printing class";
//    var_dump($row);
//}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Classes</title>
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
        <div>
            <a href="addClass.php" class="btn btn-primary">Add Class</a>
        </div>
        <h1 class="my-5">Manage Classes</h1>
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
                if($row["is_active"]){
                $class_id = $row["id"];
                ?>
                <div class="card flex-grid-card" style="width: 18rem;">
                    <img src="<?= $classImage?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row["class_name"] ?></h5>
                        <p class="card-text"> Teacher <?= $row["first_name"] . " " .$row["last_name"]?></p>
                        <p class="card-text"> Term <?= $row["term"]?></p>
                        <p class="card-text"> Start Date: <?= $row["start_date"]?></p>
                        <p class="card-text"> End Date: <?= $row["end_date"]?></p>
                        <a href="editClass.php?id=<?= $class_id?>" class="btn btn-info">Edit</a>
                        <a href="deleteClass.php?id=<?= $class_id?>" class="btn btn-danger">Archive</a>
                    </div>
                </div>

                <?php
            }
            }
            ?>
        </div>
    </div>
    <!-- end .container -->
    <!--       _
           .__(.)< (Connor did it!)
            \___)
    ~~~~~~~~~~~~~~~~~~-->
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="resources/scripts/popups.js">
    // let params = new URLSearchParams(location.search);
    // let status = params.get('status');
    // if(status!==null)
    //     alert(status);
</script>
</body>
</html>