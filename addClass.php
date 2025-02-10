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
$sql2= "Select * from users where role = 'teacher'";
if($stmt2 = $pdo->prepare($sql2))
{
    if($stmt2->execute())
    {
        if($teacherRows =$stmt2->fetchAll())
        {
//            echo "success on teacher fetch";
        }
        else{
            echo "teacher fetch error";
        }
    }
    else{
        echo "teacher execute error";
    }
}
else{
    echo "prepare error";
}

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

$sql3 = "SELECT * FROM users WHERE role = 'student'";

if($stmt3 = $pdo->prepare($sql3)) {
// Bind variables to the prepared statement as parameters
// Attempt to execute the prepared statement
    if ($stmt3->execute()) {
        $rows = $stmt3->fetchAll();
        //echo 'acquired students';
    }
}

//var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Classes</title>
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
        <h1>Create Class:</h1>
        <form action="processor/addClassProcessor.php" method="post">
            <label for="cname">Class Name:</label><br>
            <input type="text" id="cname" name="cname" value="<?= $class_name?>"><br>
            <label for="sdate">Start Date:</label><br>
            <input type="date" name="sdate" id="sdate"><br>
            <label for="edate">End Date:</label><br>
            <input type="date" name="edate" id="edate"><br>
            <label for="term">Term: </label><br>
            <select name="term" id="term">
                <option value="Spring">Spring</option>
                <option value="Fall">Fall</option>
                <!-- TODO: Fix this to use a database table with population in php -->
            </select>
            <br>
            <label for="teacher">Teachers</label><br>
            <select name="teacher" id="teacher">
                <?php
                foreach($teacherRows as $teacher )
                {
                    $teacherFirst = $teacher['first_name'];
                    $teacherLast = $teacher['last_name'];
                    $teacherId = $teacher['id'];
                    ?>
                    <option <?php echo ($teacherId == $currentTeacherId) ? "selected=selected" : ""?> value="<?= $teacherId?>"><?= $teacherLast.", ".$teacherFirst?></option>
                    <?php
                }
                ?>
            </select>
            <input type="hidden" name="id" value="<?= $class_id ?>">
            <input type="submit" value="Submit">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">id#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Email</th>
                    <th scope="col">Add to</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $count = 1;
                foreach($rows as $row)
                {
                    $id = $row["id"];
                    ?>
                    <tr>
                        <th scope="row"><?= $id?></th>
                        <td><?= $row["first_name"] ?></td>
                        <td><?= $row["last_name"] ?></td>
                        <td><?= $row["email"] ?></td>
                        <td><input name = "students[]" value = "<?= $id?>" type ="checkbox"></td>
                    </tr>
                    <?php
                    $count++;
                }
                ?>
                </tbody>
            </table>
        </form>
    </div>


</main>
<!-- end .container -->
<!--       _
       .__(.)< (Connor did it!)
        \___)
~~~~~~~~~~~~~~~~~~-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script></body>
</html>