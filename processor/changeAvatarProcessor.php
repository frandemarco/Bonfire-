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

        $userid = $_POST["userid"];
        if (is_uploaded_file($_FILES["avatar"]["tmp_name"])) {
            var_dump($_FILES["avatar"]);
            var_dump($_POST);
            move_uploaded_file($_FILES["avatar"]["tmp_name"], "../avatars/user-$userid.jpg");
            header("location: ../profile.php?status=Successfully%20Changed%20Avatar%20for&userid=$userid"); //add a parameter here with a success statmenet
        } else {
            print "Error: test file not uploaded";
        }

        ?>

    </pre>
</body>
</html>