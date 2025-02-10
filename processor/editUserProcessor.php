<?php
    require_once "../config.php";
    $pdo = getDBConnection();

    $id = $_POST["id"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    $sql="UPDATE users
          SET first_name = :first_name,
              last_name = :last_name,
              email = :email,
              role = :role
          WHERE id = :id";

    if($stmt = $pdo->prepare($sql))
    {
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":first_name", $fname, PDO::PARAM_STR);
        $stmt->bindParam(":last_name", $lname, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":role", $role, PDO::PARAM_STR);
        if($stmt->execute())
        {
            header("location: ../editUsers.php?status=User%20Successfully%20Edited");
        }else{
            header("location: ../editUsers.php?status=Failed%20Editing%20Class");
        }
    }
?>