<?php
    require_once "../config.php";
    $pdo = getDBConnection();

    $id = $_POST["id"];
    $pass = $_POST["pass"];


    $sql="UPDATE users
          SET password = :password
          WHERE id = :id";

    if($stmt = $pdo->prepare($sql))
    {
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
        $stmt->bindParam(":password", $hashedPass, PDO::PARAM_STR);
        if($stmt->execute())
        {
            header("location: ../editUsers.php?status=Password%20Successfully%20Reset");
        }else{
            header("location: ../editUsers.php?status=Failed%20Resetting%20Password");
        }
    }
?>