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
$assignmentId = $_GET['id'];
$pdo = getDBConnection();
$sql = "SELECT * FROM submission s
         join users u on s.student_id = u.id
         WHERE assignment_id = :assignment_id";

if($stmt = $pdo->prepare($sql)) {
// Bind variables to the prepared statement as parameters
// Attempt to execute the prepared statement
    $stmt->bindParam(":assignment_id", $assignmentId);
    if ($stmt->execute()) {
        $rows = $stmt->fetchAll();
    }
}
//var_dump($stmt);

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
    <title><?= $className ?> View Subbmission</title>
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
        <div id="primary-window " class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark overflow-y-scroll">
            <h1 class="my-5">Submissions</h1>
            <form action="processor/submitGradesProcessor.php" method="post">
            <table class="table table-striped table-hover"
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Sid</th>
                <th scope="col">Last Name</th>
                <th scope="col">First Name</th>
                <th scope="col">File</th>
                <th scope="col">Status</th>
                <th scope="col">Grade</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $count = 1;
            //TODO: Add row potential join in sql to get if there is a submission for this student for this assignment and if so, put a field saying submitted
            foreach($rows as $row)
            {
                $id=$row["id"];
                $absolutePath = $row['file_path'];
                $fileName = basename($row['file_path']);
                ?>
                <tr>
                    <td><?=$count?></td>
                    <td><?= $row["id"] ?></td>
                    <td><?= $row["last_name"] ?></td>
                    <td><?= $row["first_name"] ?></td>
                    <td>
                        <a href="<?=$absolutePath?>" download>
                            <?= $fileName?>
                        </a>
                    </td>
                    <td><?= $row["grade"]==-1 ? "Not Graded" : "Grade Submitted" ?></td>
                    <td>
<!--                        TODO Make max pull the max grade from the db-->
                        <input type="number" name="<?= $row['id']?>" id="grade" min="0" max = "100" value="<?= $row['grade'] != -1 ? $row['grade'] : ''?>"
                    </td>
                </tr>
                <?php
                $count++;
            }
            ?>
            </tbody>
            </table>
                <input type="hidden" name="aID" value="<?= $assignmentId ?>">
                <input type="submit" value="Submit Grades">
            </form>
            <a href = "downloadAllAssignments.php?class=<?=$classid?>&assignment=<?=$assignmentId?>" target="_blank">Download All Assignments</a>
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