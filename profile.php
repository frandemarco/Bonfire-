<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if(isset($_GET["userid"]))
{
    $_SESSION["currentuser"] = $_GET["userid"];
}
$firstName = htmlspecialchars($_SESSION["first_name"]);
$lasName = htmlspecialchars($_SESSION["last_name"]);
$Email = htmlspecialchars($_SESSION["email"]);
$role = $_SESSION["role"];
//var_dump($_SESSION);
require_once ('config.php');
$pdo =getDBConnection();
$sql = "Select * from users where id = :id";
if($stmt=$pdo->prepare($sql))
{
    $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
    $param_id  = $_GET["userid"];
    if($stmt->execute())
    {
        if($stmt->rowCount() == 1) {
            if ($row = $stmt->fetch()) {
                $fname = $row["first_name"];
                $lname = $row["last_name"];
                $email = $row["email"];
                $currentid = $row['id'];
            }
        }
    }
}

$imageString = "avatars/user-$param_id.jpg";
if(file_exists($imageString))
{
    $profileImage = $imageString;
}
else{
    $profileImage = "avatars/default.jpg";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $firstName; ?>'s Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="resources/stylesheets/style.css">
    <link rel="stylesheet" href="resources/stylesheets/inputfield.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<?php include("svgImages.html"); ?>
<main class="d-flex flex-nowrap">
    <?php include("leftSideMenu.php"); ?>
    <div id="primary-window" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark">
        <h1 class="my-5">Hi, <b><?= $row["first_name"] ?></b>. Welcome to your profile.</h1>

        <img src="<?= $profileImage?>" alt="" width="350" height="350" class="rounded-circle" id="profilepic">
        <form action="processor/editUserProcessor.php" method="post" >
            <label class="user-firstname" for="fname">First name:</label><br>
            <input class ="user-information-fname" type="text" id="fname" name="fname" value="<?= $row["first_name"] ?>" ><br>
            <label class="user-lastname" for="lname">Last name:</label><br>
            <input class ="user-information-lname" type="text" id="lname" name="lname" value="<?= $row["last_name"] ?> " disabled ><br>
            <label class="user-email" for="email">Email:</label><br>
            <input class ="user-information-email" type="text" id="email" name="email" value="<?= $row["email"] ?>"  disabled><br><br>
            <input type="hidden" name="id" value="<?= $currentid ?>">
        </form>
        <form action="processor/changeAvatarProcessor.php" method="post" enctype="multipart/form-data">
            <label for="avatar">Upload a jpeg as your avatar:</label>
            <input type="file" name="avatar" type="image/jpg"/>
            <input type="hidden" name="userid" value="<?= $currentid ?>">
            <input type="submit" value="Upload"/>
        </form>
        <p>
            <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
            <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        </p>
    </div>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="resources/scripts/popups.js">
    // let params = new URLSearchParams(location.search);
    // let status = params.get('status');
    // if(status!==null)
    //     alert(status);
</script>
</body>
<!-- end .container -->
<!--       _
       .__(.)< (Connor did it!)
        \___)
~~~~~~~~~~~~~~~~~~-->
</html>