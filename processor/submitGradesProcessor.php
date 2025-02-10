<pre>
<?php
session_start();
require_once "../config.php";
$pdo = getDBConnection();
$assignmentId = array_pop($_POST);

echo "Assignment:$assignmentId\n";
echo "post ";
var_dump($_POST);
echo "get ";
var_dump($_GET);
try {
    foreach ($_POST as $key => $value) {
        echo "Working on student #$key\n";
        $sql = "update submission
    set grade = :grade
    where student_id = :student_id and assignment_id = :assignment_id";
        if ($stmt = $pdo->prepare($sql)) {
            echo "Statement prepared\n";
            $stmt->bindParam(":grade", $value, PDO::PARAM_INT);
            $stmt->bindParam(":student_id", $key, PDO::PARAM_INT);
            $stmt->bindParam(":assignment_id", $assignmentId, PDO::PARAM_INT);
            if ($stmt->execute()) {
                header("location: ../viewSubmissions.php?id=$assignmentId&status=Grade+Submitted");
            }
        }

        unset($sql);
        unset($stmt);
    }

}
catch (PDOException $e) {
    echo $e->getMessage();
}
//    if($stmt = $pdo->prepare($sql)){
//        echo "sql prepared\n";
//        $stmt->bindParam(":grade", $agrade);
//        $stmt->bindParam(":assignment_id", $assignmentId);
//        $stmt->bindParam(":student_id", $studentId);
//        if($stmt->execute()){
//            echo "stmt executed\n";
//            header("location: ../assignments.php?id=$assignmentId&status=Upload+Successful");
//        }
//        else{
//
//            header("location: ../assignments.php?id=$assignmentId&status=Failure+Uploading");
//        }
//    }





?>
    </pre>
