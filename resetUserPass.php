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
$sql = "SELECT * FROM users where id = :id";

if($stmt = $pdo->prepare($sql)) {
// Bind variables to the prepared statement as parameters
    $stmt->bindParam(":id", $userID, PDO::PARAM_INT);
    $userID = $_GET["id"];
// Attempt to execute the prepared statement

    if ($stmt->execute()) {
        if($stmt->rowCount() == 1){
            if($row = $stmt->fetch()) {
                $id = $row["id"];
                $email = $row["email"];
                $fname = $row["first_name"];
                $lname = $row["last_name"];
                $userRole = $row["role"];
            }
        }
    }
}

//var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
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
    <div id="primary-window" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark ">
        <h1>Change Personal Information:</h1>
        <form action="processor/resetPassProcessor.php" method="post">
            <label for="pass">Password</label><br>
            <input type="text" id="pass" name="pass" value=""><br>
            <input type="hidden" name="id" value="<?= $id ?>">

            <input class ="btn btn-primary" type="submit" value="Submit">
        </form>
        <button class = "btn btn-info" id="generate" onclick="generate();" style="width:15rem;margin-left:auto;margin-right:auto">Generate Password</button>
    </div>

</main>
<!-- end .container -->
<!--       _
<!-       .__(.)< (Connor did it!)
<!-        \___)
<!-~~~~~~~~~~~~~~~~~-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script></body>
<script>
    function generate(){
        let field = document.getElementById('pass');
        let characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghiklmnopqrstuvwxyz!$#*?@";
        let randomPass = '';
        for(let i = 0;i<12;i++)
        {
            let randomIndex = parseInt(Math.random()*characters.length);
            randomPass+=characters[randomIndex];
        }
        console.log(randomPass);
        field.value = randomPass;
    }
</script>
</html>
