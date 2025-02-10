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
$announcementid = $_GET["announcementid"];
//var_dump($_SESSION);
$currentclassName = $_SESSION["class_name"];
$pdo = getDBConnection();

$sql = "SELECT * FROM announcements WHERE id = :announcementid";

if($stmt = $pdo->prepare($sql)) {
// Bind variables to the prepared statement as parameters
// Attempt to execute the prepared statement
//    $stmt->bindParam(":classid", $classid, PDO::PARAM_INT);
    $stmt->bindParam(":announcementid", $announcementid, PDO::PARAM_INT);
    if ($stmt->execute()) {
//        echo "execute select class";
        if($stmt->rowCount() == 1){
//            echo "row count1 on select class";
            if($row = $stmt->fetch()) {
//                echo "fetch ";
                $body = $row["body"];

//                var_dump($row);
            }
        }
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
$sql3 = "Select c.text, u.first_name, u.last_name, c.date, c.id from comments c 
        join users u on c.user_id = u.id
        join announcements a on c.announcement_id = a.id
        where a.id = :announcement_id
        order by c.date
";

if($stmt3 = $pdo->prepare($sql3)){
    $stmt3->bindParam(":announcement_id", $announcementid );
    if($stmt3->execute())
    {
        $rows3 = $stmt3->fetchAll();
    }
}
//$sql3 = "SELECT c.text, u.first_name, u.last_name FROM users u
//        join comments c on c.user_id = u.id
//        WHERE id = :announcementid
//        ";
//if($stmt3 = $pdo->prepare($sql3)) {
//    $stmt3->bindParam(":id", $param_id, PDO::PARAM_INT);
//// Bind variables to the prepared statement as parameters
//// Attempt to execute the prepared statement
//    if ($stmt3->execute()) {
//        $rows3 = $stmt3->fetchAll();
//    }
//}
//
//$sql4 = "SELECT text FROM comments
//          WHERE id = :announcementid";
//
//if($stmt4 = $pdo->prepare($sql4)){
//    $stmt4->bindParam(":id", $param_id, PDO::PARAM_INT);
//    if ($stmt4->execute()) {
//        $rows4 = $stmt4->fetchAll();
//    }
//}



//var_dump($stmt3);
//var_dump($_POST);

//var_dump($stmt);
//var_dump($row);
//var_dump($announcementid);
//var_dump($classid);
//var_dump($_GET);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $className ?> Announcement Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="resources/stylesheets/style.css">
    <link rel="stylesheet" href="resources/stylesheets/replies.css">
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
        <h1 class="my-5">Announcement Information</h1>

        <div class="" style="width:100%">

                <div class="card flex-grid-card bg-dark  bg-gradient" style="width: 100%;">
                        <!--                    <img src="resources/images/class_stock_photo.jpg" class="card-img-top" alt="...">-->
                        <div class="card-body">
                            <h5 class="card-title text-light"><?= $body?> </h5>
                        </div>

<!--                    // TODO: put these in their own div-->
<!--                        <ol>-->
<!--                            --><?php
//                                foreach($rows3 as $row3)
//                                {
//                                    $firstName = $row3["first_name"];
//                                    $lastName = $row3["last_name"];
//                                    $comment = $row3["text"];
//                                    $date = $row3["date"];
//                                    $phpDate = strtotime($date);
//                                    $formattedDate = date("m-d-Y", $phpDate)
//                                ?>
<!--                                    <li>-->
<!--                                        --><?php //= $firstName ?><!-- --><?php //= $lastName ?><!-- said: --><?php //= $comment ?>
<!--                                        on --><?php //= $formattedDate ?>
<!--                                    </li>-->
<!--                            --><?php
//                                }
//                            ?>
<!--                        </ol>-->
                    <p>
                        <a href="replyAnnouncement.php?announcementid=<?= $row['id'] ?>" class="btn btn-info">Reply</a>
                    </p>
                </div>

        </div>
        <div class="flex-grid-wrapper">


                <div class="card flex-grid-card" style="width: 18rem;">
                    <div class="card-body" id="replies">
                        <hr>
                        <?php
                        if(empty($rows3)){
                            ?>
                        <p class="replies">No replies made yet</p>
                            <hr>
                        <?php
                        }
                        ?>
<!--                        <ol>-->
                            <?php
                            foreach($rows3 as $row3)
                            {
                                $firstName = $row3["first_name"];
                                $lastName = $row3["last_name"];
                                $comment = $row3["text"];
                                $date = $row3["date"];
                                $phpDate = strtotime($date);
                                $formattedDate = date("m-d-Y", $phpDate);
                                $commentid = $rows3["id"];
                                ?>
<!--                                <li>-->
                                    <p class="replies"><?= $firstName ?> <?= $lastName ?> said: <?= $comment ?> <br>
                                    on <?= $formattedDate ?> <br>
                                        <?= $rows3["id"] ?>
                                    </p>
<!--                                </li>-->
                                <!--                    // TODO: Allow teachers to delete announcement reply-->
<!--                                --><?php
//                                if($role == "teacher"){
//                                    ?>
<!--                                    <br> <br><br>-->
<!--                                    <a href="processor/deleteReplyProcessor.php?commentid=--><?php //= $commentid ?><!--" class="btn btn-danger">Delete</a>-->
<!--                                    --><?php
//                                }
//                                ?>
                                <hr>
                                <?php
                            }
                            ?>
<!--                        </ol>-->
                    </div>
                </div>

        </div>
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