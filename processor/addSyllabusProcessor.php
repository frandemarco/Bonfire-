<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <pre>
        <?php

        $classid = $_POST["classid"];
        if (is_uploaded_file($_FILES["syllabus"]["tmp_name"])) {
            var_dump($_FILES["syllabus"]);
            var_dump($_POST);
            // var_dump($_SESSION);
            $uploadPath = "../class_data/$classid/syllabus.pdf";
            echo "uploading to: $uploadPath";
            move_uploaded_file($_FILES["syllabus"]["tmp_name"], $uploadPath);
            header("location: ../syllabus.php?status=Successfully%20add%20to&classid=$classid"); //add a parameter here with a success statmenet
        } else {
            print "Error: test file not uploaded";
        }

        ?>

    </pre>
</body>
</html>