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
$sql = "SELECT * FROM files WHERE class_id = :class_id";

if($stmt = $pdo->prepare($sql)) {
// Bind variables to the prepared statement as parameters
// Attempt to execute the prepared statement
    $stmt->bindParam(":class_id", $classid);
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
    <title><?=$className ?> Files</title>
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
            <h1 class="my-5">Class Files.</h1>
            <?php
            if($role == "teacher"){
                ?>
                <div class="flex-grid-wrapper">
                    <form action="processor/uploadFileProcessor.php" method="post" enctype="multipart/form-data">
                        <div class="form-row">
                            <div>
                                <label for="fileUpload">Upload a file to Submit</label>
                                <input type="file" name="fileUpload" class="form-control" id="fileUpload">
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Upload File</button>
                        <br><br>
                    </form>
                </div>
                <?php
            }
            ?>
            <table class="table table-striped table-hover"
            <thead>
            <tr>
                <th scope="col">File</th>

                <?php
                if($role == "teacher"){
                    ?>
                    <th scope="col">Actions</th>
                    <?php
                }
                ?>

            </tr>
            </thead>
            <tbody>
            <?php
            $count = 1;
            //TODO: Add row potential join in sql to get if there is a submission for this student for this assignment and if so, put a field saying submitted
            foreach($rows as $row)
            {
//            var_dump($row);

                    $id = $row["id"];
                    $absolutePath = $row['file_path'];
                    $fileName = basename($row['file_path']);
                    ?>
                    <tr>
                        <td>
                            <a href="<?=$absolutePath?>" download>
                                <?= $fileName?>
                            </a>
                        </td>

                            <?php
                            if($role == "teacher"){
                                ?>
                                <td>
                                <a href="processor/deleteFileProcessor.php?id=<?= $id?>" class="btn btn-danger">Delete</a>
                                </td>
                                <?php
                            }
                            ?>
                            <!--                    <a href="editAssignment.php?id=--><?php //= $id?><!--" class="btn btn-warning">Edit</a>-->
                            <!--                    <a href="deleteAssignment.php?id=--><?php //= $id?><!--" class="btn btn-danger">Delete</a>-->

                    </tr>
                    <?php
                    $count++;

            }
            ?>
            </tbody>
            </table>
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