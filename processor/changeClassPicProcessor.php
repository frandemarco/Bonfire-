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
//        echo "Preparing to upload class pic";
        $classid = $_POST["class_id"];
//        echo "Class ID AQUIRED";

        if (is_uploaded_file($_FILES["avatar"]["tmp_name"])) {
            var_dump($_FILES["avatar"]);
            var_dump($_POST);
            move_uploaded_file($_FILES["avatar"]["tmp_name"], "../classpic/class-$classid.jpg");
            header("location: ../classSettings.php?status=Successfully%20Changed%20Picture%20for%20&classid=$classid"); //add a parameter here with a success statmenet
        } else {
            print "Error: test file not uploaded";
            var_dump($_FILES["avatar"]);

        }

        ?>
<!--    --><?php //=$classid?>
    </pre>
</body>
</html>