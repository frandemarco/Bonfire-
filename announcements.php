<?php
// Initialize the session
//echo "Starting session";
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
$currentclassName = $_SESSION["class_name"];
$pdo = getDBConnection();

$sql = "SELECT * FROM announcements WHERE class_id = :classid";

if($stmt = $pdo->prepare($sql)) {
// Bind variables to the prepared statement as parameters
// Attempt to execute the prepared statement
    $stmt->bindParam(":classid", $classid, PDO::PARAM_INT);
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
//var_dump($_POST);
//var_dump($rows);
//var_dump($stmt);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$className ?> Announcements</title>
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
    <div id="primary-window" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark overflow-y-scroll align-items-center">
        <?php include("classTopMenu.php"); ?>
        <h1 class="my-5">Announcements.</h1>
        <?php
        if($role == "teacher"){
            ?>
            <div class="flex-grid-wrapper">
                <p>
                    <a href="createAnnouncement.php?classid=<?= $_SESSION["currentclass"] ?>" class="btn btn-info">Make an announcement.</a>
                </p>
            </div>
            <?php
        }
        ?>
        <!--        <table class="table table-striped table-hover">-->
        <!--        <thead>-->
        <!--        <tr>-->
        <!---->
        <!--            <th scope="col">Title</th>-->
        <!--            <th scope="col">Announcement</th>-->
        <!--            <th scope="col">Date</th>-->
        <!---->
        <!---->
        <!--        </tr>-->
        <!--        </thead>-->
        <!--        <tbody>-->
        <!--        --><?php
        //        $count = 1;
        //        foreach($rows as $row)
        //        {
        //            $id = $row["id"];
        //            ?>
        <!--            <tr>-->
        <!---->
        <!--                <td>--><?php //= $row["announcement_title"] ?><!--</td>-->
        <!--                <td>--><?php //= $row["announcement_message"] ?><!--</td>-->
        <!--                <td>--><?php //= $row["date"] ?><!--</td>-->
        <!---->
        <!--            </tr>-->
        <!--            --><?php
        //            $count++;
        //        }
        //        ?>
        <!--        </tbody>-->
        <!--        </table>-->

        <div class="flex-grid-wrapper">
            <?php
            foreach($rows as $row)
            {
                $id = $row["id"];
                $phpDate = strtotime($row["date"]);
                $formattedDate = date("m-d-Y", $phpDate)
                ?>
                <div class="card flex-grid-card" style="width: 18rem; margin-bottom: 2em;">
                    <a href="viewAnnouncement.php?announcementid=<?= $row['id'] ?>">
                        <!--                    <img src="resources/images/class_stock_photo.jpg" class="card-img-top" alt="...">-->
                        <div class="card-body">
                            <h5 class="card-title"><?= $row["title"] ?></h5>
                            <h5 class="card-title"><?= $formattedDate?></h5>
                            <?php
                            if($role == "teacher"){
                                ?>
                                <a href="updateAnnouncement.php?announcementid=<?= $row['id'] ?>" class="btn btn-info">Edit</a>
                                <a href="#" class="btn btn-danger">Delete</a>
                                <?php
                            }
                            ?>


                        </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>



</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="resources/scripts/popups.js">
    // let params = new URLSearchParams(location.search);
    // let status = params.get('status');
    // if(status!==null)
    //     alert(status);
</script>
</body>

<!-- end .container -->
<!--       _
       .__(.)< (Connor did it!)
        \___)
~~~~~~~~~~~~~~~~~~-->
</html>