<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if(isset($_GET["userid"])) {
    $_SESSION["currentuser"] = $_GET["userid"];
}
$firstName = htmlspecialchars($_SESSION["first_name"]);
$lasName = htmlspecialchars($_SESSION["last_name"]);
$Email = htmlspecialchars($_SESSION["email"]);
$role = $_SESSION["role"];
//var_dump($_SESSION);
require_once ('config.php');
$pdo =getDBConnection();

$class_id = $_SESSION["currentclass"];
$param_id = $_GET["classid"];


$imageString = "classpic/class-$param_id.jpg";
if(file_exists($imageString))
{
    $classImage = $imageString;
}
else{
    $classImage = "classpic/class_default.jpg";
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
    <title><?= $className ?> Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="resources/stylesheets/style.css">
    <link rel="stylesheet" href="resources/stylesheets/inputfield.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<?php include("svgImages.html"); ?>
<main class="d-flex flex-nowrap">
    <?php include("leftSideMenu.php"); ?>
    <div id="primary-window" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark overflow-y-scroll">
        <?php include("classTopMenu.php"); ?>
    <div id="primary-window" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark">
        <h1 class="my-5">Class Profile Pic Settings</h1>
        <img src="<?= $classImage?>" alt="" width="650" height="350"  id="profilepic">

        <form action="processor/changeClassPicProcessor.php" method="post" enctype="multipart/form-data">
            <label for="avatar">Upload a jpeg for your class pic:</label>
            <input type="file" name="avatar" type="image/jpg"/>
            <input type="hidden" name="class_id" value="<?= $class_id ?>">
            <input type="submit" value="Upload"/>
        </form>
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