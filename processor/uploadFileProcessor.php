<pre>
<?php
session_start();
require_once "../config.php";
$pdo = getDBConnection();
$classId = $_SESSION["currentclass"];
$fileSubmissionDir = "../class_data/$classId/files";

$tmp_name = $_FILES["fileUpload"]["tmp_name"];
$name = basename($_FILES["fileUpload"]["name"]);
$finalPath= "$fileSubmissionDir/$name";
if(move_uploaded_file($tmp_name, $finalPath)){
    $db_file_path ="class_data/$classId/files/$name";
    echo "file moved\n";
    $sql = "insert into files(file_path, class_id)
                values (:file_path, :class_id)";
    if($stmt = $pdo->prepare($sql)){
        echo "sql prepared\n";
        $stmt->bindParam(":file_path", $db_file_path);
        $stmt->bindParam(":class_id", $classId);
        if($stmt->execute()){
            echo "stmt executed\n";
            header("location: ../classFiles.php?status=Added%20File%20Successfully");
        }
        else{

            header("location: ../classFiles.php?status=Failed%20Adding%20File");
        }
    }
    else{
        header("location: ../classFiles.php?status=Failed%20Adding%20File");
    }
}
else{
    header("location: ../classFiles.php?status=Failure+Uploading");
}



?>
    </pre>
