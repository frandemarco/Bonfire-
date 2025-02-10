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
$syllabusFile = "class_data/$classid/syllabus.pdf";

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
    <title><?= $className ?> Syllabus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="resources/stylesheets/table.css">
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

        <?php
            if(file_exists($syllabusFile))
            {
                ?>
                    <iframe src="<?=$syllabusFile?>" width = "100%" style="height:100%" frameborder="0"></iframe>
                <?php
            }
            else{
                ?>
                    <h1>No Syllabus Uploaded yet...</h1>
                <?php
            }
        ?>

        <?php
        if($role == "teacher"){
            ?>
            <form action="processor/addSyllabusProcessor.php" method="post" enctype="multipart/form-data">
                <input type="file" name="syllabus" accept="application/pdf">
                <input type="submit" value="Upload Syllabus">
                <input type="hidden" name="classid" value="<?=$classid?>">
            </form>
            <?php
        }
        ?>

    </div>
    <!-- end .container -->
    <!--       _
           .__(.)< (Connor did it!)
            \___)
    ~~~~~~~~~~~~~~~~~~-->
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script></body>
<script src="resources/scripts/popups.js">
    // let params = new URLSearchParams(location.search);
    // let status = params.get('status');
    // if(status!==null)
    //     alert(status);
</script>
</html>