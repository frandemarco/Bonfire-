<?php
// Initialize the session
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$studentId = $_SESSION["id"];
$firstName = htmlspecialchars($_SESSION["first_name"]);
$role = $_SESSION["role"];

$pdo = getDBConnection();
$sql = "SELECT * FROM assignments where id = :id";

if($stmt = $pdo->prepare($sql)) {
// Bind variables to the prepared statement as parameters
    $stmt->bindParam(":id", $aID, PDO::PARAM_INT);
    $aID = $_GET["id"];
// Attempt to execute the prepared statement

    if ($stmt->execute()) {
        if($stmt->rowCount() == 1){
            if($row = $stmt->fetch()) {
                $id = $row["id"];
                $asname = $row["assignment_name"];
                $mgrade = $row["max_grade"];
                $descr = $row["description"];
                $ddate = $row["due_date"];
                $categ = $row["category"];
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $className ?> View Assignment</title>
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
    <div id="primary-window" style="margin:auto" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark overflow-y-scroll">
        <h1 class="my-5">View Assignment</h1>
        <div>
            <?php
                $currentClass = $_SESSION['currentclass'];
                $studentsUploadPath = "class_data/$currentClass/assignments/assignment_$aID/student_$studentId/";
                $submissions = glob("$studentsUploadPath/*");
                if(count($submissions) > 0){
                    ?>
                <h1>You have already submitted this assignment</h1>
            <?php
                }
                else{


            ?>

            <form action="processor/submissionProcessor.php" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div style="margin:auto"  class="form-group col-md-6">
                        <label for="inputAssignment">Assignment Name</label>
                        <input type="text" name="inputAssignment" class="form-control" id="inputAssignment" value="<?= $asname?>" readonly>
                    </div>
                    <div style="margin:auto"  class="form-group col-md-6">
                        <label for="inputMaxGrade">Maximum Grade</label>
                        <input type="number" name="inputMaxGrade" class="form-control" id="inputMaxGrade" value="<?= $mgrade?>" readonly>
                    </div>
                    <div style="margin:auto"  class="form-group col-md-6">
                        <label for="inputDescription">Description</label>
                        <textarea name="inputDescription" class="form-control" id="inputDescription" placeholder="<?php echo htmlspecialchars($descr); ?>" rows="5" cols="40" readonly></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div style="margin:auto"  class="form-group col-md-6">
                        <label for="inputDueDate">Due Date</label>
                        <input type="datetime-local" name = "inputDueDate" class="form-control" id="inputDueDate" value="<?= $ddate?>" readonly>
                    </div>
                    <div style="margin:auto"  class="form-group col-md-6">
                        <label for="inputAssignment">Assignment Category</label>
                        <input type="text" name="inputAssignment" class="form-control" id="inputAssignment" value="<?= $categ?>" readonly>
                    </div>
                    <div>
                        <label for="fileUpload">Upload a file to Submit</label>
                        <input type="file" name="fileUpload" class="form-control" id="fileUpload">
                    </div>
                </div>
                <br>
                <input type="hidden" name="aID" value="<?= $aID ?>">
                <input type="hidden" name="studentId" value="<?= $studentId ?>">
                <button type="submit" class="btn btn-primary">Submit Assignment</button>
            </form>
            <?php
                }
            ?>
        </div>
    </div>

</main>
<!-- end .container -->
<!--       _
       .__(.)< (Connor did it!)
        \___)
~~~~~~~~~~~~~~~~~~-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="resources/scripts/popups.js">
    // let params = new URLSearchParams(location.search);
    // let status = params.get('status');
    // if(status!==null)
    //     alert(status);
</script>
</body>
</html>

