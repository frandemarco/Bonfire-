<pre>
<?php
    session_start();
    require_once "../config.php";
    $pdo = getDBConnection();
    $studentId = $_POST["studentId"];
    $assignmentId = $_POST["aID"];
    $classId = $_SESSION["currentclass"];
    $studentSubmissionDir = "../class_data/$classId/assignments/assignment_$assignmentId/student_$studentId";

    if(mkdir($studentSubmissionDir, 0777, true)){
        echo "folder created\n";
    }
        //For trying to do multiple file uploads on an assignment
//        foreach ($_FILES["fileUpload"]["error"] as $key => $error) {
//            if ($error == UPLOAD_ERR_OK) {
//                $tmp_name = $_FILES["fileUpload"]["tmp_name"][$key];
//                $name = basename($_FILES["fileUpload"]["name"][$key]);
//                move_uploaded_file($tmp_name, "$studentSubmissionDir/$name");
//            }
//        }
    $tmp_name = $_FILES["fileUpload"]["tmp_name"];
    $name = basename($_FILES["fileUpload"]["name"]);
    $finalPath= "$studentSubmissionDir/$name";
    if(move_uploaded_file($tmp_name, $finalPath)){
        $db_file_path ="class_data/$classId/assignments/assignment_$assignmentId/student_$studentId/$name";
        echo "file moved\n";
        $sql = "insert into submission(assignment_id, student_id, file_path)
                values (:assignment_id, :student_id, :file_path)";
        if($stmt = $pdo->prepare($sql)){
            echo "sql prepared\n";
            $stmt->bindParam(":assignment_id", $assignmentId);
            $stmt->bindParam(":student_id", $studentId);
            $stmt->bindParam(":file_path", $db_file_path);
            if($stmt->execute()){
                echo "stmt executed\n";
                header("location: ../viewAssignment.php?id=$assignmentId&status=Upload+Successful");
            }
            else{

                header("location: ../viewAssignment.php?id=$assignmentId&status=Failure+Uploading");
            }
        }
        else{
            header("location: ../viewAssignment.php?id=$assignmentId&status=Failure+Uploading");
        }
    }
    else{
        header("location: ../viewAssignment.php?id=$assignmentId&status=Failure+Uploading");
    }



?>
    </pre>
