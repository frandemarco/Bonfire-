<?php
require_once "../config.php";
$pdo = getDBConnection();

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$role = $_POST["role"];
var_dump($_POST);
$sql="Insert into users(first_name, last_name, email, role)
values(:first_name, :last_name, :email, :role)";

if($stmt = $pdo->prepare($sql))
{
    $stmt->bindParam(":first_name", $fname, PDO::PARAM_STR);
    $stmt->bindParam(":last_name", $lname, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":role", $role, PDO::PARAM_STR);
    if($stmt->execute())
    {
        header("location: ../editUsers.php?status=Successfully%20added%20User");
    }
}

?>